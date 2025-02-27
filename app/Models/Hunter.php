<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Hunter extends Model
{
    use HasFactory;

    protected $table = 'hunters'; // 明示的にテーブル名を指定
    protected $fillable = ['name', 'email', 'phone', 'region', 'password', 'license_image', 'license_expiry'];
    protected $hidden = ['password']; // パスワードを隠す

    protected $casts = [
        'password' => 'hashed', // Laravel 10 以降のパスワードハッシュ化
    ];

    public function licenses()
    {
        return $this->belongsToMany(License::class, 'hunter_license')
                    ->withPivot('license_image', 'license_expiry')
                    ->withTimestamps();
    }
}
