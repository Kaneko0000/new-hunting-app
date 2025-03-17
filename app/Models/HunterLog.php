<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HunterLog extends Model
{
    use HasFactory;

    protected $fillable = ['hunter_id', 'animal_id', 'weather_id', 'latitude', 'longitude', 'capture_date', 'comments'];

    public function hunter()
    {
        return $this->belongsTo(Hunter::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function weather()
    {
        return $this->belongsTo(WeatherCondition::class);
    }
}
