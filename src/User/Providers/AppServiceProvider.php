<?php

namespace Freelance\User\Providers;

use Freelance\User\Contracts\AuthorizationService as AuthorizationServiceContract;
use Freelance\User\Domain\Actions\Contracts\LoginsUserAction;
use Freelance\User\Domain\Actions\Contracts\LogoutsUserAction;
use Freelance\User\Domain\Actions\Contracts\RegistersUserAction;
use Freelance\User\Domain\Actions\Contracts\SetsFreelancerProfileAction;
use Freelance\User\Domain\Actions\LoginUserAction;
use Freelance\User\Domain\Actions\LogoutUserAction;
use Freelance\User\Domain\Actions\RegisterUserAction;
use Freelance\User\Domain\Actions\SetFreelancerProfileAction;
use Freelance\User\Infrastructure\Repositories\EloquentFreelancerRepository;
use Freelance\User\Infrastructure\Repositories\EloquentUserRepository;
use Freelance\User\Infrastructure\Repositories\FreelancerRepository;
use Freelance\User\Infrastructure\Repositories\UserRepository;
use Freelance\User\Infrastructure\Services\AuthorizationService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepository::class               => EloquentUserRepository::class,
        LoginsUserAction::class             => LoginUserAction::class,
        LogoutsUserAction::class            => LogoutUserAction::class,
        RegistersUserAction::class          => RegisterUserAction::class,
        AuthorizationServiceContract::class => AuthorizationService::class,
        SetsFreelancerProfileAction::class  => SetFreelancerProfileAction::class,
        FreelancerRepository::class         => EloquentFreelancerRepository::class,
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
        $this->app->register(AuthServiceProvider::class);

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

        Model::preventLazyLoading(! app()->isProduction());
    }
}
