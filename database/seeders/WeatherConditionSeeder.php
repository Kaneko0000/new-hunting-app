<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WeatherCondition;

class WeatherConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $weather = [
                ['name' => '晴れ', 'icon' => 'sun.png'],
                ['name' => '曇り', 'icon' => 'cloud.png'],
                ['name' => '雨', 'icon' => 'rain.png'],
                ['name' => '雪', 'icon' => 'snow.png'],
                ['name' => '曇りのち雨', 'icon' => 'cloud_rain.png'],
                ['name' => '雨のち晴れ', 'icon' => 'rain_sun.png'],
                ['name' => '雪のち晴れ', 'icon' => 'snow_sun.png'],
            ];
    
            foreach ($weather as $w) {
                WeatherCondition::create($w);
            }
        }
    }
}
