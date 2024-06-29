<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<5 ; $i++){
        Rating::create([
            'comment' => 'مندوب مميز',
            'stars' => 5,
            'from_user_id' => 2,
            'to_user_id' => 17,
            'order_id' => $i,
        ]);
        
        Rating::create([
            'comment' => 'عميل محترم',
            'stars' => 5,
            'from_user_id' => 17,
            'to_user_id' => 2,
            'order_id' => $i,
        ]);
    }
    for($i=1; $i<5 ; $i++){
        Rating::create([
            'comment' => 'تطبيق مميز',
            'stars' => 5,
            'from_user_id' => 2,
        ]);
    }
    }
}
