<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimetableSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'timetable_id',
        'module_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
