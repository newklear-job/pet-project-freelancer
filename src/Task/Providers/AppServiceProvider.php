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
    }
}
