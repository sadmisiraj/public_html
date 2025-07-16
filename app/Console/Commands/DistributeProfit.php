<?php

namespace App\Console\Commands;

use App\Jobs\DistributeBonus;
use App\Models\Investment;
use App\Models\Holiday;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Facades\App\Services\BasicService;

class DistributeProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distribute-profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron for investment Status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('max_execution_time', 300);
        $now = Carbon::now();
        $basic = basicControl();

        // Check if today is a holiday and profit distribution on holidays is disabled
        if ($basic->holiday_profit_disable && Holiday::isHoliday()) {
            $this->info('Today is a holiday. Profit distribution is skipped.');
            return;
        }

        DB::transaction(function () use ($basic, $now) {
            // Use lockForUpdate to prevent race conditions
            Investment::with(['user:id,firstname,lastname,username,email,phone_code,phone,balance,interest_balance', 'plan'])
                ->has('user')
                ->whereHas('plan')
                ->whereStatus(1)
                ->where('afterward', '<=', $now)
                ->lockForUpdate() // Add locking to prevent race conditions
                ->chunk(100, function ($investments) use ($basic, $now) {
                    foreach ($investments as $data) {
                        // Double-check that the investment is still eligible for profit distribution
                        // This prevents processing investments that might have been updated by another process
                        if ($data->afterward > $now || $data->status != 1) {
                            continue;
                        }

                        $pointTime = (float) $data->point_in_time;

                        $next_time = Carbon::parse($now)->addHours($pointTime);
                        $invest = $data;
                        $invest->recurring_time += 1;
                        $invest->afterward = $next_time; // next Profit will get
                        $invest->formerly = $now; // Last Time Get Profit

                        // Return Amount to user's Interest Balance
                        $user = $data->user;

                        $new_balance = getAmount($user->interest_balance + $data->profit);
                        $user->interest_balance = $new_balance;
                        $user->total_interest_balance += $data->profit;
                        $user->save();

                        $remarks = currencyPosition($data->profit) . ' Daily Profit From ' . optional($invest->plan)->name;
                        $transaction = BasicService::makeTransaction($user, $data->profit, 0, '+', 'interest_balance', null, $remarks);
                        $invest->transactional()->save($transaction);
                        // Complete the investment if user get full amount as plan
                        if ($invest->recurring_time >= $data->maturity && $data->maturity != '-1') {
                            $invest->status = 0; // stop return Back
                            // Give the capital back if plan says the same
                            if ($data->capital_back == 1) {
                                $capital = $data->amount;
                                $new_balance = getAmount($user->interest_balance + $capital);
                                $user->interest_balance = $new_balance;
                                $user->save();
                                $remarks = currencyPosition($capital) . ' Capital Back From ' . optional($invest->plan)->name;
                                $transaction = BasicService::makeTransaction($user, getAmount($capital), 0, '+', 'interest_balance', null, $remarks);
                                $invest->transactional()->save($transaction);
                            }
                        }

                        $invest->status = ($data->period == '-1') ? 1 : $invest->status; // Plan will run Lifetime
                        $invest->save();

                        if ($basic->profit_commission == 1) {
                            DistributeBonus::dispatch($user, $data->profit, 'profit_commission', 0);
                        }
                    }
                });
        });

    }
}
