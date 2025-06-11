<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('basic_controls', function (Blueprint $table) {
            $table->boolean('money_transfer_limit_enabled')->default(false)->after('require_money_transfer_otp');
            $table->string('money_transfer_limit_type')->default('daily')->after('money_transfer_limit_enabled')->comment('daily, weekly, custom_days');
            $table->integer('money_transfer_limit_count')->default(1)->after('money_transfer_limit_type')->comment('Number of transfers allowed');
            $table->integer('money_transfer_limit_days')->default(1)->after('money_transfer_limit_count')->comment('Number of days for custom_days type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_controls', function (Blueprint $table) {
            $table->dropColumn([
                'money_transfer_limit_enabled',
                'money_transfer_limit_type',
                'money_transfer_limit_count',
                'money_transfer_limit_days'
            ]);
        });
    }
}; 