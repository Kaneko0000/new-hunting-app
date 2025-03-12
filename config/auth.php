<?php

return [


    'defaults' => [
        'guard' => 'hunter',
        // 'passwords' => 'hunters',
        'passwords' => 'users',
        // 'guard' => 'web',
        // 'passwords' => 'users',
    ],


    'guards' => [
        'hunter' => [
            'driver' => 'session',
            'provider' => 'hunters',
        ],
        'admin' => [  // 🔥 管理者用のガードを追加
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],



    'providers' => [
        'hunters' => [
            'driver' => 'eloquent',
            'model' => App\Models\Hunter::class,
        ],

        'users' => [ // 🔥 管理者を `users` テーブルで認証
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    'password_timeout' => 10800,

];
