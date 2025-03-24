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
            AdminUserSeeder::class, // ✅ 管理者
            AnimalSeeder::class,    // ✅ 動物データ
            WeatherConditionSeeder::class, // ✅ 天気データ
            ArticleSeeder::class,  //✅ 管理者記事投稿
        ]);
    }
}
