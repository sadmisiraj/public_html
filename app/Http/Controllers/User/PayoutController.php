<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\PayoutMethod;
use App\Models\UserBankDetail;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class PayoutController extends Controller
{

    use Upload, Notify;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function index(Request $request)
    {
        $trx_id = null;
        if (isset($request->trx_id) && $request->trx_id) {
            $trx_id = $request->trx_id;
        }
        $status = null;
        if (isset($request->status)) {
            $status = $request->status;
        }
        $dateSearch = null;
        if (isset($request->date_time) && $request->date_time) {
            $dateSearch = $request->date_time;
            $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        }

        $payouts = Payout::with('user')
            ->where(['user_id' => Auth::id()])
            ->when(isset($trx_id) && $trx_id,function ($q) use ($trx_id){
                return $q->where('trx_id', $trx_id);
            })
            ->when(isset($status) && $status !== 0 && $status !== 'all',function ($q) use ($status){
                return $q->where('status', $status);
            })
            ->when(isset($dateSearch) && $dateSearch,function ($q) use ($dateSearch){
                return $q->whereDate('created_at', $dateSearch);
            })
            ->orderBy('id', 'desc')->paginate(basicControl()->paginate);
        return view(template() . 'user.payout.index', compact('payouts'));
    }

    public function payout()
    {
        $data['basic'] = basicControl();
        $data['payoutMethod'] = PayoutMethod::where('is_active', 1)->get();
        $data['bankDetails'] = Auth::user()->bankDetails;
        
        // Check if the bank details are verified
        if ($data['bankDetails'] && !$data['bankDetails']->is_verified) {
            $data['bankDetailsWarning'] = 'Your bank account is pending verification. You can still withdraw, but it may take longer to process.';
        }
        
        return view(template() . 'user.payout.request', $data);
    }

    public function payoutSupportedCurrency(Request $request)
    {
        $gateway = PayoutMethod::where('id', $request->gateway)->firstOrFail();
        return $gateway->supported_currency;
    }

    public function checkAmount(Request $request)
    {
        if ($request->ajax()) {
            $amount = $request->amount;
            $selectedCurrency = $request->selected_currency;
            $selectedPayoutMethod = $request->selected_payout_method;
            $data = $this->checkAmountValidate($amount, $selectedCurrency, $selectedPayoutMethod);
            return response()->json($data);
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function checkAmountValidate($amount, $selectedCurrency, $selectedPayoutMethod)
    {
        $selectedPayoutMethod = PayoutMethod::where('id', $selectedPayoutMethod)->where('is_active', 1)->first();

        if (!$selectedPayoutMethod) {
            return ['status' => false, 'message' => "Payment method not available for this transaction"];
        }

        // For Bank Account, always use INR
        if ($selectedPayoutMethod->name === 'Bank Account') {
            $selectedCurrency = 'INR';
            $selectedPayCurrency = 'INR';
            
            \Log::info('Bank account currency set to INR', [
                'method_name' => $selectedPayoutMethod->name,
                'amount' => $amount
            ]);
        } else {
            $selectedCurrency = array_search($selectedCurrency, $selectedPayoutMethod->supported_currency);

            if ($selectedCurrency !== false) {
                $selectedPayCurrency = $selectedPayoutMethod->supported_currency[$selectedCurrency];
            } else {
                return ['status' => false, 'message' => "Please choose the currency you'd like to use for payment"];
            }
        }

        if ($selectedPayoutMethod) {
            $payoutCurrencies = $selectedPayoutMethod->payout_currencies;
            if (is_array($payoutCurrencies)) {
                if ($selectedPayoutMethod->is_automatic == 1) {
                    $currencyInfo = collect($payoutCurrencies)->where('name', $selectedPayCurrency)->first();
                } else {
                    $currencyInfo = collect($payoutCurrencies)->where('currency_symbol', $selectedPayCurrency)->first();
                }
                
                // If Bank Account and no currency info found, try to find INR
                if ($selectedPayoutMethod->name === 'Bank Account' && !$currencyInfo) {
                    \Log::info('Searching for INR currency configuration in Bank Account method');
                    
                    // First, try to find by currency_symbol
                    $currencyInfo = collect($payoutCurrencies)->where('currency_symbol', 'INR')->first();
                    
                    // If not found, try by name
                    if (!$currencyInfo) {
                        $currencyInfo = collect($payoutCurrencies)->where('name', 'INR')->first();
                    }
                    
                    // If found, log the details
                    if ($currencyInfo) {
                        \Log::info('Found INR currency configuration', (array)$currencyInfo);
                    } else {
                        \Log::warning('No INR currency configuration found in payout_currencies');
                    }
                }
            } else {
                return ['status' => false, 'message' => "Currency information not available"];
            }
        }

        // If currency info is still not found, return an error
        if (!$currencyInfo) {
            \Log::error('Currency information not found', [
                'method' => $selectedPayoutMethod->name,
                'currency' => $selectedPayCurrency
            ]);
            return ['status' => false, 'message' => "Currency information not found for " . $selectedPayCurrency];
        }

        $currencyType = $selectedPayoutMethod->currency_type;
        $limit = $currencyType == 0 ? 8 : 2;

        $status = false;
        $amount = getAmount($amount, $limit);

        // Extract the currency configuration values
        $percentage = getAmount($currencyInfo->percentage_charge ?? 0, $limit);
        $percentage_charge = getAmount(($amount * $percentage) / 100, $limit);
        $fixed_charge = getAmount($currencyInfo->fixed_charge ?? 0, $limit);
        $min_limit = getAmount($currencyInfo->min_limit ?? 100, $limit);
        $max_limit = getAmount($currencyInfo->max_limit ?? 1000, $limit);
        $charge = getAmount($percentage_charge + $fixed_charge, $limit);
        
        // Log the currency configuration values being used
        \Log::info('Using currency configuration', [
            'method' => $selectedPayoutMethod->name,
            'currency' => $selectedPayCurrency,
            'min_limit' => $min_limit,
            'max_limit' => $max_limit,
            'percentage_charge' => $percentage,
            'fixed_charge' => $fixed_charge,
            'total_charge' => $charge
        ]);
        
        $payout_amount = getAmount($amount + $charge, $limit);
        $payout_amount_in_base_currency = getAmount($amount / ($currencyInfo->conversion_rate ?? 1), $limit);
        $charge_in_base_currency = getAmount($charge / ($currencyInfo->conversion_rate ?? 1), $limit);
        $net_amount_in_base_currency = $payout_amount_in_base_currency + $charge_in_base_currency;


        $basicControl = basicControl();
        if ($amount < $min_limit || $amount > $max_limit) {
            $message = "minimum payment $min_limit and maximum payment limit $max_limit";
        } else {
            $status = true;
            $message = "Amount : $amount" . " " . $selectedPayCurrency;
        }

        $data['status'] = $status;
        $data['message'] = $message;
        $data['payout_method_id'] = $selectedPayoutMethod->id;
        $data['fixed_charge'] = $fixed_charge;
        $data['percentage'] = $percentage;
        $data['percentage_charge'] = $percentage_charge;
        $data['min_limit'] = $min_limit;
        $data['max_limit'] = $max_limit;
        $data['charge'] = $charge;
        $data['amount'] = $amount;
        $data['payout_charge'] = $charge;
        $data['net_payout_amount'] = $payout_amount;
        $data['amount_in_base_currency'] = $payout_amount_in_base_currency;
        $data['charge_in_base_currency'] = $charge_in_base_currency;
        $data['net_amount_in_base_currency'] = $net_amount_in_base_currency;
        $data['conversion_rate'] = getAmount($currencyInfo->conversion_rate ?? 1);
        $data['currency'] = $currencyInfo->name ?? $currencyInfo->currency_symbol ?? 'INR';
        $data['base_currency'] = $basicControl->base_currency;
        $data['currency_limit'] = $limit;

        return $data;
    }

    public function payoutRequest(Request $request)
    {
        if (!isActivePayout()){
            return back()->with('error', 'Today payout feature is not available.');
        }
        
        \Log::info('Payout request received', $request->all());
        
        $request->validate([
            'wallet_type' => ['required', 'in:balance,interest_balance,profit_balance'],
            'amount'  => ['required', 'numeric'],
            'payout_method_id' => ['required'],
            'supported_currency' => ['required'],
        ]);

        try {
            $amount = $request->amount;
            $payoutMethodId = $request->payout_method_id;
            $supportedCurrency = $request->supported_currency;
            
            // Check if the selected payment method is a bank account
            $selectedMethod = PayoutMethod::find($payoutMethodId);
            if (!$selectedMethod) {
                return back()->with('error', 'Invalid payout method selected.');
            }
            
            $isBankAccount = $selectedMethod && $selectedMethod->name === 'Bank Account';
            $useBankAccount = ($isBankAccount || ($request->has('use_bank_account') && $request->use_bank_account == 1));
            
            // For bank account, always use INR
            if ($isBankAccount) {
                $supportedCurrency = 'INR';
                
                \Log::info('Bank account payout processing', [
                    'payoutMethodId' => $payoutMethodId,
                    'amount' => $amount,
                    'currency' => $supportedCurrency
                ]);
            }

            $checkAmountValidateData = $this->checkAmountValidate($amount, $supportedCurrency, $payoutMethodId);

            if (!$checkAmountValidateData['status']) {
                \Log::error('Amount validation failed', [
                    'amount' => $amount,
                    'currency' => $supportedCurrency,
                    'method_id' => $payoutMethodId,
                    'response' => $checkAmountValidateData
                ]);
                return back()->withInput()->with('error', $checkAmountValidateData['message']);
            }
            
            $user = Auth::user();

            // Check balance based on wallet type
            if ($request->wallet_type == 'balance'){
                if ($user->balance < $checkAmountValidateData['net_amount_in_base_currency']){
                    throw new \Exception('Insufficient Balance');
                }
            } elseif ($request->wallet_type == 'interest_balance') {
                if ($user->interest_balance < $checkAmountValidateData['net_amount_in_base_currency']){
                    throw new \Exception('Insufficient Performance Balance');
                }
            } elseif ($request->wallet_type == 'profit_balance') {
                if ($user->profit_balance < $checkAmountValidateData['net_amount_in_base_currency']){
                    throw new \Exception('Insufficient Profit Balance');
                }
            }

            $payout = new Payout();
            $payout->user_id = $user->id;
            $payout->payout_method_id = $checkAmountValidateData['payout_method_id'];
            $payout->payout_currency_code = $checkAmountValidateData['currency'];
            $payout->amount = $checkAmountValidateData['amount'];
            $payout->charge = $checkAmountValidateData['payout_charge'];
            $payout->net_amount = $checkAmountValidateData['net_payout_amount'];
            $payout->amount_in_base_currency = $checkAmountValidateData['amount_in_base_currency'];
            $payout->charge_in_base_currency = $checkAmountValidateData['charge_in_base_currency'];
            $payout->net_amount_in_base_currency = $checkAmountValidateData['net_amount_in_base_currency'];
            $payout->information = null;
            $payout->feedback = null;
            $payout->status = 0;
            $payout->wallet_type = $request->wallet_type;
            $payout->use_bank_account = $useBankAccount ? 1 : 0;
            $payout->save();
            
            // If bank account is selected, process it directly without going to the confirm page
            if ($isBankAccount) {
                \Log::info('Processing bank account withdrawal', [
                    'payout_id' => $payout->id,
                    'user_id' => $user->id,
                    'amount' => $amount
                ]);
                
                // Get user's bank details
                $bankDetails = $user->bankDetails;
                
                if (!$bankDetails) {
                    return back()->with('error', 'No bank account details found. Please update your KYC information.');
                }
                
                // Create information field for bank details
                $reqField = [];
                
                $reqField['bank_name'] = [
                    'field_name' => 'bank_name',
                    'validation' => 'required',
                    'field_value' => $bankDetails->bank_name,
                    'type' => 'text',
                ];
                
                $reqField['account_number'] = [
                    'field_name' => 'account_number',
                    'validation' => 'required',
                    'field_value' => $bankDetails->account_number,
                    'type' => 'text',
                ];
                
                $reqField['ifsc_code'] = [
                    'field_name' => 'ifsc_code',
                    'validation' => 'required',
                    'field_value' => $bankDetails->ifsc_code,
                    'type' => 'text',
                ];
                
                $reqField['amount'] = [
                    'field_name' => 'amount',
                    'field_value' => currencyPosition($payout->amount),
                    'type' => 'text',
                ];
                
                // Update payout status and information
                $payout->information = $reqField;
                $payout->status = 1;
                
                // Deduct balance
                if ($user->{$payout->wallet_type} < $payout->net_amount_in_base_currency){
                    return back()->with('error', 'Insufficient Balance to deducted.');
                }
                updateBalance($payout->user_id, $payout->net_amount_in_base_currency, 0, $payout->wallet_type);
                
                // Notify user
                $this->userNotify($user, $payout);
                
                // Save payout
                $payout->save();
                
                return redirect(route('user.payout.index'))->with('success', 'Payout generated successfully');
            }
            
            return redirect(route('user.payout.confirm', $payout->trx_id))->with('success', 'Payout initiated successfully');
        } catch (\Exception $e) {
            \Log::error('Error in payout request: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirmPayout(Request $request, $trx_id)
    {
        $payout = Payout::where('trx_id', $trx_id)->first();
        $payoutMethod = PayoutMethod::findOrFail($payout->payout_method_id);
        $basic = basicControl();
        $user = Auth::user();
        
        // Get user's bank details if available
        $bankDetails = $user->bankDetails;

        if ($request->isMethod('get')) {
            // Set use_bank_account if it was selected in the initial request
            $useBankAccount = $payout->use_bank_account ? true : false;
            
            if ($payoutMethod->code == 'flutterwave') {
                return view(template() . 'user.payout.gateway.' . $payoutMethod->code, compact('payout', 'payoutMethod', 'basic', 'bankDetails', 'useBankAccount'));
            } elseif ($payoutMethod->code == 'paystack') {
                return view(template() . 'user.payout.gateway.' . $payoutMethod->code, compact('payout', 'payoutMethod', 'basic', 'bankDetails', 'useBankAccount'));
            }
            return view(template() . 'user.payout.confirm', compact('payout', 'payoutMethod', 'bankDetails', 'useBankAccount'));

        } elseif ($request->isMethod('post')) {

            $params = $payoutMethod->inputForm;
            $rules = [];
            if ($params !== null) {
                foreach ($params as $key => $cus) {
                    $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
                    if ($cus->type === 'file') {
                        $rules[$key][] = 'image';
                        $rules[$key][] = 'mimes:jpeg,jpg,png';
                        $rules[$key][] = 'max:4048';
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

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $checkAmountValidate = $this->checkAmountValidate($payout->amount_in_base_currency, $payout->payout_currency_code, $payout->payout_method_id);
            if (!$checkAmountValidate['status']) {
                return back()->withInput()->with('error', $checkAmountValidate['message']);
            }

            $params = $payoutMethod->inputForm;
            $reqField = [];
            
            // Check if user is using bank account
            if ($request->has('use_bank_account') && $request->use_bank_account == 1) {
                // Get user's bank details
                $bankDetails = $user->bankDetails;
                
                if ($bankDetails) {
                    // Add bank details to reqField
                    $reqField['bank_name'] = [
                        'field_name' => 'bank_name',
                        'validation' => 'required',
                        'field_value' => $bankDetails->bank_name,
                        'type' => 'text',
                    ];
                    
                    $reqField['account_number'] = [
                        'field_name' => 'account_number',
                        'validation' => 'required',
                        'field_value' => $bankDetails->account_number,
                        'type' => 'text',
                    ];
                    
                    $reqField['ifsc_code'] = [
                        'field_name' => 'ifsc_code',
                        'validation' => 'required',
                        'field_value' => $bankDetails->ifsc_code,
                        'type' => 'text',
                    ];
                }
            } else {
                // Process regular form fields
                foreach ($request->except('_token', '_method', 'type', 'currency_code', 'bank', 'use_bank_account') as $k => $v) {
                    foreach ($params as $inKey => $inVal) {
                        if ($k == $inVal->field_name) {
                            if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                                try {
                                    $file = $this->fileUpload($request[$inKey], config('filelocation.payoutLog.path'),null,null,'webp',60);
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


            $payoutMethod = PayoutMethod::find($payout->payout_method_id);
            $payoutCurrencies = $payoutMethod->payout_currencies;
            if ($payoutMethod->is_automatic == 1) {
                $currencyInfo = collect($payoutCurrencies)->where('name', $request->currency_code)->first();
            } else {
                $currencyInfo = collect($payoutCurrencies)->where('currency_symbol', $request->currency_code)->first();
            }

            $reqField['amount'] = [
                'field_name' => 'amount',
                'field_value' => currencyPosition($payout->amount * $currencyInfo->conversion_rate),
                'type' => 'text',
            ];


            if ($payoutMethod->code == 'paypal') {
                $reqField['recipient_type'] = [
                    'field_name' => 'receiver',
                    'validation' => $inVal->validation,
                    'field_value' => $request->recipient_type,
                    'type' => 'text',
                ];
            }
            $payout->information = $reqField;
            $payout->status = 1;

            $user = Auth::user();
            if ($user->{$payout->wallet_type} < $payout->net_amount_in_base_currency){
                return back()->with('error', 'Insufficient Balance to deducted.');
            }
            updateBalance($payout->user_id, $payout->net_amount_in_base_currency, 0,$payout->wallet_type);
            $this->userNotify($user, $payout);

            $payout->save();
            return redirect(route('user.payout.index'))->with('success', 'Payout generated successfully');

        }
    }

    public function paystackPayout(Request $request, $trx_id)
    {

        $basicControl = basicControl();
        $payout = Payout::where('trx_id', $trx_id)->first();
        $payoutMethod = PayoutMethod::findOrFail($payout->payout_method_id);

        if (empty($request->bank)) {
            return back()->with('error', 'Bank field is required')->withInput();
        }

        $checkAmountValidate = $this->checkAmountValidate($payout->amount, $payout->payout_currency_code, $payout->payout_method_id);
        if (!$checkAmountValidate['status']) {
            return back()->withInput()->with('error', $checkAmountValidate['message']);
        }


        $rules = [];
        if ($payoutMethod->inputForm != null) {
            foreach ($payoutMethod->inputForm as $key => $cus) {
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

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        $params = $payoutMethod->inputForm;
        $reqField = [];
        foreach ($request->except('_token', '_method', 'type', 'currency_code', 'bank') as $k => $v) {
            foreach ($params as $inKey => $inVal) {
                if ($k == $inVal->field_name) {
                    if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                        try {
                            $file = $this->fileUpload($request[$inKey], config('filelocation.payoutLog.path'));
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

        $reqField['type'] = [
            'field_name' => "type",
            'field_value' => $request->type,
            'type' => 'text',
        ];
        $reqField['bank_code'] = [
            'field_name' => "bank_id",
            'field_value' => $request->bank,
            'type' => 'number',
        ];

        $user = Auth::user();
        if ($user->{$payout->wallet_type} < $payout->net_amount_in_base_currency){
            return back()->with('error', 'Insufficient Balance to deducted.');
        }
        updateBalance($payout->user_id, $payout->net_amount_in_base_currency, 0,$payout->wallet_type);

        $payout->information = $reqField;
        $payout->status = 1;
        $payout->save();

        $this->userNotify($user, $payout);
        if (optional($payout->payoutMethod)->is_automatic == 1 && $basicControl->automatic_payout_permission) {
            $this->automaticPayout($payout);
            return redirect()->route('user.payout.index');
        }

        return redirect()->route('user.payout.index')->with('success', 'Payout generated successfully');
    }


    public function flutterwavePayout(Request $request, $trx_id)
    {
        $user = Auth::user();
        $payout = Payout::with('method')->where('trx_id', $trx_id)->first();
        $purifiedData = $request->all();
        if (empty($purifiedData['transfer_name'])) {
            return back()->with('alert', 'Transfer field is required');
        }
        $validation = config('banks.' . $purifiedData['transfer_name'] . '.validation');


        $rules = [];
        if ($validation != null) {
            foreach ($validation as $key => $cus) {
                $rules[$key] = 'required';
            }
        }

        if ($request->transfer_name == 'NGN BANK' || $request->transfer_name == 'NGN DOM' || $request->transfer_name == 'GHS BANK'
            || $request->transfer_name == 'KES BANK' || $request->transfer_name == 'ZAR BANK' || $request->transfer_name == 'ZAR BANK') {
            $rules['bank'] = 'required';
        }

        $rules['currency_code'] = 'required';


        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {

            return back()->withErrors($validate)->withInput();
        }

        $checkAmountValidate = $this->checkAmountValidate($payout->amount, $payout->payout_currency_code, $payout->payout_method_id);

        if (!$checkAmountValidate['status']) {
            return back()->withInput()->with('error', $checkAmountValidate['message']);
        }


        $collection = collect($purifiedData);
        $reqField = [];
        $metaField = [];

        if (config('banks.' . $purifiedData['transfer_name'] . '.input_form') != null) {
            foreach ($collection as $k => $v) {
                foreach (config('banks.' . $purifiedData['transfer_name'] . '.input_form') as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal == 'meta') {
                            $metaField[$inKey] = $v;
                            $metaField[$inKey] = [
                                'field_name' => $k,
                                'field_value' => $v,
                                'type' => 'text',
                            ];
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $k,
                                'field_value' => $v,
                                'type' => 'text',
                            ];
                        }
                    }
                }
            }


            if ($request->transfer_name == 'NGN BANK' || $request->transfer_name == 'NGN DOM' || $request->transfer_name == 'GHS BANK'
                || $request->transfer_name == 'KES BANK' || $request->transfer_name == 'ZAR BANK' || $request->transfer_name == 'ZAR BANK') {

                $reqField['account_bank'] = [
                    'field_name' => 'Account Bank',
                    'field_value' => $request->bank,
                    'type' => 'text',
                ];
            } elseif ($request->transfer_name == 'XAF/XOF MOMO') {
                $reqField['account_bank'] = [
                    'field_name' => 'MTN',
                    'field_value' => 'MTN',
                    'type' => 'text',
                ];
            } elseif ($request->transfer_name == 'FRANCOPGONE' || $request->transfer_name == 'mPesa' || $request->transfer_name == 'Rwanda Momo'
                || $request->transfer_name == 'Uganda Momo' || $request->transfer_name == 'Zambia Momo') {
                $reqField['account_bank'] = [
                    'field_name' => 'MPS',
                    'field_value' => 'MPS',
                    'type' => 'text',
                ];
            }

            if ($request->transfer_name == 'Barter') {
                $reqField['account_bank'] = [
                    'field_name' => 'barter',
                    'field_value' => 'barter',
                    'type' => 'text',
                ];
            } elseif ($request->transfer_name == 'flutterwave') {
                $reqField['account_bank'] = [
                    'field_name' => 'barter',
                    'field_value' => 'barter',
                    'type' => 'text',
                ];
            }


            $payoutMethod = PayoutMethod::find($payout->payout_method_id);
            $payoutCurrencies = $payoutMethod->payout_currencies;
            $currencyInfo = collect($payoutCurrencies)->where('name', $request->currency_code)->first();

            $reqField['amount'] = [
                'field_name' => 'amount',
                'field_value' => $payout->amount * $currencyInfo->conversion_rate,
                'type' => 'text',
            ];

            $payout->information = $reqField;
            $payout->meta_field = $metaField;


        } else {
            $payout->information = null;
            $payout->meta_field = null;
        }

        $user = Auth::user();
        if ($user->{$payout->wallet_type} < $payout->net_amount_in_base_currency){
            return back()->with('error', 'Insufficient Balance to deducted.');
        }
        updateBalance($payout->user_id, $payout->net_amount_in_base_currency, 0,$payout->wallet_type);

        $payout->status = 1;
        $payout->payout_currency_code = $request->currency_code;
        $payout->save();

        $this->userNotify($user, $payout);
        return redirect()->route('user.payout.index')->with('success', 'Payout generated successfully');

    }

    public function getBankList(Request $request)
    {
        $currencyCode = $request->currencyCode;
        $methodObj = 'App\\Services\\Payout\\paystack\\Card';
        $data = $methodObj::getBank($currencyCode);
        return $data;
    }

    public function getBankForm(Request $request)
    {
        $bankName = $request->bankName;
        $bankArr = config('banks.' . $bankName);

        if ($bankArr['api'] != null) {

            $methodObj = 'App\\Services\\Payout\\flutterwave\\Card';
            $data = $methodObj::getBank($bankArr['api']);
            $value['bank'] = $data;
        }
        $value['input_form'] = $bankArr['input_form'];
        return $value;
    }

    public function automaticPayout($payout)
    {
        $methodObj = 'App\\Services\\Payout\\' . optional($payout->payoutMethod)->code . '\\Card';
        $data = $methodObj::payouts($payout);

        if (!$data) {
            return back()->with('alert', 'Method not available or unknown errors occur');
        }

        if ($data['status'] == 'error') {
            $payout->last_error = $data['data'];
            $payout->status = 3;
            $payout->save();
            return back()->with('error', $data['data']);
        }
    }

    public function userNotify($user, $payout)
    {
        $params = [
            'sender' => $user->username,
            'amount' => currencyPosition($payout->amount_in_base_currency+0),
            'transaction' => $payout->trx_id,
        ];

        $action = [
            "link" => route('admin.payout.log'),
            "icon" => "fa fa-money-bill-alt text-white",
            "name" => optional($payout->user)->firstname . ' ' . optional($payout->user)->lastname,
            "image" => getFile(optional($payout->user)->image_driver, optional($payout->user)->image),
        ];
        $firebaseAction = route('admin.payout.log');
        $this->adminMail('PAYOUT_REQUEST_TO_ADMIN', $params);
        $this->adminPushNotification('PAYOUT_REQUEST_TO_ADMIN', $params, $action);
        $this->adminFirebasePushNotification('PAYOUT_REQUEST_TO_ADMIN', $params, $firebaseAction);

        $params = [
            'amount' => currencyPosition($payout->amount_in_base_currency+0),
            'transaction' => $payout->trx_id,
        ];
        $action = [
            "link" => "#",
            "icon" => "fa fa-money-bill-alt text-white"
        ];
        $firebaseAction = "#";
        $this->sendMailSms($user, 'PAYOUT_REQUEST_FROM', $params);
        $this->userPushNotification($user, 'PAYOUT_REQUEST_FROM', $params, $action);
        $this->userFirebasePushNotification($user, 'PAYOUT_REQUEST_FROM', $params, $firebaseAction);
    }

}
