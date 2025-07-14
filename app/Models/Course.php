<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'fee',
        'is_online',
        'description',
        'img_url'
    ];

    public function getImgUrlAttribute($value)
    {
        return $value ? Storage::disk('public')->url($value) : null;
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
