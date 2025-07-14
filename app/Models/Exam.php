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
}
