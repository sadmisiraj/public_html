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
            $table->decimal('subtotal', 18, 8)->after('price_per_gram')->comment('Price before GST');
            $table->decimal('gst_amount', 18, 8)->after('subtotal')->comment('GST amount (18%)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_coin_orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'gst_amount']);
        });
    }
};
