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
            $table->boolean('allow_multiple_purchase')->default(0)->after('featured')->comment('0 for not allowed, 1 for allowed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manage_plans', function (Blueprint $table) {
            $table->dropColumn('allow_multiple_purchase');
        });
    }
};
