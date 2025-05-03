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
        Schema::table('users', function (Blueprint $table) {
            $table->string('rgp_l', 50)->nullable()->after('total_interest_balance')->comment('RGP Left Value');
            $table->string('rgp_r', 50)->nullable()->after('rgp_l')->comment('RGP Right Value');
            $table->string('rgp_pair_matching', 50)->nullable()->after('rgp_r')->comment('RGP Pair Matching Value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rgp_l');
            $table->dropColumn('rgp_r');
            $table->dropColumn('rgp_pair_matching');
        });
    }
};
