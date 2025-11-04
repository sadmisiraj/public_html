<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gold_agent_inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gold_coin_id');
            $table->string('change_type'); // admin_add, admin_remove, admin_adjust, agent_deliver
            $table->integer('quantity_change'); // positive or negative
            $table->string('reference')->nullable(); // e.g., order trx id
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gold_coin_id')->references('id')->on('gold_coins')->onDelete('cascade');
            $table->index(['user_id', 'gold_coin_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gold_agent_inventory_logs');
    }
};


