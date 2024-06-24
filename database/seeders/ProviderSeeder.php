<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        for($i=30; $i<45 ; $i++){
            $user= User::create([
                'name' => 'admin',
                'email' => 'res'.$i.'@gmail.com',
                'phonenumber' => '5549713'.$i,
                'password' => '123456789',
                'user_type'=>'provider_admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $provider =Provider::create([
                'name'=>'البيك',
                'phonenumber' => '5549713'.$i,
                'address'=>'سمير رؤوف، مدينة نصر',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->provider_id =$provider->id;
            $user->save();
        }
    }
}
