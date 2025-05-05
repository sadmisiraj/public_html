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
            $table->unsignedBigInteger('base_plan_id')->nullable()->after('featured');
            $table->foreign('base_plan_id')->references('id')->on('manage_plans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manage_plans', function (Blueprint $table) {
            $table->dropForeign(['base_plan_id']);
            $table->dropColumn('base_plan_id');
        });
    }
};
