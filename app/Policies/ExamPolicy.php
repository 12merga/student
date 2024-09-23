<?php

namespace App\Policies;

use App\Models\ExamSchedule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExamPolicy
{
    /**
     * Determine if the given exam schedule can be deleted by the user.
     */
    public function delete(User $user, ExamSchedule $exam)
    {
        return $user->role_id === 1;
    }
}
