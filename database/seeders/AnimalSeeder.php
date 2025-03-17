<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Animal;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animals = [
            ['name' => 'イノシシ', 'icon' => 'boar.webp'],
            ['name' => 'シカ', 'icon' => 'deer.webp'],
            ['name' => 'クマ', 'icon' => 'bear.webp'],
            ['name' => 'キツネ', 'icon' => 'fox.webp'],
            ['name' => 'タヌキ', 'icon' => 'raccoon.webp'],
            ['name' => 'その他', 'icon' => 'other.webp'],
        ];

        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
