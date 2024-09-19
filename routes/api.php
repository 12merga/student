<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;



Route::middleware('admin')->group(function () {
    Route::post('exam-schedule', [ExamController::class, 'store']);
    Route::put('exam-schedule/{id}', [ExamController::class, 'update']);
    Route::delete('exam-schedule/{id}', [ExamController::class, 'destroy']);
});

