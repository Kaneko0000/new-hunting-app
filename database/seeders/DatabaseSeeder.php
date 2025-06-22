<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            LicenseSeeder::class,
            AnimalSeeder::class,
            WeatherConditionSeeder::class,
            HuntingMethodSeeder::class,
            ArticleSeeder::class,
            HunterSeeder::class,
            HunterLogSeeder::class,

        ]);
    }
}
