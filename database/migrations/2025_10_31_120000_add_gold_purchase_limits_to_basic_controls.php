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
            $table->boolean('gold_purchase_limit_enabled')->default(false)->after('withdrawal_limit_days');
            $table->string('gold_purchase_limit_type')->default('daily')->after('gold_purchase_limit_enabled')->comment('daily, weekly, custom_days');
            $table->integer('gold_purchase_limit_count')->default(1)->after('gold_purchase_limit_type')->comment('Number of gold purchases allowed');
            $table->integer('gold_purchase_limit_days')->default(1)->after('gold_purchase_limit_count')->comment('Number of days for custom_days type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_controls', function (Blueprint $table) {
            $table->dropColumn([
                'gold_purchase_limit_enabled',
                'gold_purchase_limit_type',
                'gold_purchase_limit_count',
                'gold_purchase_limit_days',
            ]);
        });
    }
};


