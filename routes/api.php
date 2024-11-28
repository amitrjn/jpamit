<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;

// Course routes
Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'store']);
    Route::get('/{course}', [CourseController::class, 'show']);
    Route::put('/{course}', [CourseController::class, 'update']);
    Route::delete('/{course}', [CourseController::class, 'destroy']);
    
    // Additional endpoints
    Route::patch('/{course}/toggle-status', [CourseController::class, 'toggleStatus']);
    Route::post('/bulk-delete', [CourseController::class, 'bulkDelete']);
});
