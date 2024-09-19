<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'middle_name',
        'date_of_birth',
        'age',
        'email',
        'class'
    ];
    protected $hidden = [
        'password',
    ];
}
