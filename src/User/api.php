<?php

use Freelance\User\Application\Http\Controllers\Client\LoginController;
use Freelance\User\Application\Http\Controllers\Client\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'store'])
     ->middleware(['guest:' . config('fortify.guard')])
     ->name('register');

Route::post('/login', [LoginController::class, 'store'])
     ->middleware(['guest:' . config('fortify.guard')])
     ->name('login');

Route::post('/logout', [LoginController::class, 'destroy'])
     ->middleware(['auth:sanctum'])
     ->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [\Freelance\User\Application\Http\Controllers\Client\UserController::class, 'show'])
         ->name('users.show');

    Route::put(
        '/freelancer/profile',
        [\Freelance\User\Application\Http\Controllers\Client\FreelancerProfileController::class, 'update']
    )
         ->name('freelancer.profile.update');
});
