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
        Schema::create('purchase_charges', function (Blueprint $table) {
            $table->id();
            $table->string('label')->comment('Display name of the charge');
            $table->enum('type', ['percentage', 'fixed'])->default('percentage')->comment('Type of charge calculation');
            $table->decimal('value', 8, 4)->comment('Charge value (percentage or fixed amount)');
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->integer('sort_order')->default(0)->comment('Order of display');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_charges');
    }
};
