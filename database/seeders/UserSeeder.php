<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Delivery;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'phonenumber' => '51113535',
            'password' => '123456789',
            'user_type'=>'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        for($i=0; $i<15 ; $i++){
            User::factory()->create([
                'name' => 'Rahma Mohammed',
                'email' => 'rahma'.$i.'@gmail.com',
                'phonenumber' => '554971316',
                'password' => '123456789',
                'user_type'=>'customer',
                'address'=>'سمير رؤوف، مدينة نصر',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for($i=15; $i<30 ; $i++){
            $user= User::create([
                'name' => 'Rahma Mohammed',
                'email' => 'rahma'.$i.'@gmail.com',
                'phonenumber' => '554971316',
                'password' => '123456789',
                'user_type'=>'delivery',
                'address'=>'سمير رؤوف، مدينة نصر',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            Delivery::create([
                'user_id'=>$user->id,
                'vehicle_type'=>'سكوتر',
                'brand'=>'نيسان 2022',
                'license'=>'ن ا ب 6479',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    }
}
