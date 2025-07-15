<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'start_at',
        'end_at',
        'batch_id',
        'module_id'
    ];

    // Relationships

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }

    protected static function booted()
    {
        static::created(function ($exam) {
            $students = $exam->batch->students ?? [];
            foreach ($students as $student) {
                ExamResult::firstOrCreate([
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,
                ], [
                    'score' => 0,
                ]);
            }
        });
    }
}
