<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Day::create([
            'name_ar' => 'السبت',
            'name_en' => 'Saturday'
        ]);
        
        Day::create([
            'name_ar' => 'الأحد',
            'name_en' => 'Sunday'
        ]);
        
        Day::create([
            'name_ar' => 'الاثنين',
            'name_en' => 'Monday'
        ]);
        
        Day::create([
            'name_ar' => 'الثلاثاء',
            'name_en' => 'Tuesday'
        ]);
        
        Day::create([
            'name_ar' => 'الأربعاء',
            'name_en' => 'Wednesday'
        ]);
        
        Day::create([
            'name_ar' => 'الخميس',
            'name_en' => 'Thursday'
        ]);
        
        Day::create([
            'name_ar' => 'الجمعة',
            'name_en' => 'Friday'
        ]);
    }
}
