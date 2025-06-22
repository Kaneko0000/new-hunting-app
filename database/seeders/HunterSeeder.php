<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hunter;
use App\Models\License;
use Illuminate\Support\Facades\Hash;

class HunterSeeder extends Seeder
{

    public function run(): void
    {
        $licenses = License::all();
        \Log::info('🔥 シーダー内 License 件数: ' . $licenses->count());
        if ($licenses->isEmpty()) {
            \Log::error('❌ LicenseSeederが正しく動作していない可能性があります');
        }

        // 特定ユーザー
        $targetHunter = Hunter::create([
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

        $targetHunter->licenses()->attach($licenses->pluck('id')->toArray());

        for ($i = 1; $i <= 10; $i++) {
            $hunter = Hunter::create([
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
            // ランダムにライセンス1つ紐づけ
            $randomLicenseId = $licenses->random()->id;
            $hunter->licenses()->attach($randomLicenseId);
        }
    }
}
