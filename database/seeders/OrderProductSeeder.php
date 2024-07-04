<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
             OrderProduct::create([
                'product_id' => 1,
                'order_id' => 1,
                'amount' => 2,
                'price' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            OrderProduct::create([
                'product_id' => 1,
                'order_id' => 1,
                'amount' => 4,
                'price' => 6000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            OrderProduct::create([
                'product_id' => 1,
                'order_id' => 1,
                'amount' => 1,
                'price' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
    }
}
