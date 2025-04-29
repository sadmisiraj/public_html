<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\ManagePlan;
use App\Traits\Notify;
use App\Traits\PaymentValidationCheck;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Facades\App\Services\BasicService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PaymentController extends Controller
{

    use Upload, Notify,PaymentValidationCheck;

    public function __construct()
    {
        $this->theme = template();
    }

    public function checkAmount(Request $request)
    {

        $amount = $request->amount;
        $selectedCurrency = $request->selected_currency;
        $selectGateway = $request->select_gateway;
        $selectedCryptoCurrency = $request->selectedCryptoCurrency;
        $data = $this->validationCheck($amount,$selectGateway ,$selectedCurrency , $selectedCryptoCurrency,'payment');
        return response()->json($data);
    }

    public function depositConfirm($trx_id)
    {
        try {
            $deposit = Deposit::with('user', 'depositable')->where(['trx_id' => $trx_id, 'status' => 0])->first();
            if (!$deposit) {
                throw new Exception('Invalid Payment Request.');
            }
            $gateway = Gateway::findOrFail($deposit->payment_method_id);
            if (!$gateway) {
                throw new Exception('Invalid Payment Gateway.');
            }

            if (999 < $gateway->id) {
                return view(template() . 'user.payment.manual', compact('deposit'));
            }

            $gatewayObj = 'App\\Services\\Gateway\\' . $gateway->code . '\\Payment';
            $data = $gatewayObj::prepareData($deposit, $gateway);
            $data = json_decode($data);
            if (isset($data->error)) {
                return back()->with('error', $data->message);
            }

            if (isset($data->redirect)) {
                return redirect($data->redirect_url);
            }

            $page_title = 'Payment Confirm';
            return view(template() . $data->view, compact('data', 'page_title', 'deposit'));

        } catch (Exception $exception) {
            session()->flash('warning', 'Something went wrong. Please try again.');
            return back()->with('error', $exception->getMessage());
        }
    }

    public function gatewayIpn(Request $request, $code, $trx = null, $type = null)
    {
        if (isset($request->m_orderid)) {
            $trx = $request->m_orderid;
        }

        if ($code == 'coinbasecommerce') {
            $gateway = Gateway::where('code', $code)->first();
            $postdata = file_get_contents("php://input");
            $res = json_decode($postdata);

            if (isset($res->event)) {
                $deposit = Deposit::with('user')->where('trx_id', $res->event->data->metadata->trx)->orderBy('id', 'DESC')->first();
                $sentSign = $request->header('X-Cc-Webhook-Signature');
                $sig = hash_hmac('sha256', $postdata, $gateway->parameters->secret);

                if ($sentSign == $sig) {
                    if ($res->event->type == 'charge:confirmed' && $deposit->status == 0) {
                        BasicService::preparePaymentUpgradation($deposit);
                    }
                }
            }
            session()->flash('success', 'You request has been processing.');

            return redirect()->route('success');
        }

        try {
            $gateway = Gateway::where('code', $code)->first();
            if (!$gateway) {
                throw new Exception('Invalid Payment Gateway.');
            }
            if (isset($trx)) {
                $deposit = Deposit::with('user')->where('trx_id', $trx)->first();
                if (!$deposit) throw new Exception('Invalid Payment Request.');
            }

            $gatewayObj = 'App\\Services\\Gateway\\' . $code . '\\Payment';
            $data = $gatewayObj::ipn($request, $gateway, $deposit ?? null, $trx ?? null, $type ?? null);

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
        if (isset($data['redirect'])) {
            return redirect($data['redirect'])->with($data['status'], $data['msg']);
        }
    }


    public function fromSubmit(Request $request, $trx_id)
    {
        $data = Deposit::where('trx_id', $trx_id)->orderBy('id', 'DESC')->with(['gateway', 'user'])->first();
        if (is_null($data)) {
            return redirect()->route('page')->with('error', 'Invalid Request');
        }
        if ($data->status != 0) {
            return redirect()->route('page')->with('error', 'Invalid Request');
        }

        $params = optional($data->gateway)->parameters;
        $reqData = $request->except('_token', '_method');
        $rules = [];
        if ($params !== null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
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

        $validator = Validator::make($reqData, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $reqField = [];
        if ($params != null) {
            foreach ($request->except('_token', '_method', 'type') as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k == $inKey) {
                        if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                            try {
                                $file = $this->fileUpload($request[$inKey], config('filelocation.deposit.path'), config('filesystems.default'), null, null, null, null, 40);
                                $reqField[$inKey] = [
                                    'field_name' => $inVal->field_name,
                                    'field_value' => $file['path'],
                                    'field_driver' => $file['driver'],
                                    'validation' => $inVal->validation,
                                    'type' => $inVal->type,
                                ];
                            } catch (\Exception $exp) {
                                session()->flash('error', 'Could not upload your ' . $inKey);
                                return back()->withInput();
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
            'amount' => currencyPosition($data->amount+0),
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
        session()->flash('success', 'You request has been taken.');
        return redirect()->route('user.fund.index');

    }

    public function success()
    {
        return view('success');
    }

    public function failed()
    {
        return view('failed');
    }


    public function payment(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'gateway' => 'required',
            'supported_currency' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $basic = basicControl();
        $plan_id =  decrypt(session()->get('plan_id'));
        $amount = decrypt(session()->get('amount'));

        $plan = null;
        if ($plan_id){
            $plan = ManagePlan::where('id', $plan_id)->where('status', 1)->first();
        }

        $gateway = $request->gateway;
        $currency = $request->supported_currency;
        $cryptoCurrency = $request->supported_crypto_currency;

        try {
            if ($amount && $plan){
                $checkAmountValidate = $this->validationCheck($amount, $gateway, $currency, $cryptoCurrency,'payment');
                if ($checkAmountValidate['status'] == 'error') {
                    return back()->with('error', $checkAmountValidate['msg']);
                }
                $deposit = Deposit::create([
                    'user_id' => Auth::user()->id,
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

                $plan->depositable()->save($deposit);

                return redirect(route('payment.process', $deposit->trx_id));

            }
        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }

    }

}
