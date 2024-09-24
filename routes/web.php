<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassPeriodController;
use App\Http\Controllers\GradeResultController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login'); // Show login form
Route::post('login', [AuthController::class, 'login']); // Handle login form submission

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard'); // Admin dashboard
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Admin logout
});

Route::post('teacher/login', [TeacherController::class, 'login']);
Route::post('student/login', [StudentController::class, 'login']);
Route::post('parents/login', [ParentController::class, 'login']);
Route::post('parents/register', [ParentController::class, 'register']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Route::middleware(['auth:admin'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('exam-schedules', ExamController::class);
    Route::resource('class-periods', ClassPeriodController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('students', [StudentController::class, 'index'])->name('students.index');
    Route::post('students', [StudentController::class, 'store'])->name('students.store');
    Route::get('students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::put('students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('student/grades', [StudentController::class, 'viewGrades']);
    Route::get('student/performances', [StudentController::class, 'viewPerformances']);
});

Route::get('parents/register', [ParentController::class, 'showRegistrationForm'])->name('parents.register'); // Parent registration form
Route::post('parents/register', [ParentController::class, 'store'])->name('parents.store'); // Register parent
Route::post('parents/login', [ParentController::class, 'login'])->name('parents.login'); // Parent login

// Protected routes for authenticated parents
Route::middleware(['auth:parent'])->group(function () {
    Route::get('parent/dashboard', [ParentController::class, 'dashboard'])->name('parents.dashboard');
    Route::get('parents/grades/{student_id}', [ParentController::class, 'viewResults'])->name('parents.viewGrades');
    Route::get('parents/performance/{student_id}', [ParentController::class, 'viewPerformance'])->name('parents.viewPerformance');
    Route::get('parents/payment-status/{student_id}', [ParentController::class, 'paymentStatus'])->name('parents.paymentStatus');
    Route::post('parents/logout', [ParentController::class, 'logout'])->name('parents.logout');
    Route::put('parents/update', [ParentController::class, 'update'])->name('parents.update');
});

Route::get('students/create', [StudentController::class, 'create'])->name('students.create'); // Show student registration form
Route::post('students', [StudentController::class, 'store'])->name('students.store'); // Store new student
Route::post('students/login', [StudentController::class, 'login'])->name('students.login'); // Student login

// Protected Routes for Students
Route::middleware(['auth:student'])->group(function () {
    Route::get('students/dashboard', [StudentController::class, 'dashboard'])->name('students.dashboard'); // Student dashboard
    Route::get('students/grades', [StudentController::class, 'viewGrades'])->name('students.viewGrades'); // View grades
    Route::get('students/performances', [StudentController::class, 'viewPerformances'])->name('students.viewPerformances'); // View performances
    Route::get('student/exam-schedules', [ExamController::class, 'index']);
    Route::get('student/class-periods', [ClassPeriodController::class, 'index']);
});

// Admin Routes for Managing Students
Route::middleware(['auth:admin'])->group(function () {
    Route::get('parents', [ParentController::class, 'index'])->name('parents.index'); // List all parents (Admin view)
    Route::post('parents/approve/{id}', [ParentController::class, 'approve'])->name('parents.approve'); // Approve parent registration    
    Route::get('students', [StudentController::class, 'index'])->name('students.index'); // List all students
    Route::get('students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit'); // Edit student form
    Route::put('students/{id}', [StudentController::class, 'update'])->name('students.update'); // Update student
    Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('students.destroy'); // Delete student
    Route::get('teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
});

Route::get('teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
Route::post('teachers', [TeacherController::class, 'store'])->name('teachers.store');
Route::post('teachers/login', [TeacherController::class, 'login'])->name('teachers.login');

Route::middleware(['auth:teacher'])->group(function () {
    Route::get('teachers/dashboard', [TeacherController::class, 'dashboard'])->name('teachers.dashboard');
    Route::post('teachers/students/{studentId}/assign-grade', [TeacherController::class, 'assignGrade'])->name('teachers.assign-grade');
    Route::post('teachers/students/{studentId}/record-performance', [TeacherController::class, 'recordPerformance'])->name('teachers.record-performance');
});




require __DIR__ . '/auth.php';
