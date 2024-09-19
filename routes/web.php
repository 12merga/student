<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassPeriodController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//parent registration
Route::post('parents/register', [ParentController::class, 'register']); // Self-registration

// Route for displaying the login form
Route::get('admin/login', function () {
    return view('auth.login'); // Adjust the path if necessary
})->name('admin.login');

// Route for login
Route::post('login', [AuthController::class, 'login']); // Login route

Route::middleware(['auth:sanctum', 'is_admin'])->post('parents/approve/{parent_id}', [ParentController::class, 'approve']);

// Protected routes
Route::middleware(['is_admin'])->group(function () {
    Route::post('students/register', [StudentController::class, 'store']);

    Route::post('teachers/register', [TeacherController::class, 'store']);

    Route::post('approve-parents', [ParentController::class, 'approve']); // Example route for approving parents

    Route::post('exam-schedule', [ExamController::class, 'store']);
    Route::get('exam-schedule/{id}', [ExamController::class, 'show']);
    Route::put('exam-schedule/{id}', [ExamController::class, 'update']);
    Route::delete('exam-schedule/{id}', [ExamController::class, 'destroy']);

    Route::post('class-period', [ClassPeriodController::class, 'store']);
});

// Routes for viewing exam schedules (available to both students and teachers)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('exam-schedules', [ExamController::class, 'index']); // List all exam schedules
    Route::get('exam-schedule/{id}', [ExamController::class, 'show']); // View specific exam schedule
});


require __DIR__ . '/auth.php';
