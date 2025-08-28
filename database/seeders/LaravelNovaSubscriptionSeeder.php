<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LaravelNovaSubscription;
use Carbon\Carbon;

class LaravelNovaSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if subscription already exists
        if (LaravelNovaSubscription::count() > 0) {
            return;
        }

        // Create default subscription
        LaravelNovaSubscription::create([
            'subscription_name' => 'Laravel Nova Pro',
            'monthly_price' => 499.00,
            'status' => 'active',
            'start_date' => Carbon::create(null, 8, 15), // August 15 of current year
            'last_renewed_date' => Carbon::create(null, 8, 15), // August 15 of current year
            'next_renewal_date' => Carbon::create(null, 9, 15), // September 15 of current year
            'renewal_code' => null,
            'notes' => 'Initial subscription created by system seeder. Price: ₹499/month.',
        ]);

        $this->command->info('Laravel Nova subscription seeded successfully!');
    }
}
