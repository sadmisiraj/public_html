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
            $table->decimal('balance', 11, 2)->default(0)->change();
            $table->decimal('interest_balance', 11, 2)->default(0)->change();
            $table->decimal('profit_balance', 11, 2)->default(0)->change();
            $table->decimal('total_invest', 11, 2)->default(0)->change();
            $table->decimal('total_deposit', 11, 2)->default(0)->change();
            $table->decimal('total_interest_balance', 11, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('balance', 11, 2)->nullable()->change();
            $table->decimal('interest_balance', 11, 2)->default(null)->change();
            $table->decimal('profit_balance', 11, 2)->default(null)->change();
            $table->decimal('total_invest', 11, 2)->default(null)->change();
            $table->decimal('total_deposit', 11, 2)->default(null)->change();
            $table->decimal('total_interest_balance', 11, 2)->default(null)->change();
        });
    }
}; 