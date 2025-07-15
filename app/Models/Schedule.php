<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'timetable_slot_id',
        'module_id',
        'start_at',
        'end_at',
    ];

    public function slot()
    {
        return $this->belongsTo(TimetableSlot::class, 'timetable_slot_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class); // Make sure you have a Module model
    }

    protected static function booted()
    {
        try {

            static::created(function (Schedule $schedule) {
                $students = $schedule->module
                    ->course
                    ->transactions
                    ->map(fn($t) => $t->student)
                    ->filter()
                    ->unique('id') ?? collect();

                foreach ($students as $student) {
                    Attendance::firstOrCreate([
                        'schedule_id' => $schedule->id,
                        'student_id' => $student->id,
                    ], [
                        'is_present' => false,
                    ]);
                }
            });
        } catch (Exception $e) {
            logger($e->getMessage());
        }
    }
}
