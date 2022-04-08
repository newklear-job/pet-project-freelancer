<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::apiResource('categories', \Freelance\Task\Application\Http\Controllers\CategoryController::class);
    });
});
