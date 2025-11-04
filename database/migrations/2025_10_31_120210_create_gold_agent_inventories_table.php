<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gold_agent_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gold_coin_id');
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gold_coin_id')->references('id')->on('gold_coins')->onDelete('cascade');
            $table->unique(['user_id', 'gold_coin_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gold_agent_inventories');
    }
};


