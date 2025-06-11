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
        Schema::table('gold_coin_orders', function (Blueprint $table) {
            $table->json('purchase_charges')->nullable()->after('subtotal')->comment('JSON data of all purchase charges applied');
            $table->decimal('total_charges', 18, 8)->default(0)->after('purchase_charges')->comment('Total amount of all charges');
            // We'll keep gst_amount for backward compatibility but it will be calculated from purchase_charges
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_coin_orders', function (Blueprint $table) {
            $table->dropColumn(['purchase_charges', 'total_charges']);
        });
    }
};
