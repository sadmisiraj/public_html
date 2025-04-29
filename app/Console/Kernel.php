<?php

namespace App\Console;

use App\Console\Commands\DistributeProfit;
use App\Console\Commands\PayoutCryptoCurrencyUpdateCron;
use App\Console\Commands\PayoutCurrencyUpdateCron;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{


    protected $commands = [
        PayoutCurrencyUpdateCron::class,
        PayoutCryptoCurrencyUpdateCron::class,
        DistributeProfit::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('distribute-profit')->everyFiveMinutes();
        $basicControl = basicControl();
        if ($basicControl->currency_layer_auto_update == 1) {
            $schedule->command('payout-currency:update')
                ->{basicControl()->currency_layer_auto_update_at}();
        }
        if ($basicControl->coin_market_cap_auto_update == 1) {
            $schedule->command('payout-crypto-currency-update-cron')->{basicControl()->coin_market_cap_auto_update_at}();
        }
        $schedule->command('model:prune')->days(1);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
