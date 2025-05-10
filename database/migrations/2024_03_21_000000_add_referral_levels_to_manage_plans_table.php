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
        Schema::table('manage_plans', function (Blueprint $table) {
            $table->integer('referral_levels')->default(1)->after('eligible_for_referral')->comment('Number of referral levels (1-10)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manage_plans', function (Blueprint $table) {
            $table->dropColumn('referral_levels');
        });
    }
}; 