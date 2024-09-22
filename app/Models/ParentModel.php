<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'student_first_name',
        'student_last_name',
        'student_middle_name',
        'student_id',
        'phone_number',
        'email',
        'password',
        'is_approved',
    ];

    protected $hidden = [
        'password',
    ];

    // Define relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
