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
            $table->string('dashboard_popup_image', 255)->nullable();
            $table->string('dashboard_popup_image_driver', 20)->nullable();
            $table->boolean('show_dashboard_popup')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_controls', function (Blueprint $table) {
            $table->dropColumn('dashboard_popup_image');
            $table->dropColumn('dashboard_popup_image_driver');
            $table->dropColumn('show_dashboard_popup');
        });
    }
}; 