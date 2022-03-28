<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [\Freelance\User\Application\Http\Controllers\UserController::class, 'index']);
});
