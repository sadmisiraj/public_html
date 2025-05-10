<?php

namespace App\Services;


use App\Jobs\DistributeBonus;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\ManagePlan;
use App\Models\ManageTime;
use App\Models\Transaction;
use App\Traits\Notify;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BasicService
{
    use Notify;

    public function setEnv($value)
    {
        $envPath = base_path('.env');
        $env = file($envPath);
        foreach ($env as $env_key => $env_value) {
            $entry = explode("=", $env_value, 2);
            $env[$env_key] = array_key_exists($entry[0], $value) ? $entry[0] . "=" . $value[$entry[0]] . "\n" : $env_value;
        }
        $fp = fopen($envPath, 'w');
        fwrite($fp, implode($env));
        fclose($fp);
    }

    public function preparePaymentUpgradation($deposit)
    {

        try {
            DB::beginTransaction();
            if ( $deposit && $deposit->depositable_type == Deposit::class){
                if ($deposit->status == 0 || $deposit->status == 2) {
                    $deposit->status = 1;
                    $deposit->save();

                    if ($deposit->user) {
                        $user = $deposit->user;
                        $user->balance += $deposit->payable_amount_in_base_currency;
                        $user->total_deposit += $deposit->payable_amount_in_base_currency;
                        $user->save();

                        $transaction = new Transaction();
                        $transaction->user_id = $deposit->user_id;
                        $transaction->amount = $deposit->payable_amount_in_base_currency;
                        $transaction->charge = getAmount($deposit->base_currency_charge);
                        $transaction->final_balance = getAmount($user->balance);
                        $transaction->trx_type = '+';
                        $transaction->trx_id = $deposit->trx_id;
                        $transaction->remarks = 'Deposit Via ' . optional($deposit->gateway)->name;
                        $deposit->transactional()->save($transaction);
                        $deposit->save();
                        DB::commit();
                        $amount = $deposit->payable_amount_in_base_currency;
                        $basic = basicControl();
                        if ($basic->deposit_commission == 1) {
                            DistributeBonus::dispatch($user, $amount,  'deposit', 0);
                        }

                        $params = [
                            'amount' => currencyPosition($amount+0),
                            'transaction' => $deposit->trx_id,
                        ];



                        $action = [
                            "link" => "#",
                            "icon" => "fa fa-money-bill-alt text-white"
                        ];

                        $firebaseAction = '#';
                        $this->sendMailSms($deposit->user, 'ADD_FUND_USER_USER', $params);
                        $this->userPushNotification($deposit->user, 'ADD_FUND_USER_USER', $params, $action);
                        $this->userFirebasePushNotification($deposit->user, 'ADD_FUND_USER_USER', $params, $firebaseAction);

                        $params = [
                            'username' => optional($deposit->user)->username,
                            'amount' => currencyPosition($amount+0),
                            'transaction' => $deposit->trx_id,
                        ];
                        $actionAdmin = [
                            "name" => optional($deposit->user)->firstname . ' ' . optional($deposit->user)->lastname,
                            "image" => getFile(optional($deposit->user)->image_driver, optional($deposit->user)->image),
                            "link" => "#",
                            "icon" => "fas fa-ticket-alt text-white"
                        ];

                        $firebaseAction = "#";

                        $this->adminMail('ADD_FUND_USER_ADMIN', $params);
                        $this->adminPushNotification('ADD_FUND_USER_ADMIN', $params, $actionAdmin);
                        $this->adminFirebasePushNotification('ADD_FUND_USER_ADMIN', $params, $firebaseAction);

                    }


                    return true;
                }
            }elseif ($deposit && $deposit->depositable_type == ManagePlan::class){
                $plan = ManagePlan::where('id', $deposit->depositable_id)->first();
                $basic = basicControl();

                if ($plan){
                    $deposit->status = 1;
                    $deposit->save();
                    $amount = $deposit->payable_amount_in_base_currency;
                    $user = $deposit->user;
                    $user->total_invest += $amount;
                    $user->save();

                    $profit = ($plan->profit_type == 1) ? ($amount * $plan->profit) / 100 : $plan->profit;
                    $maturity = ($plan->is_lifetime == 1) ? '-1' : $plan->repeatable;

                    $timeManage = ManageTime::where('time', $plan->schedule)->first();

                   // For Fixed Plan
                    $invest = null;
                    if ($plan->fixed_amount != 0 && ($plan->fixed_amount == $amount)) {
                       $invest = $this->makeInvest($user, $plan, $amount, $profit, $maturity, $timeManage);
                    } elseif ($plan->fixed_amount == 0) {
                       $invest = $this->makeInvest($user, $plan, $amount, $profit, $maturity, $timeManage);
                    }
                    $charge = getAmount($deposit->base_currency_charge);

                    if ($invest){
                        $remarks = 'Invested On ' . $plan->name;
                        $trx = $invest->trx;
                       $transaction = $this->makeTransaction($user, $amount, $charge, '-','payment',  $trx, $remarks);
                        $plan->transactional()->save($transaction);
                    }

                    DB::commit();
                    if ($basic->investment_commission == 1) {
                        DistributeBonus::dispatch($user, $amount, 'invest', $plan->id);
                    }

                    $msg = [
                        'username' => $user->username,
                        'amount' => currencyPosition($amount+0),
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
                    $this->userFirebasePushNotification($user, 'PLAN_PURCHASE_NOTIFY_TO_USER', $msg,  route('user.invest-history'));

                    $this->sendMailSms($user, 'PLAN_PURCHASE_NOTIFY_TO_USER', $msg);

                }
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            Log::error('Deposit update error: ' . $e->getMessage());
        }
    }

    public function makeInvest($user, $plan, $amount, $profit, $maturity, $timeManage)
    {
        $invest = new Investment();
        $invest->user_id = $user->id;
        $invest->plan_id = $plan->id;
        $invest->amount = $amount;
        $invest->profit = $profit;
        $invest->maturity = $maturity;
        $invest->point_in_time = $plan->schedule;
        $invest->point_in_text = $timeManage->name;
        $invest->afterward = Carbon::parse(now())->addHours($plan->schedule);
        $invest->status = 1;
        $invest->capital_back = $plan->is_capital_back;
        $invest->save();
        return $invest;
    }

    public function makeTransaction($user, $amount, $charge, $trx_type = null, $balance_type, $trx_id, $remarks = null)
    {
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = getAmount($amount);
        $transaction->charge = $charge;
        $transaction->trx_type = $trx_type;
        $transaction->balance_type = $balance_type;
        $transaction->final_balance = $user[$balance_type];
        if ($trx_id){
            $transaction->trx_id = $trx_id;
        }
        $transaction->remarks = $remarks;
        $transaction->save();

        return $transaction;
    }



    public function cryptoQR($wallet, $amount, $crypto = null)
    {
        $varb = $wallet . "?amount=" . $amount;
        return "https://quickchart.io/chart?cht=qr&chl=$varb";
    }
}
