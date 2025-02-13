<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function hunters()
    {
        return $this->belongsToMany(Hunter::class, 'hunter_license')
                    ->withPivot('license_image', 'license_expiry')
                    ->withTimestamps();
    }
}
