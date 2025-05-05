<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('basic_controls')
            ->where('admin_prefix', 'admin')
            ->orWhereNull('admin_prefix')
            ->update(['admin_prefix' => 'security']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('basic_controls')
            ->where('admin_prefix', 'security')
            ->update(['admin_prefix' => 'admin']);
    }
};
