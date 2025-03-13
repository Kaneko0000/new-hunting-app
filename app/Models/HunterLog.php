<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HunterLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'hunter_id',  // ハンターのID
        'date',       // 記録日
        'location',   // 場所
        'species',    // 捕獲した動物の種類
        'weight',     // 重量
        'notes',      // メモ
    ];

    // ハンターとのリレーション
    public function hunter()
    {
        return $this->belongsTo(Hunter::class);
    }
}
