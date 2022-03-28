<?php

namespace Freelance\User\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Infrastructure/Database/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'user');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return explode('\Provider', __NAMESPACE__)[0] .
                   '\Infrastructure\Database\Factories\\' .
                   (class_basename($modelName)) .
                   'Factory';
        });

        Factory::guessModelNamesUsing(function (object $factoryClass) {
            return explode('\Provider', __NAMESPACE__)[0] .
                   '\Domain\Models\\' .
                   explode('Factory', (class_basename($factoryClass)))[0];
        });
    }
}
