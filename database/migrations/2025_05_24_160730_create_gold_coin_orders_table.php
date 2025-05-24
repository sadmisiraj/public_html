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
        Schema::create('gold_coin_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gold_coin_id');
            $table->decimal('weight_in_grams', 18, 8);
            $table->decimal('price_per_gram', 18, 8);
            $table->decimal('total_price', 18, 8);
            $table->string('payment_source')->comment('deposit, profit, performance');
            $table->string('status')->default('pending')->comment('pending, processing, completed, cancelled, refunded');
            $table->text('admin_feedback')->nullable();
            $table->string('trx_id')->unique();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gold_coin_id')->references('id')->on('gold_coins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_coin_orders');
    }
};
