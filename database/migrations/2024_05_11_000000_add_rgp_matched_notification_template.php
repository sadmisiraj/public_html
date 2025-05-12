<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the notification_templates table exists
        if (Schema::hasTable('notification_templates')) {
            // Check if the RGP_MATCHED template already exists
            $exists = DB::table('notification_templates')
                ->where('template_key', 'RGP_MATCHED')
                ->exists();
            
            if (!$exists) {
                DB::table('notification_templates')->insert([
                    'language_id' => 1,
                    'name' => 'RGP Matching Profit',
                    'email_from' => 'support@site.com',
                    'template_key' => 'RGP_MATCHED',
                    'subject' => 'RGP Matching Profit Added',
                    'short_keys' => json_encode([
                        "amount" => "Matched Amount",
                        "main_balance" => "Main Balance",
                        "transaction" => "Transaction Number"
                    ]),
                    'email' => 'Your RGP matching has been processed. Amount [[amount]] has been added to your balance. Your current balance is [[main_balance]]. Transaction: [[transaction]]',
                    'sms' => 'Your RGP matching has been processed. Amount [[amount]] has been added to your balance. Your current balance is [[main_balance]]. Transaction: [[transaction]]',
                    'in_app' => 'Your RGP matching has been processed. Amount [[amount]] has been added to your balance. Your current balance is [[main_balance]]. Transaction: [[transaction]]',
                    'push' => 'Your RGP matching has been processed. Amount [[amount]] has been added to your balance. Transaction: [[transaction]]',
                    'status' => json_encode([
                        "mail" => "1",
                        "sms" => "1",
                        "in_app" => "1",
                        "push" => "1"
                    ]),
                    'notify_for' => 0, // 0 for user
                    'lang_code' => 'en',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('notification_templates')) {
            DB::table('notification_templates')
                ->where('template_key', 'RGP_MATCHED')
                ->delete();
        }
    }
}; 