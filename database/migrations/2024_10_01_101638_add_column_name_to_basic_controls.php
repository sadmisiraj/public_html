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
        Schema::table('basic_controls', function (Blueprint $table) {
            $table->string('app_color')->after('cookie_title')->nullable();
            $table->string('app_version')->after('app_color')->nullable();
            $table->string('app_build')->after('app_version')->nullable();
            $table->boolean('is_major')->after('app_build')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_controls', function (Blueprint $table) {
            //
        });
    }
};
