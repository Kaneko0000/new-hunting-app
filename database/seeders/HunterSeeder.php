<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hunter;
use Illuminate\Support\Facades\Hash;

class HunterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // 特定ユーザー
        Hunter::create([
            'name' => '指定ハンター',
            'email' => 'kmxrc177@yahoo.co.jp',
            'phone' => '09012345678',
            'region' => '熊本県',
            'password' => Hash::make('11111111'),
            'status' => 'approved',
            'role' => 'hunter',
            'terms_accepted' => 1,
            'privacy_accepted' => 1,
        ]);
        for ($i = 1; $i <= 10; $i++) {
            Hunter::create([
                'name' => "ハンター{$i}",
                'email' => "hunter{$i}@example.com",
                'phone' => '080000000' . $i,
                'region' => '熊本県',
                'password' => Hash::make('password'),
                'status' => 'approved',
                'role' => 'hunter',
                'terms_accepted' => 1,
                'privacy_accepted' => 1,
            ]);
        }
    }
}
