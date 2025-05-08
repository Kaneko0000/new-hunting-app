<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HuntingMethod;


class HuntingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HuntingMethod::insert([
            ['name' => '箱罠', 'icon' => 'hunting_method1.png'],
            ['name' => 'くくり罠', 'icon' => 'hunting_method2.png'],
            ['name' => '巻狩り', 'icon' => 'hunting_method3.png'],
        ]);
    }
}
