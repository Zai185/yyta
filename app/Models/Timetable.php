<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'module_id',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    // --- Relationships ---

    public function slots()
    {
        return $this->hasMany(TimetableSlot::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // --- Schedule generation logic ---

    public function generateSchedules()
    {
        foreach ($this->slots as $slot) {
            $date = Carbon::parse($this->start_date)->next($slot->day_of_week);

            while ($date->lte($this->end_date)) {
                Schedule::create([
                    'timetable_slot_id' => $slot->id,
                    'module_id' => $slot->module_id,
                    'start_at' => Carbon::parse($date->format('Y-m-d') . ' ' . $slot->start_time),
                    'end_at' => Carbon::parse($date->format('Y-m-d') . ' ' . $slot->end_time),
                ]);

                $date->addWeek();
            }
        }
    }

    // Optional auto-trigger when saved (you can remove if you want to call manually)
    protected static function booted()
    {
        static::saved(function (Timetable $timetable) {
            // Optional: prevent duplicate schedules on update
            if ($timetable->wasRecentlyCreated) {
                $timetable->generateSchedules();
            }
        });
    }
}
