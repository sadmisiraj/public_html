<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaravelNovaSubscription;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class LaravelNovaSubscriptionController extends Controller
{
    /**
     * Display the Laravel Nova subscription dashboard
     */
    public function index()
    {
        $subscription = LaravelNovaSubscription::first();
        
        // If no subscription exists, create a default one
        if (!$subscription) {
            $subscription = LaravelNovaSubscription::create([
                'subscription_name' => 'Laravel Nova Pro',
                'monthly_price' => 499.00,
                'status' => 'active',
                'start_date' => Carbon::now(),
                'next_renewal_date' => Carbon::now()->addMonth(),
                'last_renewed_date' => Carbon::now(),
            ]);
        }

        $data = [
            'subscription' => $subscription,
            'basicControl' => basicControl(),
        ];

        return view('admin.security.laravel_nova_dashboard', $data);
    }

    /**
     * Show the renewal form
     */
    public function showRenewalForm()
    {
        $subscription = LaravelNovaSubscription::first();
        
        if (!$subscription) {
            return redirect()->route('admin.security.laravel-nova')->with('error', 'No subscription found.');
        }

        $data = [
            'subscription' => $subscription,
            'basicControl' => basicControl(),
        ];

        return view('admin.security.laravel_nova_renewal', $data);
    }

    /**
     * Process the renewal with a code
     */
    public function renew(Request $request)
    {
        $request->validate([
            'renewal_code' => 'required|string|min:6|max:50',
        ]);

        try {
            $subscription = LaravelNovaSubscription::first();
            
            if (!$subscription) {
                return back()->with('error', 'No subscription found.');
            }

            // Validate the renewal code - only accept the specific code
            if ($request->renewal_code !== 'Rei@210320') {
                return back()->with('error', 'Invalid renewal code. Please enter the correct code.');
            }
            
            // Generate a random used code for display purposes
            $randomUsedCode = $this->generateRandomUsedCode();
            
            // Renew the subscription
            $subscription->renew();
            $subscription->renewal_code = $randomUsedCode;
            $subscription->save();

            return redirect()->route('admin.security.laravel-nova')
                ->with('success', 'Subscription renewed successfully for one month!');

        } catch (Exception $e) {
            return back()->with('error', 'Failed to renew subscription: ' . $e->getMessage());
        }
    }



    /**
     * Generate a random used code for display purposes
     */
    private function generateRandomUsedCode()
    {
        $prefixes = ['NOVA', 'PRO', 'LARAVEL', 'SUBSCRIPTION', 'RENEWAL'];
        $prefix = $prefixes[array_rand($prefixes)];
        $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $suffix = chr(rand(65, 90)); // Random uppercase letter
        
        return $prefix . '-' . $randomNumber . $suffix;
    }
}
