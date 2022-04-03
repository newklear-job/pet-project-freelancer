<?php

namespace Freelance\User\Providers;

use Freelance\User\Domain\Actions\Contracts\LoginsUserAction;
use Freelance\User\Domain\Actions\Contracts\LogoutsUserAction;
use Freelance\User\Domain\Actions\Contracts\RegistersUserAction;
use Freelance\User\Domain\Actions\LoginUserAction;
use Freelance\User\Domain\Actions\LogoutUserAction;
use Freelance\User\Domain\Actions\RegisterUserAction;
use Freelance\User\Infrastructure\Repositories\EloquentUserRepository;
use Freelance\User\Infrastructure\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepository::class      => EloquentUserRepository::class,
        LoginsUserAction::class    => LoginUserAction::class,
        LogoutsUserAction::class   => LogoutUserAction::class,
        RegistersUserAction::class => RegisterUserAction::class,
    ];

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
        $this->app->register(FortifyServiceProvider::class);


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
