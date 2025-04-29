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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->decimal('amount',11,2)->nullable();
            $table->decimal('profit',11,2)->nullable();
            $table->integer('maturity')->nullable();
            $table->string('point_in_time',50)->nullable();
            $table->string('point_in_text',60)->nullable();
            $table->unsignedBigInteger('recurring_time')->nullable();
            $table->timestamp('afterward')->nullable();
            $table->timestamp('formerly')->nullable();
            $table->boolean('status')->default(1)->comment('1 => Running, 0=> completed');
            $table->boolean('capital_back')->default(0)->comment('	1 = YES & 0 = NO');
            $table->string('trx',60)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
