<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<16;$i++){
            DB::table('providers_categories')->insert([
                [
                    'provider_id' => $i,
                    'category_id' => 1
                ], 
                [
                    'provider_id' => $i,
                    'category_id' => 2
                ]

            ]);
        }
    }
}
