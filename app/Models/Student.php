<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
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
        'remember_token',
    ];

    public function results()
    {
        return $this->hasMany(GradeResult::class); // Adjust based on your models
    }

    public function performances()
    {
        return $this->hasMany(StudentPerformance::class); // Adjust based on your models
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class); // Adjust based on your models
    }
}
