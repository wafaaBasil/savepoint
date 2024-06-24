<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<5 ; $i++){
             Order::create([
                'customer_id' => 2,
                'provider_id' => 1,
                'delivery_id' => 15,
                'order_price' => 1300,
                'delivery_price' => 20,
                'total' => 1500,
                'status' => 'تم التوصيل',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            Order::create([
                'customer_id' => 2,
                'provider_id' => 1,
                'delivery_id' => 15,
                'order_price' => 1300,
                'delivery_price' => 20,
                'total' => 1500,
                'status' => 'جاري التجهيز',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Order::create([
                'customer_id' => 2,
                'provider_id' => 1,
                'delivery_id' => 15,
                'order_price' => 1300,
                'delivery_price' => 20,
                'total' => 1500,
                'status' => 'التوصيل',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
