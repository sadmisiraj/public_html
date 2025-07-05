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
        // First, ensure the RGP transaction table fields are all proper decimal types
        Schema::table('rgp_transactions', function (Blueprint $table) {
            $table->decimal('amount', 18, 2)->change();
            $table->decimal('previous_rgp_l', 18, 2)->nullable()->change();
            $table->decimal('previous_rgp_r', 18, 2)->nullable()->change();
            $table->decimal('new_rgp_l', 18, 2)->nullable()->change();
            $table->decimal('new_rgp_r', 18, 2)->nullable()->change();
        });

        // Then, update the users table to use decimal for RGP fields instead of varchar
        Schema::table('users', function (Blueprint $table) {
            // First, create new decimal columns
            $table->decimal('rgp_l_decimal', 18, 2)->nullable()->after('rgp_l');
            $table->decimal('rgp_r_decimal', 18, 2)->nullable()->after('rgp_r');
            $table->decimal('rgp_pair_matching_decimal', 18, 2)->nullable()->after('rgp_pair_matching');
        });

        // Migrate data from varchar to decimal columns
        DB::statement('UPDATE users SET 
            rgp_l_decimal = CAST(NULLIF(rgp_l, "") AS DECIMAL(18,2)),
            rgp_r_decimal = CAST(NULLIF(rgp_r, "") AS DECIMAL(18,2)),
            rgp_pair_matching_decimal = CAST(NULLIF(rgp_pair_matching, "") AS DECIMAL(18,2))
        ');

        // Drop old varchar columns and rename new decimal columns
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rgp_l', 'rgp_r', 'rgp_pair_matching']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('rgp_l_decimal', 'rgp_l');
            $table->renameColumn('rgp_r_decimal', 'rgp_r');
            $table->renameColumn('rgp_pair_matching_decimal', 'rgp_pair_matching');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert users table changes
        Schema::table('users', function (Blueprint $table) {
            // First create varchar columns
            $table->string('rgp_l_varchar', 50)->nullable()->after('rgp_l');
            $table->string('rgp_r_varchar', 50)->nullable()->after('rgp_r');
            $table->string('rgp_pair_matching_varchar', 50)->nullable()->after('rgp_pair_matching');
        });

        // Migrate data back to varchar columns
        DB::statement('UPDATE users SET 
            rgp_l_varchar = rgp_l,
            rgp_r_varchar = rgp_r,
            rgp_pair_matching_varchar = rgp_pair_matching
        ');

        // Drop decimal columns and rename varchar columns back
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rgp_l', 'rgp_r', 'rgp_pair_matching']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('rgp_l_varchar', 'rgp_l');
            $table->renameColumn('rgp_r_varchar', 'rgp_r');
            $table->renameColumn('rgp_pair_matching_varchar', 'rgp_pair_matching');
        });

        // Revert rgp_transactions table changes
        Schema::table('rgp_transactions', function (Blueprint $table) {
            $table->decimal('amount', 8, 2)->change();
            $table->decimal('previous_rgp_l', 8, 2)->nullable()->change();
            $table->decimal('previous_rgp_r', 8, 2)->nullable()->change();
            $table->decimal('new_rgp_l', 8, 2)->nullable()->change();
            $table->decimal('new_rgp_r', 8, 2)->nullable()->change();
        });
    }
};
