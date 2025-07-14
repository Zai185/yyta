<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BatchLecturer extends Model
{
    use HasFactory;

    // If your table name is not plural 'batch_lecturers', uncomment and set it
    // protected $table = 'batch_lecturers';

    public $timestamps = false; // Since your table likely does not have created_at / updated_at

    protected $fillable = [
        'batch_id',
        'lecturer_id',
        'module_id',
    ];

    // Relationships

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
