<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class',
        'subject',
        'date',
        'location',
        'examiner',
        'teacher_id',
    ];

    // Define the relationship with the Teacher model
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Define the relationship with the Student model
    public function students()
    {
        return $this->belongsToMany(Student::class, 'exam_schedule_student');
    }
}
