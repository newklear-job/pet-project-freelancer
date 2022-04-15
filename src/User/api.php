<?php

use Freelance\User\Application\Http\Controllers\LoginController;
use Freelance\User\Application\Http\Controllers\RegisterController;
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
    Route::get('/user', [\Freelance\User\Application\Http\Controllers\UserController::class, 'show'])
         ->name('users.show');

    Route::put(
        '/freelancer/profile',
        [\Freelance\User\Application\Http\Controllers\FreelancerProfileController::class, 'update']
    )
         ->name('freelancer.profile.update');
});
