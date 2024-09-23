<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassPeriodController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

// Route::middleware(['auth', 'admin'])->group(function () {
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // Student routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    Route::get('/class-periods', [ClassPeriodController::class, 'index'])->name('class_periods.index');
    Route::get('/class-periods/create', [ClassPeriodController::class, 'create'])->name('class_periods.create');
    Route::post('/class-periods', [ClassPeriodController::class, 'store'])->name('class_periods.store');
    Route::get('/class-periods/{id}/edit', [ClassPeriodController::class, 'edit'])->name('class_periods.edit');
    Route::put('/class-periods/{id}', [ClassPeriodController::class, 'update'])->name('class_periods.update');
    Route::delete('/class-periods/{id}', [ClassPeriodController::class, 'destroy'])->name('class_periods.destroy');

    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
    Route::get('/exams/{exam}/edit', [ExamController::class, 'edit'])->name('exams.edit');
    Route::put('/exams/{exam}', [ExamController::class, 'update'])->name('exams.update');
    Route::delete('/exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('parents', [ParentController::class, 'index'])->name('parents.index');
    Route::post('parents/approve/{id}', [ParentController::class, 'approve'])->name('parents.approve');
    Route::post('admin/approve-parent/{parentId}', [AdminController::class, 'approveParent'])->name('admin.approveParent');

});


Route::get('parents/register', [ParentController::class, 'create'])->name('parents.create');
Route::post('parents/register', [ParentController::class, 'store'])->name('parents.store');
Route::get('parent/login', [ParentController::class, 'showLoginForm'])->name('parent.login');
Route::post('parent/login', [ParentController::class, 'login'])->name('parent.login.submit');
Route::post('parent/logout', [ParentController::class, 'logout'])->name('parent.logout');

// Parent Dashboard Routes
Route::middleware(['auth:parent'])->group(function () {
    Route::get('parent/dashboard', [ParentController::class, 'index'])->name('parent.dashboard');
});

require __DIR__ . '/auth.php';

// Route::get('/students', [StudentController::class, 'index']);
//     Route::get('/students/create', [StudentController::class, 'create']);
//     Route::post('/students', [StudentController::class, 'store']);
