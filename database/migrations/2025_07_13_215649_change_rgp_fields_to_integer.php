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
        Schema::table('users', function (Blueprint $table) {
            // Change RGP fields from decimal to integer
            $table->integer('rgp_l')->change();
            $table->integer('rgp_r')->change();
            $table->integer('rgp_pair_matching')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Change back to decimal if needed
            $table->decimal('rgp_l', 18, 2)->change();
            $table->decimal('rgp_r', 18, 2)->change();
            $table->decimal('rgp_pair_matching', 18, 2)->change();
        });
    }
};
