<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\License;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            License::insert([
                ['name' => 'わな猟'],
                ['name' => '網猟'],
                ['name' => '第一種'],
                ['name' => '第二種'],
            ]);
        }
    }
}
