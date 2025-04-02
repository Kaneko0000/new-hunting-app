<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HunterLog;
use App\Models\Hunter;
use App\Models\Animal;
use App\Models\WeatherCondition;
use Illuminate\Support\Str;

class HunterLogSeeder extends Seeder
{
    public function run(): void
    {
        $hunters = Hunter::all();
        $animals = Animal::all();
        $weathers = WeatherCondition::all();

        foreach ($hunters as $hunter) {
            for ($i = 0; $i < 1; $i++) { // 各ハンターに1件ずつログ追加
                HunterLog::create([
                    'hunter_id' => $hunter->id,
                    'animal_id' => $animals->random()->id,
                    'weather_id' => $weathers->random()->id,
                    'latitude' => 32.4 + mt_rand() / mt_getrandmax() * 0.2,
                    'longitude' => 130.0 + mt_rand() / mt_getrandmax() * 0.2,
                    'capture_date' => now()->subDays(rand(0, 30)),
                    'comments' => 'これはシードで作られたコメントです。',
                    'photo' => 'hunter_logs/' . Str::random(10) . '.jpg',
                ]);
            }
        }
    }
}
