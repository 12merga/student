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
        'student_middle_name',
        'student_last_name',
        'student_id',
        'phone_number',
        'email',
        'password',
        'approved',
    ];

    // Hide the password and sensitive fields
    protected $hidden = [
        'password',
    ];
}
