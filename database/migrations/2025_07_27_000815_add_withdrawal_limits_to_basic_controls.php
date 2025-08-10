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
            $table->boolean('withdrawal_limit_enabled')->default(false)->after('money_transfer_limit_days');
            $table->string('withdrawal_limit_type')->default('daily')->after('withdrawal_limit_enabled')->comment('daily, weekly, custom_days');
            $table->integer('withdrawal_limit_count')->default(1)->after('withdrawal_limit_type')->comment('Number of withdrawals allowed');
            $table->integer('withdrawal_limit_days')->default(1)->after('withdrawal_limit_count')->comment('Number of days for custom_days type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_controls', function (Blueprint $table) {
            $table->dropColumn([
                'withdrawal_limit_enabled',
                'withdrawal_limit_type',
                'withdrawal_limit_count',
                'withdrawal_limit_days'
            ]);
        });
    }
};
