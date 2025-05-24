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
        Schema::create('gold_coins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Variant name');
            $table->string('karat')->comment('Gold karat (e.g., 22K, 24K)');
            $table->decimal('price_per_gram', 18, 8)->comment('Price per gram');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_driver', 50)->nullable();
            $table->boolean('status')->default(1)->comment('0: inactive, 1: active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_coins');
    }
};
