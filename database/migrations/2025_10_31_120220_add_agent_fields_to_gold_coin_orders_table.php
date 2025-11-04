<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gold_coin_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_user_id')->nullable()->after('payment_source');
            $table->timestamp('agent_delivered_at')->nullable()->after('status');

            $table->foreign('agent_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('gold_coin_orders', function (Blueprint $table) {
            $table->dropForeign(['agent_user_id']);
            $table->dropColumn(['agent_user_id', 'agent_delivered_at']);
        });
    }
};


