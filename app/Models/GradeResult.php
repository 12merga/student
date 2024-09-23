<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'test1',
        'assignment',
        'test2',
        'final',
        'total',
    ];

    // Define relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class);
    }
}
