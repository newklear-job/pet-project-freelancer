<?php

namespace Freelance\Task\Providers;

use Freelance\Task\Domain\Actions\Contracts\CreatesCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\DeletesCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\GetsPaginatedCategoriesAction;
use Freelance\Task\Domain\Actions\Contracts\ShowsCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\UpdatesCategoryAction;
use Freelance\Task\Domain\Actions\CreateCategoryAction;
use Freelance\Task\Domain\Actions\DeleteCategoryAction;
use Freelance\Task\Domain\Actions\GetPaginatedCategoriesAction;
use Freelance\Task\Domain\Actions\ShowCategoryAction;
use Freelance\Task\Domain\Actions\UpdateCategoryAction;
use Freelance\Task\Infrastructure\Repositories\CategoryRepository;
use Freelance\Task\Infrastructure\Repositories\EloquentCategoryRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        CategoryRepository::class            => EloquentCategoryRepository::class,
        GetsPaginatedCategoriesAction::class => GetPaginatedCategoriesAction::class,
        CreatesCategoryAction::class         => CreateCategoryAction::class,
        ShowsCategoryAction::class           => ShowCategoryAction::class,
        UpdatesCategoryAction::class         => UpdateCategoryAction::class,
        DeletesCategoryAction::class          => DeleteCategoryAction::class,
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
    }
}
