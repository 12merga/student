<?php

namespace App\Providers;

use App\Models\Teacher;
use App\Policies\TeacherPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Teacher::class => TeacherPolicy::class,
    ];
}
