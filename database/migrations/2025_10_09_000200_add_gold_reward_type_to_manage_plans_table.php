<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('manage_plans', function (Blueprint $table) {
            $table->tinyInteger('gold_reward_type')->default(0)->after('gold_weight_in_grams')->comment('0=fixed weight per accrual, 1=coins per 1 lakh');
            $table->decimal('gold_coins_per_lakh', 18, 8)->nullable()->after('gold_reward_type');
        });
    }

    public function down(): void
    {
        Schema::table('manage_plans', function (Blueprint $table) {
            $table->dropColumn(['gold_reward_type', 'gold_coins_per_lakh']);
        });
    }
};


