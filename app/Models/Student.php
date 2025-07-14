<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'status',
        'phone_number',
        'batch_id'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function examResults()
{
    return $this->hasMany(ExamResult::class);
}

}
