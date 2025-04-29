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
        Schema::create('manage_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->nullable();
            $table->string('badge',191)->nullable();
            $table->string('minimum_amount',20)->nullable();
            $table->string('maximum_amount',20)->nullable();
            $table->string('fixed_amount',20)->nullable();
            $table->decimal('profit',11,2)->nullable()->comment('Yield');
            $table->boolean('profit_type')->default(0)->comment('1 for percent(%) / 0 For Base Currency');
            $table->integer('schedule')->nullable()->comment('Accrual');
            $table->boolean('status')->default(0)->comment('0 for Inactive, 1 for Active');
            $table->boolean('is_capital_back')->default(0);
            $table->boolean('is_lifetime')->default(0);
            $table->integer('repeatable')->nullable()->comment('Maturity');
            $table->boolean('featured')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manage_plans');
    }
};
