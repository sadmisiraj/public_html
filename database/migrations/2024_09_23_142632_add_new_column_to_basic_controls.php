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
            $table->string('cookie_title',50)->nullable()->after('min_transfer');
            $table->string('cookie_button_name',20)->nullable()->after('min_transfer');
            $table->string('cookie_button_url')->nullable()->after('min_transfer');
            $table->string('cookie_short_text',120)->nullable()->after('min_transfer');
            $table->string('cookie_image',100)->nullable()->after('min_transfer');
            $table->string('cookie_driver',20)->nullable()->after('min_transfer');
            $table->boolean('cookie_status')->default(false)->after('min_transfer');
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
