<?php

namespace Freelance\Task\Providers;

use App\ValueObjects\Id;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('category', '[0-9]+');
        Route::bind('category', function ($value) {
            return Id::create($value);
        });

        $this->routes(function () {
            if (file_exists(__DIR__ . '/../api.php')) {
                Route::prefix('api')
                     ->middleware('api')
                     ->group(__DIR__ . '/../api.php');
            }

            if (file_exists(__DIR__ . '/../web.php')) {
                Route::middleware('web')
                     ->group(__DIR__ . '/../web.php');
            }
        });
    }
}
