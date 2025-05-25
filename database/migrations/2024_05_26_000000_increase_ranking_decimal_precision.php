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
        Schema::table('rankings', function (Blueprint $table) {
            $table->decimal('min_invest', 13, 2)->change();
            $table->decimal('min_deposit', 13, 2)->change();
            $table->decimal('min_earning', 13, 2)->change();
            $table->decimal('min_team_invest', 13, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->decimal('min_invest', 8, 2)->change();
            $table->decimal('min_deposit', 8, 2)->change();
            $table->decimal('min_earning', 8, 2)->change();
            $table->decimal('min_team_invest', 11, 2)->change();
        });
    }
}; 