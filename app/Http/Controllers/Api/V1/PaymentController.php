<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GatewayResource;
use App\Models\Deposit;
use App\Models\ManagePlan;
use App\Models\ManageTime;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use App\Traits\PaymentValidationCheck;
use App\Traits\Upload;
use App\Models\Fund;
use App\Models\Gateway;
use Carbon\Carbon;
use Facades\App\Services\BasicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    use ApiValidation, Upload, Notify ,PaymentValidationCheck;

    public function paymentGateways()
    {
        try {
            $data['baseCurrency'] = basicControl()->base_currency;
            $data['baseSymbol'] =  basicControl()->currency_symbol;
            $data['gateways'] = GatewayResource::collection(Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get());
            return $this->withSuccess($data);
        } catch (\Exception $e) {
            return $this->withErrors($e->getMessage());
        }
    }
    public function planBuy(Request $request)
    {
        // validation rules
        $rules = [
            'amount' => 'required|numeric',
            'plan_id' => 'required',
            'supported_currency' => 'nullable',
            'supported_crypto_currency' => 'nullable',
            'gateway_id' => 'required'
        ];

        // validate request
        $validator = Validator::make($request->all(), $rules);

        //if validation failed then return back with validation error message
        if ($validator->fails()) {
            return $this->jsonError(collect($validator->errors())->collapse(),422);
        }


        if (!$request->supported_currency && !$request->supported_crypto_currency){
            return $this->jsonError('supported currency is required',422);
        }

        // get plan
        $plan_id = $request->plan_id;
        $plan = ManagePlan::where('id', $plan_id)->where('status', 1)->first();

        // if plan not found then return
        if (!$plan){
            return $this->jsonError('Plan not found');
        }
        $amount = $request->amount;
        // check request amount and plan price
        if ($plan->fixed_amount == '0' && $amount < $plan->minimum_amount) {
            return response()->json($this->withErrors("Invest Limit " . $plan->price));
        } elseif ($plan->fixed_amount == '0' && $amount > $plan->maximum_amount) {
            return response()->json($this->withErrors("Invest Limit " . $plan->price));
        } elseif ($plan->fixed_amount != '0' && $amount != $plan->fixed_amount) {
            return response()->json($this->withErrors("Please invest " . $plan->price));
        }

        $gateway = $request->gateway_id;
        $currency = $request->supported_currency;
        $cryptoCurrency = $request->supported_crypto_currency;

        // validate payment
        $checkAmountValidate = $this->validationCheck($amount, $gateway, $currency, $cryptoCurrency,'payment');

        if ($checkAmountValidate['status'] == 'error') {
            return $this->jsonError($checkAmountValidate['msg']);
        }

        $deposit = $this->createPayment($checkAmountValidate);

        $plan->depositable()->save($deposit);
        return response()->json($this->jsonSuccess(['trx_id' => $deposit->trx_id],'Payment Created Successfully'));
    }


    public function deposit(Request $request)
    {
        $rules = [
            'amount' => 'required',
            'gateway_id' => 'required',
            'supported_currency' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if (empty($request->supported_crypto_currency) && empty($value)) {
                        $fail('Either Supported Currency or Supported Crypto Currency is required.');
                    }
                },
            ],
            'supported_crypto_currency' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if (empty($request->supported_currency) && empty($value)) {
                        $fail('Either Supported Crypto Currency or Supported Currency is required.');
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonError(collect($validator->errors())->collapse());
        }

        if (!isset($request->supported_currency) && !isset($request->supported_crypto_currency)){
            return response()->json($this->jsonError('Either Supported Crypto Currency or Supported Currency is required.',400));
        }

        $amount = $request->amount;
        $gateway = $request->gateway_id;
        $currency = $request->supported_currency??'';
        $cryptoCurrency= $request->supported_crypto_currency;
        try {
            $checkAmountValidate = $this->validationCheck($amount, $gateway, $currency, $cryptoCurrency);

            if ($checkAmountValidate['status'] == 'error') {
                return back()->with('error', $checkAmountValidate['msg']);
            }

            $deposit = Deposit::create([
                'user_id' => Auth::user()->id,
                'depositable_type' => 'App\Models\Deposit',
                'payment_method_id' => $checkAmountValidate['data']['gateway_id'],
                'payment_method_currency' => $checkAmountValidate['data']['currency'],
                'amount' => $amount,
                'percentage_charge' => $checkAmountValidate['data']['percentage_charge'],
                'fixed_charge' => $checkAmountValidate['data']['fixed_charge'],
                'payable_amount' => $checkAmountValidate['data']['payable_amount'],
                'base_currency_charge' => $checkAmountValidate['data']['base_currency_charge'],
                'payable_amount_in_base_currency' => $checkAmountValidate['data']['payable_amount_base_in_currency'],
                'status' => 0,
            ]);

            return $this->jsonSuccess(['trx_id' =>$deposit->trx_id],'Payment Create Successfully',200);

        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(),500);
        }

    }

    public function createPayment($checkAmountValidate)
    {
        // create payment
        $deposit = Deposit::create([
            'user_id' => Auth::id(),
            'payment_method_id' => $checkAmountValidate['data']['gateway_id'],
            'payment_method_currency' => $checkAmountValidate['data']['currency'],
            'amount' => $checkAmountValidate['data']['amount'],
            'percentage_charge' => $checkAmountValidate['data']['percentage_charge'],
            'fixed_charge' => $checkAmountValidate['data']['fixed_charge'],
            'payable_amount' => $checkAmountValidate['data']['payable_amount'],
            'base_currency_charge' => $checkAmountValidate['data']['base_currency_charge'],
            'payable_amount_in_base_currency' => $checkAmountValidate['data']['payable_amount_base_in_currency'],
            'status' => 0,
        ]);
        return $deposit;
    }
    public function paymentWebview(Request $request)
    {
        if (!isset($request->trx_id) || empty($request->trx_id)) {
            return response()->json($this->withErrors('Transaction ID is required'));
        }

        $deposit = Deposit::with('user', 'depositable')->where(['trx_id' => $request->trx_id, 'status' => 0])->first();
        if (!$deposit) {
            return response()->json($this->withErrors('Invalid Payment Request'));
        }

        $val['url'] = route('paymentView', $deposit->id);
        return response()->json($this->withSuccess($val));
    }
    public function manualPayment(Request $request, $trx_id=null)
    {
        $data = Deposit::where('trx_id', $trx_id)->orderBy('id', 'DESC')->with(['gateway', 'user'])->first();
        if (is_null($data)) {
            return response()->json($this->withErrors('Invalid Request'));
        }

        $params = optional($data->gateway)->parameters;
        $reqData = $request->except('_token', '_method');
        $rules = [];

        if (is_array($params)) {
            foreach ($params as $key => $cus) {
                if (is_object($cus)) {
                    $validationRule = ($cus->validation == 'required') ? 'required' : 'nullable';
                    $rules[$key] = [$validationRule];
                    if ($cus->type === 'file') {
                        $rules[$key][] = 'image';
                        $rules[$key][] = 'mimes:jpeg,jpg,png';
                        $rules[$key][] = 'max:2048';
                    } elseif ($cus->type === 'text') {
                        $rules[$key][] = 'max:191';
                    } elseif ($cus->type === 'number') {
                        $rules[$key][] = 'integer';
                    } elseif ($cus->type === 'textarea') {
                        $rules[$key][] = 'min:3';
                        $rules[$key][] = 'max:300';
                    }
                }
            }
        }

        $validator = Validator::make($reqData, $rules);

        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()));
        }

        $reqField = [];
        if ($params != null) {
            foreach ($request->except('_token', '_method', 'type') as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k == $inKey) {
                        if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                            try {
                                $file = $this->fileUpload($request[$inKey], config('filelocation.deposit.path'), null, null, 'webp', 80);
                                $reqField[$inKey] = [
                                    'field_name' => $inVal->field_name,
                                    'field_value' => $file['path'],
                                    'field_driver' => $file['driver'],
                                    'validation' => $inVal->validation,
                                    'type' => $inVal->type,
                                ];
                            } catch (\Exception $exp) {
                                return response()->json($this->withErrors(" Could not upload your {$inKey} "));
                            }
                        } else {
                            $reqField[$inKey] = [
                                'field_name' => $inVal->field_name,
                                'validation' => $inVal->validation,
                                'field_value' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
        }

        $data->update([
            'information' => $reqField,
            'created_at' => Carbon::now(),
            'status' => 2,
        ]);

        $msg = [
            'username' => optional($data->user)->username,
            'amount' => currencyPosition($data->amount),
            'gateway' => optional($data->gateway)->name
        ];
        $action = [
            "name" => optional($data->user)->firstname . ' ' . optional($data->user)->lastname,
            "image" => getFile(optional($data->user)->image_driver, optional($data->user)->image),
            "link" => route('admin.user.payment', $data->user_id),
            "icon" => "fa fa-money-bill-alt text-white"
        ];

        $this->adminPushNotification('PAYMENT_REQUEST', $msg, $action);
        $this->adminFirebasePushNotification('PAYMENT_REQUEST', $msg, $action);
        $this->adminMail('PAYMENT_REQUEST', $msg);

        return response()->json($this->withSuccess('You request has been taken.'));
    }
    public function paymentDone(Request $request)
    {
        if (!isset($request->trx_id) || empty($request->trx_id)) {
            return response()->json($this->withErrors('Transaction ID is required'));
        }
        $deposit = Deposit::with('user', 'depositable')->where(['trx_id' => $request->trx_id, 'status' => 0])->first();
        if (!$deposit) {
            return response()->json($this->withErrors('Invalid Payment Request'));
        }
        BasicService::preparePaymentUpgradation($deposit);
        return response()->json($this->withSuccess('Payment has been complete'));
    }

    public function cardPayment(Request $request)
    {
        $rules = [
            'trx_id' => 'required',
            'card_number' => 'required',
            'card_name' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            'card_cvc' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $deposit = Deposit::with('user', 'depositable')->where(['trx_id' => $request->trx_id, 'status' => 0])->first();
        if (!$deposit) {
            return response()->json($this->withErrors('Invalid Payment Request'));
        }


        $getwayObj = 'App\\Services\\Gateway\\' . $deposit->gateway->code . '\\Payment';
        $data = $getwayObj::mobileIpn($request, $deposit->gateway, $deposit);
        if ($data == 'success') {
            return response()->json($this->withSuccess('Payment has been complete'));
        } else {
            return response()->json($this->withErrors('unsuccessful transaction.'));
        }
    }

    public function paymentView($deposit_id)
    {
        $deposit = Deposit::latest()->find($deposit_id);
        try {
            if ($deposit) {
                $getwayObj = 'App\\Services\\Gateway\\' . $deposit->gateway->code . '\\Payment';
                $data = $getwayObj::prepareData($deposit, $deposit->gateway);
                $data = json_decode($data);

                if (isset($data->error)) {
                    $result['status'] = false;
                    $result['message'] = $data->message;
                    return response($result, 200);
                }

                if (isset($data->redirect)) {
                    return redirect($data->redirect_url);
                }

                if ($data->view) {
                    $parts = explode(".", $data->view);
                    $desiredValue = end($parts);
                    $newView = 'mobile-payment.' . $desiredValue;
                    return view($newView, compact('data', 'deposit'));
                }

                abort(404);
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }
}
