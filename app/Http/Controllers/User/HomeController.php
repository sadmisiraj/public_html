<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\DistributeBonus;
use App\Jobs\UserAllRecordDeleteJob;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Investment;
use App\Models\Kyc;
use App\Models\Language;
use App\Models\ManagePlan;
use App\Models\ManageTime;
use App\Models\MoneyTransfer;
use App\Models\Ranking;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\PhoneLength;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Facades\App\Services\BasicService;
use App\Models\UserPlan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\MoneyTransferLimitHelper;
use App\Services\RgpTransactionService;


class HomeController extends Controller
{
    use Upload, Notify;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function saveToken(Request $request)
    {
        try {
            Auth::user()
                ->fireBaseToken()
                ->create([
                    'token' => $request->token,
                ]);
            return response()->json([
                'msg' => 'token saved successfully.',
            ]);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function index()
    {


        $data['totalTeamInvest'] = teamInvest(Auth::user());

        $user = Auth::user();
        $data['user'] = $user;
        $data['firebaseNotify'] = config('firebase');
        $data['walletBalance'] = $user->balance+0;
        $data['interestBalance'] = $user->interest_balance+0;
        $data['profitBalance'] = $user->profit_balance+0;
        $data['totalDeposit'] = $user->total_deposit+0;
        $data['lastPayout'] = getAmount(optional($this->user->payout()->whereStatus(2)->latest()->first())->amount_in_base_currency);
        $data['totalPayout'] = getAmount($this->user->payout()->whereStatus(2)->sum('amount_in_base_currency'));
        $data['depositBonus'] = getAmount($this->user->referralBonusLog()->where('type', 'deposit')->sum('amount'));
        $data['investBonus'] = getAmount($this->user->referralBonusLog()->where('type', 'invest')->sum('amount'));
        $data['totalBonus'] = getAmount($this->user->referralBonusLog()->sum('amount'));
        $data['lastBonus'] = getAmount(optional($this->user->referralBonusLog()->latest()->first())->amount);

        $data['totalInterestProfit'] = getAmount($this->user->transaction()->where('balance_type', 'interest_balance')->where('trx_type', '+')->sum('amount') + 0, 2);

        // Add total earnings: sum of interest_balance and profit_balance transactions
        $totalInterest = $this->user->transaction()->where('balance_type', 'interest_balance')->where('trx_type', '+')->sum('amount');
        $totalProfit = $this->user->transaction()->where('balance_type', 'profit_balance')->where('trx_type', '+')->sum('amount');
        $data['totalEarnings'] = getAmount($totalInterest + $totalProfit, 2);

        $roi = Investment::where('user_id', $user->id)
            ->selectRaw('SUM( amount ) AS totalInvestAmount')
            ->selectRaw('COUNT( id ) AS totalInvest')
            ->selectRaw('COUNT(CASE WHEN status = 0  THEN id END) AS completed')
            ->selectRaw('COUNT(CASE WHEN status = 1  THEN id END) AS running')
            ->selectRaw('SUM(CASE WHEN maturity != -1  THEN maturity * profit END) AS expectedProfit')
            ->selectRaw('SUM(recurring_time * profit) AS returnProfit')
            ->get()->makeHidden('nextPayment')->toArray();
        $data['roi'] = collect($roi)->collapse();
        $data['ticket'] = SupportTicket::where('user_id', Auth::id())->count();
        
        // Fetch all configs from database for progress rings
        $data['configs'] = \App\Models\Config::all();

        $monthlyInvestment = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        Investment::where('user_id', $this->user->id)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->makeHidden('nextPayment')->map(function ($item) use ($monthlyInvestment) {
                $monthlyInvestment->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['investment'] = $monthlyInvestment;


        $monthlyPayout = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->payout()->whereStatus(2)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount_in_base_currency) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyPayout) {
                $monthlyPayout->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['payout'] = $monthlyPayout;


        $monthlyFunding = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->deposits()
            ->where('depositable_type', 'App\Models\Deposit')
            ->whereStatus(1)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(payable_amount_in_base_currency) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyFunding) {
                $monthlyFunding->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['funding'] = $monthlyFunding;


        $monthlyReferralInvestBonus = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->referralBonusLog()->where('type', 'invest')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyReferralInvestBonus) {
                $monthlyReferralInvestBonus->put($item['months'], round($item['totalAmount'], 2));
            });

        $monthly['referralInvestBonus'] = $monthlyReferralInvestBonus;


        $monthlyReferralFundBonus = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);

        $this->user->referralBonusLog()->where('type', 'deposit')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyReferralFundBonus) {
                $monthlyReferralFundBonus->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['referralFundBonus'] = $monthlyReferralFundBonus;

        $latestRegisteredUser = User::where('referral_id', $this->user->id)->latest()->first();
        return view(template() . 'user.dashboard', $data, compact('monthly', 'latestRegisteredUser'));
    }


