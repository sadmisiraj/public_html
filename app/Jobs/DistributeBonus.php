<?php

namespace App\Jobs;

use App\Traits\Notify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Facades\App\Services\BasicService;
use Illuminate\Support\Facades\Log;

class DistributeBonus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels , Notify;

    /**
     * Create a new job instance.
     */

    protected $user;
    protected $amount;
    protected $commissionType;
    public function __construct($user, $amount, $commissionType = null)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->commissionType = $commissionType;
    }

    /**
     * Execute the job.
     * 
     * Distributes referral bonuses to eligible users with active plans that have eligible_for_referral = 1
     */
    public function handle(): void
    {
        $user = $this->user;
        $commissionType = $this->commissionType;
        $amount = $this->amount;    

        $basic = basicControl();
        $userId = $user->id;
        $i = 1;
        $level = \App\Models\Referral::where('commission_type', $commissionType)->count();

        while ($userId != "" || $userId != "0" || $i < $level) {
            $me = \App\Models\User::with('referral')->find($userId);
            $refer = $me->referral;
            if (!$refer) {
                break;
            }
            
            // Check if the user has any plan with eligible_for_referral = 1
            $hasEligiblePlan = false;
            $userPlans = \App\Models\UserPlan::where('user_id', $refer->id)
                ->where('is_active', true)
                ->whereRaw('(expires_at IS NULL OR expires_at > NOW())')
                ->pluck('plan_id')
                ->toArray();
                
            if (!empty($userPlans)) {
                $hasEligiblePlan = \App\Models\ManagePlan::whereIn('id', $userPlans)
                    ->where('eligible_for_referral', 1)
                    ->exists();
            }
            // Skip this referrer if they don't have an eligible plan
            if (!$hasEligiblePlan) {
                $userId = $refer->id;
                $i++;
                break;
            }
            
            $commission = \App\Models\Referral::where('commission_type', $commissionType)->where('level', $i)->first();
            if (!$commission) {
                break;
            }
            $com = ($amount * $commission->percent) / 100;
            $new_bal = getAmount($refer->interest_balance + $com);
            $refer->interest_balance = $new_bal;
            $refer->total_interest_balance += $com;

            $refer->save();

            $trx = strRandom();
            $balance_type = 'interest_balance';

            $remarks = ' level ' . $i . ' Referral bonus From ' . $user->username;

            $bonus = new \App\Models\ReferralBonus();
            $bonus->from_user_id = $refer->id;
            $bonus->to_user_id = $user->id;
            $bonus->level = $i;
            $bonus->amount = getAmount($com);
            $bonus->main_balance = $new_bal;
            $bonus->type = $commissionType;
            $bonus->remarks = $remarks;
            $bonus->save();

          $transaction =  BasicService::makeTransaction($refer, $com, 0, '+', $balance_type, $bonus->transaction, $remarks);
          $bonus->transactional()->save($transaction);

            $msg = [
                'transaction_id' => $trx,
                'amount' => currencyPosition($com),
                'bonus_from' => $user->username,
                'final_balance' => $refer->interest_balance,
                'level' => $i
            ];
            $action = [
                "link" => route('user.referral.bonus'),
                "icon" => "fa fa-money-bill-alt"
            ];
            $this->sendMailSms($user, 'REFERRAL_BONUS', $msg);
            $this->userPushNotification($user, 'REFERRAL_BONUS', $msg, $action);
            $this->userFirebasePushNotification($user, 'REFERRAL_BONUS', $msg,  route('user.referral.bonus'));


            $userId = $refer->id;
            $i++;
        }
    }
}
