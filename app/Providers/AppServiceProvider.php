<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            $moduleName = explode('\\', explode('Freelance\\', $modelName)[1])[0];
            return 'Freelance\\' .
                   $moduleName .
                   '\Infrastructure\Database\Factories\\' .
                   (class_basename($modelName)) .
                   'Factory';
        });

        Factory::guessModelNamesUsing(function (object $factoryClass) {
            $factoryClassName = get_class($factoryClass);
            $moduleName = explode('\\', explode('Freelance\\', $factoryClassName)[1])[0];
            return 'Freelance\\' .
                   $moduleName .
                   '\Domain\Models\\' .
                   explode('Factory', (class_basename($factoryClass)))[0];
        });
    }
}
