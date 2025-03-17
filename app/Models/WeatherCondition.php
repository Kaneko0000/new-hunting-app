<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherCondition extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    public function huntingLogs()
    {
        return $this->hasMany(HuntingLog::class);
    }
}
