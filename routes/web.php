<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassPeriodController;
use App\Http\Controllers\GradeResultController;
use App\Http\Controllers\StudentPerformanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::post('login', [AuthController::class, 'login']);
Route::post('teacher/login', [TeacherController::class, 'login']);
Route::post('student/login', [StudentController::class, 'login']);

// Route::middleware('admin')->group(function () {
Route::middleware('auth:admin')->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('exam-schedules', ExamController::class);
    Route::resource('class-periods', ClassPeriodController::class);
    Route::resource('events', EventController::class);
    Route::post('parents/approve/{id}', [ParentController::class, 'approve']);
});

Route::post('parents/login', [ParentController::class, 'login']); // Parent login
Route::post('/parents/register', [ParentController::class, 'register']);

Route::middleware(['auth:student'])->group(function () {
    Route::get('student/dashboard', [StudentController::class, 'dashboard']);
    Route::get('student/grades', [StudentController::class, 'viewGrades']);
    Route::get('student/performances', [StudentController::class, 'viewPerformances']);
    Route::get('student/exam-schedules', [ExamController::class, 'index']);
    Route::get('student/class-periods', [ClassPeriodController::class, 'index']);

});


Route::middleware('auth:parent')->group(function () {
    Route::get('student/dashboard', [ParentController::class, 'dashboard']);
    Route::get('parents/grades/{student_id}', [ParentController::class, 'viewGrades']);
    Route::get('parents/performance/{student_id}', [ParentController::class, 'viewPerformance']);
});

// Route::middleware('auth:teacher')->group(function () {
Route::group(['middleware' => ['auth:teacher']], function () {
    Route::get('teacher/dashboard', [TeacherController::class, 'dashboard']);
    Route::post('teachers/grades', [TeacherController::class, 'addGrades']);
    Route::get('teachers/performance/{student_id}', [TeacherController::class, 'viewPerformance']);
});



require __DIR__ . '/auth.php';
