<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/user', [\Freelance\User\Application\Http\Controllers\UserController::class, 'index']);
});
