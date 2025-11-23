<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gold_coin_orders', function (Blueprint $table) {
            $table->integer('coins_count')->default(1)->after('weight_in_grams')->comment('Number of 1g coins equivalent to weight');
        });
    }

    public function down(): void
    {
        Schema::table('gold_coin_orders', function (Blueprint $table) {
            $table->dropColumn('coins_count');
        });
    }
};



