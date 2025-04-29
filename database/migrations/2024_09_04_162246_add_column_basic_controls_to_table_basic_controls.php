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
            $table->decimal('min_transfer',11,2)->default(0.00)->after('deposit_commission');
            $table->decimal('max_transfer',11,2)->default(0.00)->after('deposit_commission');
            $table->decimal('transfer_charge',11,2)->default(0.00)->after('deposit_commission');
            $table->boolean('joining_bonus')->default(false)->after('deposit_commission');
            $table->decimal('bonus_amount',11,2)->default(0)->after('deposit_commission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_controls', function (Blueprint $table) {
            //
        });
    }
};
