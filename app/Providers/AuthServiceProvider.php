<?php

namespace App\Providers;

use App\Models\Teacher;
use App\Models\ExamSchedule;
use App\Policies\ExamPolicy;
use App\Policies\TeacherPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Teacher::class => TeacherPolicy::class,
        ExamSchedule::class => ExamPolicy::class,

    ];
}
