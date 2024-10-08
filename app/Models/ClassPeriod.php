<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'class',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday'
    ];
}
