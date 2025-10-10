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
        Schema::table('referrals', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable()->after('commission_type');
            $table->index(['commission_type', 'plan_id']);
            $table->foreign('plan_id')->references('id')->on('manage_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            if (Schema::hasColumn('referrals', 'plan_id')) {
                $table->dropForeign(['plan_id']);
                $table->dropIndex(['commission_type', 'plan_id']);
                $table->dropColumn('plan_id');
            }
        });
    }
};


