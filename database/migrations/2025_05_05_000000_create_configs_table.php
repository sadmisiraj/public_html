<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->string('value', 10)->nullable();
            $table->timestamps();
        });

        // Insert default config values
        DB::table('configs')->insert([
            [
                'name' => 'config_1',
                'display_name' => 'Reino King',
                'value' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'config_2',
                'display_name' => 'Reino Queen',
                'value' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'config_3',
                'display_name' => 'Today Gold Rate',
                'value' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
} 