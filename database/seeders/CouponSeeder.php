<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Coupon::create([
            'name' => 'عرض العيد',
            'type' => 'percent',
            'discount' => 15,
            'top_discount' => 400,
            'provider_id' => 1,
            'end_date' => '2024-07-15',
            'num_of_use' => 5,
        ]);
        
        Coupon::create([
            'name' => 'عرض رقم 2',
            'type' => 'percent',
            'discount' => 13,
            'top_discount' => 300,
            'provider_id' => 1,
            'end_date' => '2024-07-20',
            'num_of_use' => 20,
        ]);
        
        Coupon::create([
            'name' => 'عرض رقم 3',
            'type' => 'fixed',
            'discount' => 600,
            'provider_id' => 1,
            'end_date' => '2024-08-15',
            'num_of_use' => 15,
        ]);
        
        Coupon::create([
            'name' => 'عرض رقم 4',
            'type' => 'fixed',
            'discount' => 400,
            'provider_id' => 1,
            'end_date' => '2024-09-10',
            'num_of_use' => 30,
        ]);
        
        Coupon::create([
            'name' => 'عرض رقم 5',
            'type' => 'fixed',
            'discount' => 250,
            'provider_id' => 1,
            'end_date' => '2024-08-20',
            'num_of_use' => 10,
        ]);
    }
}
