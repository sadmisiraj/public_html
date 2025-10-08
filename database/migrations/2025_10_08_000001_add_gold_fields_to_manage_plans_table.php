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
        Schema::table('manage_plans', function (Blueprint $table) {
            $table->boolean('return_as_gold')->default(0)->after('eligible_for_rgp');
            $table->unsignedBigInteger('gold_coin_id')->nullable()->after('return_as_gold');
            $table->decimal('gold_weight_in_grams', 18, 8)->nullable()->after('gold_coin_id');

            $table->foreign('gold_coin_id')->references('id')->on('gold_coins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manage_plans', function (Blueprint $table) {
            if (Schema::hasColumn('manage_plans', 'gold_coin_id')) {
                $table->dropForeign(['gold_coin_id']);
            }
            $table->dropColumn(['return_as_gold', 'gold_coin_id', 'gold_weight_in_grams']);
        });
    }
};


