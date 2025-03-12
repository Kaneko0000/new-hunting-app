<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Hunter extends Authenticatable
{
    use HasFactory, Notifiable; // 🔥 Notifiable はメール通知機能用（必要なら追加）

    protected $table = 'hunters'; // 明示的にテーブル名を指定
    protected $fillable = ['name', 'email', 'phone', 'region', 'password', 'license_image', 'license_expiry'];

    protected $hidden = ['password']; // 🔥 これを修正

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
