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
        Schema::create('rgp_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_type'); // 'credit', 'debit', 'match'
            $table->string('side'); // 'left', 'right', 'both'
            $table->decimal('amount', 18, 2);
            $table->decimal('previous_rgp_l', 18, 2)->nullable();
            $table->decimal('previous_rgp_r', 18, 2)->nullable();
            $table->decimal('new_rgp_l', 18, 2)->nullable();
            $table->decimal('new_rgp_r', 18, 2)->nullable();
            $table->string('transaction_id')->unique();
            $table->string('remarks')->nullable();
            $table->string('source')->nullable(); // 'purchase', 'admin', 'system'
            $table->unsignedBigInteger('related_user_id')->nullable(); // For referrals
            $table->unsignedBigInteger('plan_id')->nullable(); // For purchases
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'transaction_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rgp_transactions');
    }
}; 