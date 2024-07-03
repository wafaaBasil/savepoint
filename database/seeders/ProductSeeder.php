<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        for($i=0; $i<10 ; $i++){
            Product::create([
                'name'=>'منتج '.$i,
                'price' => '100',
                'provider_id'=>$i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
