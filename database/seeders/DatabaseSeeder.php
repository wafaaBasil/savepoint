<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       $this->call(PaymentMethodSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProviderSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProviderCategorySeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(OrderProductSeeder::class);
       //$this->call(ProductSeeder::class);
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
    }
}
