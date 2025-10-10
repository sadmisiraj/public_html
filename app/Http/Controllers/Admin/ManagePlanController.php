<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\ManagePlan;
use App\Models\GoldCoin;
use App\Models\ManageTime;
use App\Traits\Notify;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ManagePlanController extends Controller
{
    use Notify;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.plan.index');
    }

    public function planList(Request $request)
    {
        $plans = ManagePlan::query();

        return DataTables::of($plans)
            ->addColumn('sl',function ($plan){
                static $count = 0;
                return ++$count;
            })
            ->addColumn('name',function ($plan){
                return $plan->name;
            })
            ->addColumn('price',function ($plan){
                return $plan->price;
            })
            ->addColumn('base_plan',function ($plan){
                if ($plan->base_plan_id) {
                    $basePlan = ManagePlan::find($plan->base_plan_id);
                    return $basePlan ? $basePlan->name : 'N/A';
                }
                return '<span class="badge bg-light text-dark">None</span>';
            })
            ->addColumn('status',function ($plan){
                return $plan->statusMessage;
            })
            ->addColumn('featured',function ($plan){
                return $plan->featuredMessage;
            })
            ->addColumn('eligible_for_referral',function ($plan){
                return $plan->referralEligibilityMessage;
            })
            ->addColumn('action',function ($plan){
                if (adminAccessRoute(config('role.manage_plan.access.edit'))){
                    $html = '<a class="btn btn-white btn-sm edit_btn" href="'.route('admin.plan.edit',$plan->id).'" >
                    <i class="fa-thin fa-pen-to-square"></i> Edit
                  </a>';

                    return $html;
                }
                return  '';

            })
            ->rawColumns(['price','action','status','featured','eligible_for_referral','base_plan'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $times = ManageTime::latest()->get();
        $plans = ManagePlan::where('status', 1)->get();
        $goldCoins = GoldCoin::active()->get();
        return view('admin.plan.create', compact('times', 'plans', 'goldCoins'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reqData = $request->all();
        $request->validate([
            'name' => 'required',
            'schedule' => 'required',
            'profit' => 'nullable|numeric|min:0',
            'referral_levels' => 'required|integer|min:1|max:10',
            'gold_coin_id' => 'nullable|exists:gold_coins,id',
            'gold_weight_in_grams' => 'nullable|numeric|min:0.00000001',
            'referral_percent.*' => 'nullable|numeric|min:0',
            'is_lifetime' => [function ($attribute, $value, $fail)use($request) {
                if ($value==1 && $request->is_capital_back==1) {
                    $fail('When capital back is on then you can not on lifetime feature');
                }
            }]
        ]);

        if (!is_numeric($request->schedule)){
            return back()->withErrors(['error' => 'The schedule field must be a number']);
        }
        $minimum_amount = $reqData['minimum_amount'];
        $maximum_amount = $reqData['maximum_amount'];
        $fixed_amount = $reqData['plan_price_type'] == 1 ? $reqData['fixed_amount'] : 0;
        $profit_type = (int)$reqData['profit_type'];

        $repeatable = $reqData['is_lifetime'] == 1 ? 0 : $reqData['repeatable'];

        $featured = $reqData['featured'];
        $eligible_for_referral = $reqData['eligible_for_referral'] ?? 0;
        $eligible_for_rgp = $reqData['eligible_for_rgp'] ?? 0;
        $allow_multiple_purchase = $reqData['allow_multiple_purchase'] ?? 0;
        $referral_levels = $reqData['referral_levels'] ?? 1;
        $return_as_gold = $reqData['return_as_gold'] ?? 0;
        $gold_coin_id = $reqData['gold_coin_id'] ?? null;
        $gold_weight_in_grams = $reqData['gold_weight_in_grams'] ?? null;

        if ($return_as_gold) {
            if (!$gold_coin_id || !$gold_weight_in_grams) {
                return back()->with('error', 'Gold coin and weight are required when Return as Gold is enabled.')->withInput();
            }
        }

        if (($minimum_amount < 0 || $maximum_amount < 0) && $fixed_amount < 0) {
            return back()->with('error', 'Invest Amount cannot lower than 0')->withInput();
        }
        if (0 > $reqData['profit']) {
            return back()->with('error', 'Interest cannot lower than 0')->withInput();
        }
        if (0 > $repeatable) {
            return back()->with('error', 'Return Time cannot lower than 0')->withInput();
        }

        $data = new ManagePlan();
        $data->name = $reqData['name'];
        $data->badge = $reqData['badge'];
        $data->minimum_amount = $minimum_amount;
        $data->maximum_amount = $maximum_amount;
        $data->fixed_amount = $fixed_amount;
        $data->profit = $reqData['profit'];
        $data->profit_type = $profit_type;
        $data->schedule = $reqData['schedule'];
        $data->status = $reqData['status'];
        $data->is_capital_back = $reqData['is_capital_back'];
        $data->is_lifetime = $reqData['is_lifetime'];
        $data->repeatable = $repeatable;
        $data->featured = $featured;
        $data->eligible_for_referral = $eligible_for_referral;
        $data->eligible_for_rgp = $eligible_for_rgp;
        $data->base_plan_id = $reqData['base_plan_id'] ?? null;
        $data->allow_multiple_purchase = $allow_multiple_purchase;
        $data->referral_levels = $referral_levels;
        $data->return_as_gold = $return_as_gold;
        $data->gold_coin_id = $gold_coin_id;
        $data->gold_weight_in_grams = $gold_weight_in_grams;
        $data->save();

        // Save per-plan referral percents if provided
        if (!empty($reqData['referral_percent']) && is_array($reqData['referral_percent'])) {
            \App\Models\Referral::where('commission_type', 'invest')->where('plan_id', $data->id)->delete();
            $levelCount = (int) $referral_levels;
            for ($k = 1; $k <= $levelCount; $k++) {
                if (!isset($reqData['referral_percent'][$k])) continue;
                $percent = $reqData['referral_percent'][$k];
                if ($percent === null || $percent === '') continue;
                $ref = new \App\Models\Referral();
                $ref->commission_type = 'invest';
                $ref->plan_id = $data->id;
                $ref->level = $k;
                $ref->percent = $percent;
                $ref->save();
            }
        }

        return back()->with('success', 'Plan has been Added');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ManagePlan::findOrFail($id);
        $times = ManageTime::latest()->get();
        $plans = ManagePlan::where('status', 1)->where('id', '!=', $id)->get();
        $goldCoins = GoldCoin::active()->get();
        return view('admin.plan.edit', compact('data', 'times', 'plans', 'goldCoins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = ManagePlan::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'schedule' => 'numeric|min:0',
            'profit' => 'nullable|numeric|min:0',
            'referral_levels' => 'required|integer|min:1|max:10',
            'repeatable' => 'sometimes|required',
            'gold_coin_id' => 'nullable|exists:gold_coins,id',
            'gold_weight_in_grams' => 'nullable|numeric|min:0.00000001',
            'referral_percent.*' => 'nullable|numeric|min:0',
            'is_lifetime' => [function ($attribute, $value, $fail)use($request) {
                    if ($value==1 && $request->is_capital_back==1) {
                        $fail('When capital back is on then you can not on lifetime feature');
                    }
            }]
        ], [
            'schedule|numeric' => 'Accrual field is required'
        ]);
        $reqData = $request->all();


        $minimum_amount = $reqData['minimum_amount'];
        $maximum_amount = $reqData['maximum_amount'];
        $fixed_amount = isset($reqData['plan_price_type']) ? $reqData['fixed_amount'] : 0;
        $profit_type = (int)$reqData['profit_type'];
        $repeatable = $reqData['is_lifetime'] ? 0  : $reqData['repeatable'];
        $featured = $reqData['featured'];
        $eligible_for_referral = $reqData['eligible_for_referral'] ?? 0;
        $eligible_for_rgp = $reqData['eligible_for_rgp'] ?? 0;
        $allow_multiple_purchase = $reqData['allow_multiple_purchase'] ?? 0;
        $referral_levels = $reqData['referral_levels'] ?? 1;
        $return_as_gold = $reqData['return_as_gold'] ?? 0;
        $gold_coin_id = $reqData['gold_coin_id'] ?? null;
        $gold_weight_in_grams = $reqData['gold_weight_in_grams'] ?? null;

        if ($return_as_gold) {
            if (!$gold_coin_id || !$gold_weight_in_grams) {
                return back()->with('error', 'Gold coin and weight are required when Return as Gold is enabled.')->withInput();
            }
        } else {
            $gold_coin_id = null;
            $gold_weight_in_grams = null;
        }

        if (($minimum_amount < 0 || $maximum_amount < 0) && $fixed_amount < 0) {
            return back()->with('error', 'Invest Amount cannot lower than 0')->withInput();
        }
        if ($reqData['profit'] < 0) {
            return back()->with('error', 'Interest cannot lower than 0')->withInput();
        }
        if ($repeatable < 0) {
            return back()->with('error', 'Return Time cannot lower than 0')->withInput();
        }

        // Validate that base_plan_id is not the same as the plan's id
        if (isset($reqData['base_plan_id']) && $reqData['base_plan_id'] == $id) {
            return back()->with('error', 'A plan cannot be its own base plan')->withInput();
        }

        $data->name = $reqData['name'];
        $data->badge = $reqData['badge'];
        $data->minimum_amount = $minimum_amount;
        $data->maximum_amount = $maximum_amount;
        $data->fixed_amount = $fixed_amount;
        $data->profit = $reqData['profit'];
        $data->profit_type = $profit_type;
        $data->schedule = $reqData['schedule'];
        $data->status = $reqData['status'];
        $data->is_capital_back = $reqData['is_capital_back'];
        $data->is_lifetime = $reqData['is_lifetime'];
        $data->repeatable = $repeatable;
        $data->featured = $featured;
        $data->eligible_for_referral = $eligible_for_referral;
        $data->eligible_for_rgp = $eligible_for_rgp;
        $data->base_plan_id = $reqData['base_plan_id'] ?? null;
        $data->allow_multiple_purchase = $allow_multiple_purchase;
        $data->referral_levels = $referral_levels;
        $data->return_as_gold = $return_as_gold;
        $data->gold_coin_id = $gold_coin_id;
        $data->gold_weight_in_grams = $gold_weight_in_grams;
        $data->save();

        // Save per-plan referral percents if provided
        if (!empty($reqData['referral_percent']) && is_array($reqData['referral_percent'])) {
            \App\Models\Referral::where('commission_type', 'invest')->where('plan_id', $data->id)->delete();
            $levelCount = (int) $referral_levels;
            for ($k = 1; $k <= $levelCount; $k++) {
                if (!isset($reqData['referral_percent'][$k])) continue;
                $percent = $reqData['referral_percent'][$k];
                if ($percent === null || $percent === '') continue;
                $ref = new \App\Models\Referral();
                $ref->commission_type = 'invest';
                $ref->plan_id = $data->id;
                $ref->level = $k;
                $ref->percent = $percent;
                $ref->save();
            }
        }

        return back()->with('success', 'Plan has been Updated');
    }

    public function activeMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            ManagePlan::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            session()->flash('success', 'User Status Has Been Active');
            return response()->json(['success' => 1]);
        }
    }

    public function inActiveMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            ManagePlan::whereIn('id', $request->strIds)->update([
                'status' => 0,
            ]);
            session()->flash('success', 'User Status Has Been Deactivate');
            return response()->json(['success' => 1]);
        }
    }
    public function investments()
    {
       return view('admin.investment.index');
    }

    public function investmentList(Request $request)
    {
        $invesments = Investment::query()->with(['user:id,firstname,lastname,username,image,image_driver','plan:id,name,minimum_amount,maximum_amount'])->orderBy('created_at', 'desc');

        return DataTables::of($invesments)
            ->addColumn('sl', function ($invest) {
                static $counter = 0;
                return ++$counter;
            })
            ->addColumn('name', function ($invest) {
                return $invest->getUser();
            })
            ->addColumn('plan', function ($invest) {
                return $invest->getPlan();
            })
            ->addColumn('return_interest', function ($invest) {
                return currencyPosition($invest->profit) . ' ' . ($invest->period == '-1' ? trans('For Lifetime') : 'per ' . trans($invest->point_in_text));
            })
            ->addColumn('received_amount', function ($invest) {
                return $invest->recurring_time.' x '.$invest->profit.' = '.currencyPosition($invest->recurring_time*$invest->profit);
            })
            ->addColumn('upcoming_payment', function ($invest) {
                if ($invest->status == 1) {
                    return "<span class='next-payment' data-payment='" . $invest->afterward . "'>" . dateTime($invest->afterward) . "</span>";

                } elseif($invest->status == 0) {
                    return '<span class="badge bg-soft-success text-success"><span class="legend-indicator bg-success"></span>Completed</span>';
                }else{
                    return '<span class="badge bg-soft-danger text-danger"><span class="legend-indicator bg-danger"></span>Terminated</span>';

                }

            })
            ->addColumn('action', function ($invest) {

                if ($invest->status == 1 && adminAccessRoute(config('role.investment.access.edit'))){
                    return '<button type="button" class="btn btn-white btn-sm terminate_btn" data-route="'.route("admin.terminate.investment",$invest->id).'" data-bs-toggle="modal" data-bs-target="#InvestTerminateModal">
                <i class="bi bi-x-square me-1"></i> Terminate
              </button>';
                }else {
                    return '--';
                }
            })
            ->rawColumns(['return_interest', 'received_amount', 'upcoming_payment','plan','name','action'])
            ->make(true);

    }

    public function terminateInvestment(Request $request , $id)
    {
        $investment = Investment::findOrFail($id);
        $terminate_charge = basicControl()->terminate_charge;
        $user = $investment->user;
        $amount = $investment->amount;
        $charge = ($amount*$terminate_charge)/100;
        if ($user->balance < $charge) {
            return back()->with('error', 'Insufficient Balance');
        }else{
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
        $this->userPushNotification($user,'TERMINATE_INVESTMENT',$msg,$action);
        $this->userFirebasePushNotification($user,'TERMINATE_INVESTMENT',$msg,route('user.invest-history'));
        $this->sendMailSms($user,'TERMINATE_INVESTMENT',$msg);
        return back()->with('success', 'Investment has been Terminated');
    }

}
