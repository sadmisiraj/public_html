<?php

namespace App\Console\Commands;

use App\Models\LaravelNovaSubscription;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckSubscriptionExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update Laravel Nova subscription status when expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking subscription expiration...');

        try {
            $subscription = LaravelNovaSubscription::first();

            if (!$subscription) {
                $this->warn('No subscription found.');
                return 0;
            }

            // Check if subscription has expired
            if ($subscription->isExpired() && $subscription->status !== 'expired') {
                $subscription->status = 'expired';
                $subscription->save();
                
                $this->info('Subscription has expired. Status updated to expired.');
                $this->info('Ads will now be automatically enabled for eligible users.');
                
                \Log::info('Subscription expired automatically', [
                    'subscription_id' => $subscription->id,
                    'next_renewal_date' => $subscription->next_renewal_date,
                    'status' => 'expired'
                ]);
            } elseif ($subscription->isActive()) {
                $this->info('Subscription is active. Next renewal: ' . $subscription->next_renewal_date->format('Y-m-d'));
            } else {
                $this->info('Subscription status: ' . $subscription->status);
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('Error checking subscription: ' . $e->getMessage());
            \Log::error('Error in CheckSubscriptionExpiration command', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }
}




