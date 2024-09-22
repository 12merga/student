<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'title',
        'phone_number',
        'email',
        'subject',
        'password',
        'teachersId',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
