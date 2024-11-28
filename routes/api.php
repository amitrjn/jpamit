<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('courses', CourseController::class);
});
