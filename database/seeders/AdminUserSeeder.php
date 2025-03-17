<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => '管理者',
            'email' => 'vs.noo.moo@gmail.com', // ここは管理者のメールアドレスに変更
            'password' => Hash::make('naoki0609'), // パスワードを安全にハッシュ化
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
