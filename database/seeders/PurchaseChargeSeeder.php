<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PurchaseCharge;

class PurchaseChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add default GST charge (18%)
        PurchaseCharge::create([
            'label' => 'GST',
            'type' => 'percentage',
            'value' => 18.0000,
            'status' => 1,
            'sort_order' => 1
        ]);
        
        // You can add more default charges here
        // PurchaseCharge::create([
        //     'label' => 'Processing Fee',
        //     'type' => 'fixed',
        //     'value' => 50.0000,
        //     'status' => 1,
        //     'sort_order' => 2
        // ]);
    }
}