    public function profile()
    {
        $data['user'] = Auth::user();
        $data['languages'] = Language::all();
        $data['kyc'] = Kyc::where('status', 1)->get();
        return view(template() . 'user.profile.my_profile', $data);
    }

    public function profileUpdateImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:png,jpg|max:3072',
            ]);
            $user = Auth::user();
            if ($request->hasFile('image')) {
                $image = $this->fileUpload($request->image, config('filelocation.userProfile.path'), null, null, 'avif', 60, $user->image, $user->image_driver);
                if ($image) {
                    $profileImage = $image['path'];
                    $ImageDriver = $image['driver'];
                }
            }
            $user->image = $profileImage ?? $user->image;
            $user->image_driver = $ImageDriver ?? $user->image_driver;
            $user->save();
            return response()->json('Updated Successfully.');
        } catch (\Exception $exception) {
            return response()->json(['err' => $exception->getMessage()], 200);
        }
    }

    public function profileUpdate(Request $request)
    {
        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });

        $req = $request->except('_method', '_token');
        $user = Auth::user();
        $phoneCode = $request->phone_code;
        $rules = [
            'first_name' => 'required|string|min:1',
            'last_name' => 'required|string|min:1',
            // 'email' => 'required|email:rfc,dns|unique:users,email,' . $user->id,
            // 'phone' => ['required', 'string', new PhoneLength($phoneCode), Rule::unique('users', 'phone')->ignore($user->id)],
            // 'phone_code' => 'required | max:15',
            // 'country_code' => 'required | string | max:80',
            'country' => 'required | string | max:80',
            'state' => 'nullable | string | max:80',
            'address' => 'required',
            'language' => Rule::in($languages),
        ];
        $message = [
            'firstname.required' => 'First Name field is required',
            'lastname.required' => 'Last Name field is required',
        ];

        $validator = Validator::make($req, $rules, $message);
        if ($validator->fails()) {
            $validator->errors()->add('profile', '1');
            return back()->withErrors($validator)->withInput();
        }
        try {
            $user->language_id = $req['language'] ?? null;
            $user->firstname = $req['first_name'];
            $user->lastname = $req['last_name'];
            // $user->email = $req['email'];
            $user->address = $req['address'];
            // $user->phone = $req['phone'];
            // $user->phone_code = $req['phone_code'];
            $user->country_code = $req['country_code'];
            $user->country = $req['country'];
            $user->state = $req['state'];
            $user->save();
            return back()->with('success', 'Updated Successfully.');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return back()->with('error', $exception->getMessage());
        }
    }


    public function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => "required",
            'password' => "required|min:5|confirmed",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();
        try {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return back()->with('success', 'Password Changes successfully.');
            } else {
                throw new \Exception('Current password did not match');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function addFund()
    {
        $data['basic'] = basicControl();
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
        return view(template() . 'user.fund.add_fund', $data);
    }

    public function fund(Request $request)
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
        $userId = Auth::id();
        $funds = Deposit::with(['depositable', 'gateway'])
            ->where('user_id', $userId)
            ->when(isset($trx_id) && $trx_id, function ($q) use ($trx_id) {
                return $q->where('trx_id', $trx_id);
            })
            ->when(isset($status) && $status !== 0 && $status !== 'all', function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when(isset($dateSearch) && $dateSearch, function ($q) use ($dateSearch) {
                return $q->whereDate('created_at', $dateSearch);
            })
            ->orderBy('id', 'desc')
            ->latest()->paginate(12);

        return view(template() . 'user.fund.index', compact('funds'));
    }

    public function planList()
    {
        $user = Auth::user();
        $userActivePlans = $user->userPlans()
            ->where('is_active', true)
            ->whereRaw('(expires_at IS NULL OR expires_at > NOW())')
            ->pluck('plan_id')
            ->toArray();
            
        $plans = ManagePlan::where('status', 1)->paginate(10);
        
        return view(template() . 'user.plan.index', compact('plans', 'userActivePlans'));
    }

    public function investHistory()
    {

        $investments = Investment::query()
            ->with('plan')
            ->where('user_id', Auth::id())
            ->paginate(10);

        return view(template() . 'user.invest_history.index', compact('investments'));
    }

    public function moneyTransfer()
    {
        $page_title = "Balance Transfer";
        $limitInfo = MoneyTransferLimitHelper::getLimitInfo();
        return view(template() . 'user.money_transfer.index', compact('page_title', 'limitInfo'));
    }

    public function moneyTransferConfirm(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'amount' => 'required',
            'wallet_type' => ['required', Rule::in(['balance', 'interest_balance', 'profit_balance'])],
            'password' => 'required'
        ], [
            'wallet_type.required' => 'Please Select a wallet'
        ]);

        // Check transfer limits first
        $limitCheck = MoneyTransferLimitHelper::checkTransferLimit();
        if (!$limitCheck['allowed']) {
            session()->flash('error', $limitCheck['message']);
            return back()->withInput();
        }

        $basic = basicControl();
        $username = trim($request->username);

        $receiver = User::where('username', $username)->first();


        if (!$receiver) {
            session()->flash('error', 'This Username could not Found!');
            return back();
        }
        if ($receiver->id == Auth::id()) {
            session()->flash('error', 'This Username could not Found!');
            return back()->withInput();
        }

        if ($receiver->status == 0) {
            session()->flash('error', 'Invalid User!');
            return back()->withInput();
        }


        if ($request->amount < $basic->min_transfer) {
            session()->flash('error', 'Minimum Transfer Amount ' . $basic->min_transfer . ' ' . basicControl()->currency_symbol);
            return back()->withInput();
        }
        if ($request->amount > $basic->max_transfer) {
            session()->flash('error', 'Maximum Transfer Amount ' . $basic->max_transfer . ' ' . $basic->currency);
            return back()->withInput();
        }

        $transferCharge = ($request->amount * $basic->transfer_charge) / 100;

        $user = Auth::user();
        $wallet_type = $request->wallet_type;
        if ($user[$wallet_type] >= ($request->amount + $transferCharge)) {

            if (Hash::check($request->password, $user->password)) {


                $sendMoneyCheck = MoneyTransfer::where('sender_id', $user->id)->where('receiver_id', $receiver->id)->latest()->first();

                if (isset($sendMoneyCheck) && Carbon::parse($sendMoneyCheck->send_at) > Carbon::now()) {

                    $time = Carbon::parse($sendMoneyCheck->send_at);
                    $delay = $time->diffInSeconds(Carbon::now());
                    $delay = gmdate('i:s', $delay);

                    session()->flash('error', 'You can send money to this user after  delay ' . $delay . ' minutes');
                    return back()->withInput();
                } else {

                    $user[$wallet_type] = round(($user[$wallet_type] - ($transferCharge + $request->amount)), 2);
                    $user->save();

                    $receiver['balance'] += round($request->amount, 2);
                    $receiver->save();


                    $sendTaka = new MoneyTransfer();
                    $sendTaka->sender_id = $user->id;
                    $sendTaka->receiver_id = $receiver->id;
                    $sendTaka->amount = round($request->amount, 2);
                    $sendTaka->charge = $transferCharge;
                    $sendTaka->send_at = Carbon::now()->addMinutes(1);
                    $sendTaka->save();

                    $transaction = new Transaction();
                    $transaction->user_id = $user->id;
                    $transaction->amount = round($request->amount, 2);
                    $transaction->charge = $transferCharge;
                    $transaction->trx_type = '-';
                    $transaction->balance_type = $wallet_type;
                    $transaction->remarks = 'Balance Transfer to  ' . $receiver->username;
                    $transaction->trx_id = $sendTaka->trx;
                    $transaction->final_balance = $user[$wallet_type];
                    $transaction->save();

                    // Add transaction record for receiver
                    $receiverTransaction = new Transaction();
                    $receiverTransaction->user_id = $receiver->id;
                    $receiverTransaction->amount = round($request->amount, 2);
                    $receiverTransaction->charge = 0;
                    $receiverTransaction->trx_type = '+';
                    $receiverTransaction->balance_type = 'balance';
                    $receiverTransaction->remarks = 'Balance Received from ' . $user->username;
                    $receiverTransaction->trx_id = $sendTaka->trx;
                    $receiverTransaction->final_balance = $receiver['balance'];
                    $receiverTransaction->save();

                    $currentDate = dateTime(Carbon::now());
                    $msg = [
                        'send_user' => $user->fullname,
                        'to_user' => $receiver->fullname,
                        'amount' => currencyPosition($request->amount),
                    ];
                    $actionAdmin = [
                        "name" => $user->firstname . ' ' . $user->lastname,
                        "image" => getFile($user->image_driver, $user->image),
                        "link" => route('admin.transaction'),
                        "icon" => "fas fa-ticket-alt text-white"
                    ];

                    $userAction = [
                        "link" => route('user.dashboard'),
                        "icon" => "fa fa-money-bill-alt text-white"
                    ];

                    //sender
                    $this->userPushNotification($user, 'SENDER_NOTIFY_BALANCE_TRANSFER', $msg, $userAction);
                    $this->userFirebasePushNotification($user, 'SENDER_NOTIFY_BALANCE_TRANSFER', $msg, route('user.dashboard'));
                    $this->sendMailSms($user, 'SENDER_NOTIFY_BALANCE_TRANSFER', $msg);

                    //receiver
                    $this->userPushNotification($receiver, 'RECEIVER_NOTIFY_BALANCE_TRANSFER', $msg, $userAction);
                    $this->userFirebasePushNotification($receiver, 'RECEIVER_NOTIFY_BALANCE_TRANSFER', $msg, route('user.dashboard'));
                    $this->sendMailSms($receiver, 'RECEIVER_NOTIFY_BALANCE_TRANSFER', $msg);

                    $this->adminPushNotification('ADMIN_NOTIFY_BALANCE_TRANSFER', $msg, $actionAdmin);
                    $this->adminFirebasePushNotification('ADMIN_NOTIFY_BALANCE_TRANSFER', $msg, route('admin.transaction'));

                    $this->adminMail('ADMIN_NOTIFY_BALANCE_TRANSFER', [
                        'send_user' => $user->fullname,
                        'to_user' => $receiver->fullname,
                        'amount' => currencyPosition($request->amount),
                        'date' => $currentDate
                    ]);


                    session()->flash('success', 'Balance Transfer  has been Successful');
                    return redirect()->route('user.money-transfer');
                }
            } else {
                session()->flash('error', 'Password Do Not Match!');
                return back()->withInput();
            }
        } else {
            session()->flash('error', 'Insufficient Balance!');
            return back()->withInput();
        }
    }

    public function transaction(Request $request)
    {
        $trx_id = null;
        if (isset($request->transaction_id) && $request->transaction_id) {
            $trx_id = $request->transaction_id;
        }
        $remark = null;
        if (isset($request->remark)) {
            $remark = $request->remark;
        }
        $dateSearch = null;
        if (isset($request->date) && $request->date) {
            $dateSearch = $request->date;
        }

        $user = Auth::user();

        $transactions = $user->transaction()
            ->when($dateSearch, function ($query) use ($dateSearch) {
                $query->whereDate('created_at', $dateSearch);
            })
            ->when($remark, function ($query) use ($remark) {
                $query->where('remarks', 'LIKE', '%' . $remark . '%');
            })
            ->when($trx_id, function ($query) use ($trx_id) {

                $query->where('trx_id', $trx_id);
            })
            ->orderBy('id', 'DESC')->paginate(12);
        return view(template() . 'user.transaction.index', compact('transactions'));
    }

    public function referral()
    {
        $userId = Auth::id();
        $data['title'] = "My Referrals";
        $data['directReferralUsers'] = getDirectReferralUsers($userId);
        return view(template() . 'user.referral.index', $data);
    }

    public function terminate($id)
    {
        if (!basicControl()->user_termination) {
            abort(403);
        }
        $investment = Investment::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$investment) {
            abort(404);
        }
        $terminate_charge = basicControl()->terminate_charge;
        $user = $investment->user;
        $amount = $investment->amount;
        $charge = ($amount * $terminate_charge) / 100;
        if ($user->balance < $terminate_charge) {
            return back()->with('error', 'Insufficient Balance!');
        } else {
            $user->balance -= $charge;
            $user->save();
        }

        $investment->status = 2;
        $investment->save();
        $user->balance += $amount;
        $user->save();
        $msg = [
            'plan_name' => optional($investment->plan)->name,
            'amount' => $investment->amount,
        ];
        $action = [
            "link" => route('user.invest-history'),
            "icon" => "fa fa-money-bill-alt text-white"
        ];
        $this->userPushNotification($user, 'TERMINATE_INVESTMENT', $msg, $action);
        $this->userFirebasePushNotification($user, 'TERMINATE_INVESTMENT', $msg, route('user.invest-history'));
        $this->sendMailSms($user, 'TERMINATE_INVESTMENT', $msg);
        return back()->with('success', 'Investment has been Terminated');
    }

    public function getReferralUser(Request $request)
    {
        $data = getDirectReferralUsers($request->userId);
        $directReferralUsers = $data->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'count_direct_referral' => count(getDirectReferralUsers($user->id)),
                'joined_at' => dateTime($user->created_at),
                'referral_node' => $user->referral_node,
            ];
        });

        return response()->json(['data' => $directReferralUsers]);
    }

    public function referralBonus(Request $request)
    {
        $search = $request->all();
        $dateSearch = null;
        if (isset($request->date) && $request->date) {
            $dateSearch = $request->date;
        }

        $title = "Referral Bonus";
        $user = Auth::user();
        $transactions = $user->referralBonusLog()->latest()
            ->with('bonusBy:id,firstname,lastname')
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->whereHas('bonusBy', function ($query) use ($search) {
                    $query->where('firstname', 'LIKE', '%' . $search['name'] . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $search['name'] . '%')
                        ->orWhere(DB::raw("CONCAT(firstname, ' ', lastname)"), 'LIKE', '%' . $search['name'] . '%');
                });
            })
            ->when($dateSearch, function ($query) use ($dateSearch) {
                $query->whereDate('created_at', $dateSearch);
            })
            ->paginate(12);
        return view(template() . 'user.referral.bonus', compact('title', 'transactions'));
    }

    public function badges()
    {
        $data['allBadges'] = Ranking::orderBy('sort_by', 'ASC')->get();
        return view(template() . 'user.badge.index', $data);
    }

    public function purchasePlan(Request $request)
    {
        $this->validate($request, [
            'balance_type' => 'required',
            'amount' => 'required|numeric',
            'plan_id' => 'required',
        ]);

        $user = Auth::user();
        $plan = ManagePlan::where('id', $request->plan_id)->where('status', 1)->first();
        if (!$plan) {
            return back()->with('error', 'Invalid Plan Request');
        }
        
        // Check if this plan requires a base plan and if user has purchased it
        if ($plan->base_plan_id && !$user->hasBasePlan($plan->base_plan_id)) {
            $basePlan = ManagePlan::find($plan->base_plan_id);
            if ($basePlan) {
                return back()->with('error', 'You need to purchase ' . $basePlan->name . ' plan first to unlock this plan');
            }
            return back()->with('error', 'You need to purchase the base plan first');
        }
        
        // Check if user already has an active plan
        if ($user->hasActivePlan($plan->id) && !$plan->allow_multiple_purchase) {
            return back()->with('error', 'You already have an active subscription to this plan');
        }
        
        $timeManage = ManageTime::where('time', $plan->schedule)->first();

        $balance_type = $request->balance_type;
        if (!in_array($balance_type, ['balance', 'interest_balance', 'checkout', 'profit_balance'])) {
            return back()->with('error', 'Invalid Wallet Type');
        }


        $amount = $request->amount;
        $basic = basicControl();
        if ($plan->fixed_amount == '0' && $amount < $plan->minimum_amount) {
            return back()->with('error', "Invest Limit " . $plan->price);
        } elseif ($plan->fixed_amount == '0' && $amount > $plan->maximum_amount) {
            return back()->with('error', "Invest Limit " . $plan->price);
        } elseif ($plan->fixed_amount != '0' && $amount != $plan->fixed_amount) {
            return back()->with('error', "Please invest " . $plan->price);
        }

        if ($balance_type == "checkout") {
            session()->put('amount', encrypt($amount));
            session()->put('plan_id', encrypt($plan->id));
            return redirect()->route('user.payment');
        }

        if ($amount > $user->{$balance_type}) {
            return back()->with('error', 'Insufficient Balance');
        }

        $throttleKey = 'purchase-plan:' . $user->id;
        // Check if the user has hit the throttle limit
        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {  // Adjust '5' to desired max attempts
            return back()->with('error', 'Too many requests. Please wait 60 seconds before trying again.');
        }
        RateLimiter::hit($throttleKey, 1);



        try {
            $new_balance = getAmount($user->{$balance_type} - $amount);
            $user->{$balance_type} = $new_balance;
            $user->total_invest += $request->amount;
            $user->save();


            $profit = ($plan->profit_type == 1) ? ($amount * $plan->profit) / 100 : $plan->profit;
            $maturity = ($plan->is_lifetime == 1) ? '-1' : $plan->repeatable;

            //// For Fixed Plan
            if ($plan->fixed_amount != 0 && ($plan->fixed_amount == $amount)) {
                $invest = BasicService::makeInvest($user, $plan, $amount, $profit, $maturity, $timeManage);
            } elseif ($plan->fixed_amount == 0) {
                $invest = BasicService::makeInvest($user, $plan, $amount, $profit, $maturity, $timeManage);
            }
            $trx = null;
            if (isset($invest) && $invest) {
                $trx = $invest->trx;
                $remarks = 'Invested On ' . $plan->name;
                $transaction = BasicService::makeTransaction($user, $amount, 0, '-', $balance_type, $trx, $remarks);
                $invest->transactional()->save($transaction);
                
                // Create user plan record
                $expiresAt = null;
                if ($plan->is_lifetime != 1) {
                    $expiresAt = Carbon::now()->addDays($plan->repeatable);
                }
                
                $userPlan = new UserPlan();
                $userPlan->user_id = $user->id;
                $userPlan->plan_id = $plan->id;
                $userPlan->purchase_date = Carbon::now();
                $userPlan->expires_at = $expiresAt;
                $userPlan->is_active = true;
                $userPlan->save();

                // Check if plan is eligible for RGP and update referral chain's RGP values
                if ($plan->eligible_for_rgp) {
                    $currentUser = $user;
                    $rgpTransactionService = new RgpTransactionService();
                    
                    // Log that we're starting RGP distribution
                    \Log::info('Starting RGP distribution for plan purchase', [
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'plan_id' => $plan->id,
                        'plan_name' => $plan->name,
                        'rgp_eligible' => $plan->eligible_for_rgp,
                        'amount' => $amount
                    ]);
                    
                    while ($currentUser->rgp_parent_id) {
                        $parent = User::find($currentUser->rgp_parent_id);
                        if (!$parent) {
                            \Log::warning('Parent not found in RGP chain', [
                                'current_user_id' => $currentUser->id,
                                'rgp_parent_id' => $currentUser->rgp_parent_id
                            ]);
                            break;
                        }
                        
                        // Store previous values
                        $previousRgpL = floatval($parent->rgp_l ?? 0);
                        $previousRgpR = floatval($parent->rgp_r ?? 0);
                        
                        // Calculate RGP points as 1% of the transaction amount
                        $rgpPoints = number_format($amount * 0.01, 2);
                        
                        // Find all direct children of this parent to determine placement
                        $directChildren = User::where('rgp_parent_id', $parent->id)->get();
                        
                        // Find which side the current user is on by checking direct children or their descendants
                        $childPlacement = null;
                        foreach ($directChildren as $directChild) {
                            if ($directChild->id == $currentUser->id) {
                                $childPlacement = $directChild->referral_node;
                                break;
                            }
                        }
                        
                        \Log::info('Processing RGP for parent', [
                            'parent_id' => $parent->id,
                            'parent_username' => $parent->username,
                            'child_id' => $currentUser->id,
                            'child_username' => $currentUser->username,
                            'child_placement' => $childPlacement,
                            'previous_rgp_l' => $previousRgpL,
                            'previous_rgp_r' => $previousRgpR,
                            'rgp_points' => $rgpPoints
                        ]);
                        
                        if ($childPlacement === 'left') {
                            $parent->rgp_l = number_format(floatval($parent->rgp_l ?? 0) + $rgpPoints, 2);
                            
                            // Log the transaction
                            $rgpTransactionService->createTransaction(
                                $parent,
                                'credit',
                                'left',
                                $rgpPoints,
                                'RGP points from ' . $user->username . '\'s purchase of ' . $plan->name,
                                'purchase',
                                $user->id,
                                $plan->id
                            );
                            
                            \Log::info('Added RGP points to left side', [
                                'parent_id' => $parent->id,
                                'new_rgp_l' => $parent->rgp_l
                            ]);
                        } elseif ($childPlacement === 'right') {
                            $parent->rgp_r = number_format(floatval($parent->rgp_r ?? 0) + $rgpPoints, 2);
                            
                            // Log the transaction
                            $rgpTransactionService->createTransaction(
                                $parent,
                                'credit',
                                'right',
                                $rgpPoints,
                                'RGP points from ' . $user->username . '\'s purchase of ' . $plan->name,
                                'purchase',
                                $user->id,
                                $plan->id
                            );
                            
                            \Log::info('Added RGP points to right side', [
                                'parent_id' => $parent->id,
                                'new_rgp_r' => $parent->rgp_r
                            ]);
                        } else {
                            \Log::warning('Could not determine child placement', [
                                'parent_id' => $parent->id,
                                'child_id' => $currentUser->id
                            ]);
                        }
                        
                        $parent->save();
                        $currentUser = $parent;
                    }
                    
                    \Log::info('Completed RGP distribution for plan purchase', [
                        'user_id' => $user->id,
                        'username' => $user->username
                    ]);
                }
            }

            if ($basic->investment_commission == 1) {
                $type = 'invest';
                DistributeBonus::dispatch($user, $request->amount, $type, $plan->id);
            }

            $msg = [
                'username' => $user->username,
                'amount' => currencyPosition($amount),
                'currency' => $basic->currency_symbol,
                'plan_name' => $plan->name
            ];

            $actionAdmin = [
                "name" => $user->firstname . ' ' . $user->lastname,
                "image" => getFile($user->image_driver, $user->image),
                "link" => "#",
                "icon" => "fas fa-ticket-alt text-white"
            ];
            $userAction = [
                "link" => route('user.invest-history'),
                "icon" => "fa fa-money-bill-alt "
            ];
            $this->adminMail('PLAN_PURCHASE_NOTIFY_TO_ADMIN', $msg);
            $this->adminPushNotification('PLAN_PURCHASE_NOTIFY_TO_ADMIN', $msg, $actionAdmin);
            $this->adminFirebasePushNotification('PLAN_PURCHASE_NOTIFY_TO_ADMIN', $msg, '#');

            $this->userPushNotification($user, 'PLAN_PURCHASE_NOTIFY_TO_USER', $msg, $userAction);
            $this->userFirebasePushNotification($user, 'PLAN_PURCHASE_NOTIFY_TO_USER', $msg, route('user.invest-history'));

            $this->sendMailSms($user, 'PLAN_PURCHASE_NOTIFY_TO_USER', $msg);

            return back()->with('success', 'Plan has been Purchased Successfully');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function payment()
    {
        $encPlanId = session()->get('plan_id');
        if ($encPlanId == null) {
            return redirect(route('user.addFund'));
        }
        $plan = ManagePlan::where('id', decrypt($encPlanId))->where('status', 1)->firstOrFail();
        $amount = session()->get('amount');
        $data['totalPayment'] = decrypt($amount);
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
        $data['plan'] = $plan;
        return view(template() . 'user.plan.payment', $data);
    }

    public function downloadInvoice($id)
    {
        $investment = Investment::with('plan', 'user')->find($id);
        
        if (!$investment || $investment->user_id != Auth::id()) {
            session()->flash('error', 'Investment not found or you do not have permission to access it.');
            return redirect()->route('user.invest-history');
        }

        $user = Auth::user();
        $basicControl = basicControl();
        
        $pdf = Pdf::loadView('pdf.investment_invoice', compact('investment', 'user', 'basicControl'));
        return $pdf->download('invoice_' . $investment->trx . '.pdf');
    }

    /**
     * Match RGP pairs by calculating the minimum of RGPL and RGPR, updating values accordingly, and returning a success response.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function matchRgpPairs()
    {
        $user = auth()->user();
        
        // Calculate the matching value (minimum of left and right)
        $rgpL = floatval($user->rgp_l ?? 0);
        $rgpR = floatval($user->rgp_r ?? 0);
        $matchingValue = min($rgpL, $rgpR);
        
        // Only process if there's a value to match
        if ($matchingValue <= 0) {
            return redirect()->back()->with('error', 'There are no RGP values to match.');
        }
        
        // Update the user's RGP values
        $user->rgp_l = number_format($rgpL - $matchingValue, 2);
        $user->rgp_r = number_format($rgpR - $matchingValue, 2);
        $user->rgp_pair_matching = 0; // Reset pair matching since we've matched it
        
        // Add the matching value to the user's balance
        $user->balance += $matchingValue;
        $user->save();
        
        // Generate a unique transaction ID for RGP matching
        $transaction_id = 'RGP' . strtoupper(uniqid(rand(10, 99)));
        
        // Create transaction record
        $transaction = new \App\Models\Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $matchingValue;
        $transaction->charge = 0;
        $transaction->final_balance = $user->balance;
        $transaction->trx_type = '+';
        $transaction->remarks = 'RGP matched profit';
        $transaction->trx_id = $transaction_id;
        $transaction->transactional_type = 'RGP';
        $transaction->balance_type = 'balance';
        $transaction->save();
        
        // Log the RGP transaction
        $rgpTransactionService = new \App\Services\RgpTransactionService();
        $rgpTransactionService->createTransaction(
            $user,
            'match',
            'both',
            $matchingValue,
            'RGP matched profit',
            'user',
            null,
            null
        );
        
        // Send notifications
        $msg = [
            'amount' => currencyPosition($matchingValue),
            'main_balance' => currencyPosition($user->balance),
            'transaction' => $transaction->trx_id
        ];
        
        $action = [
            "link" => route('user.transaction'),
            "icon" => "fa fa-money-bill-alt text-white"
        ];
        
        $firebaseAction = route('user.transaction');
        $this->userFirebasePushNotification($user, 'RGP_MATCHED', $msg, $firebaseAction);
        $this->userPushNotification($user, 'RGP_MATCHED', $msg, $action);
        $this->sendMailSms($user, 'RGP_MATCHED', $msg);
        
        return redirect()->back()->with('success', 'RGP pairs matched successfully. ' . currencyPosition($matchingValue) . ' has been added to your balance.');
    }

}
