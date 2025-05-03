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
            $table->boolean('eligible_for_referral')->default(0)->comment('0 for not eligible, 1 for eligible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manage_plans', function (Blueprint $table) {
            $table->dropColumn('eligible_for_referral');
        });
    }
};
