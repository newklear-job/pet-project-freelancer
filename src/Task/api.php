<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', \Freelance\Task\Application\Http\Controllers\CategoryController::class);
});
