<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuleLecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'lecturer_id',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }
}
