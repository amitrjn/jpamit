<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\LessonController;

// Course routes
Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'store']);
    Route::get('/{course}', [CourseController::class, 'show']);
    Route::put('/{course}', [CourseController::class, 'update']);
    Route::delete('/{course}', [CourseController::class, 'destroy']);
    Route::patch('/{course}/toggle-status', [CourseController::class, 'toggleStatus']);
    Route::post('/bulk-delete', [CourseController::class, 'bulkDelete']);
});

// Training routes
Route::prefix('trainings')->group(function () {
    Route::get('/', [TrainingController::class, 'index']);
    Route::post('/', [TrainingController::class, 'store']);
    Route::get('/{training}', [TrainingController::class, 'show']);
    Route::put('/{training}', [TrainingController::class, 'update']);
    Route::delete('/{training}', [TrainingController::class, 'destroy']);
});

// Lesson routes
Route::prefix('lessons')->group(function () {
    Route::get('/', [LessonController::class, 'index']);
    Route::post('/', [LessonController::class, 'store']);
    Route::get('/{lesson}', [LessonController::class, 'show']);
    Route::put('/{lesson}', [LessonController::class, 'update']);
    Route::delete('/{lesson}', [LessonController::class, 'destroy']);
    Route::post('/reorder', [LessonController::class, 'reorder']);
});

