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
        Schema::table('gold_coins', function (Blueprint $table) {
            $table->integer('delivery_days')->nullable()->after('description')->comment('Estimated delivery time in days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_coins', function (Blueprint $table) {
            $table->dropColumn('delivery_days');
        });
    }
};


