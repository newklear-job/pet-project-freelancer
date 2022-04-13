<?php

use Filterable\Dtos\FilterDto;
use Freelance\Task\Domain\Actions\Contracts\GetsPaginatedCategoriesAction;
use Freelance\Task\Domain\Models\Category;

uses(\Tests\FeatureTestCase::class);

test('GetPaginatedCategoriesAction filters by name', function () {
    $action = app(GetsPaginatedCategoriesAction::class);

    Category::factory()->name('test name')->create();
    Category::factory()->name('another name')->create();
    $data = [
        'name' => 'st na'
    ];
    $dto = FilterDto::createFromArrayBag($data);

    $paginated = $action->run($dto);

    expect($paginated)
        ->total()->toBe(1);

    expect($paginated->items()[0])
        ->name->toBe('test name');
});

test('GetPaginatedCategoriesAction filters by parent_id', function () {
    $action = app(GetsPaginatedCategoriesAction::class);

    $parent = Category::factory()->name('test name')->create();
    Category::factory()->name('another name')->childOf($parent)->create();
    $data = [
        'parent_id' => null
    ];
    $dto = FilterDto::createFromArrayBag($data);

    $paginated = $action->run($dto);

    expect($paginated)
        ->total()->toBe(1);

    expect($paginated->items()[0])
        ->name->toBe($parent->name);
});

test('GetPaginatedCategoriesAction paginates', function () {
    $action = app(GetsPaginatedCategoriesAction::class);

    Category::factory()->name('first')->create();
    Category::factory()->name('second')->create();
    $data = [
        config('filterable.queryParam.page')    => 2,
        config('filterable.queryParam.perPage') => 1,
    ];

    $dto = FilterDto::createFromArrayBag($data);

    $paginated = $action->run($dto);
    expect($paginated)
        ->currentPage()->toBe(2);

    expect($paginated->items()[0])
        ->name->toBe('second');
});
test('GetPaginatedCategoriesAction sorts', function () {
    $action = app(GetsPaginatedCategoriesAction::class);

    Category::factory()->name('2')->create();
    Category::factory()->name('1')->create();
    $data = [
        config('filterable.queryParam.orderBy')          => 'name',
        config('filterable.queryParam.orderByDirection') => 'desc',
    ];
    $dto = FilterDto::createFromArrayBag($data);

    $paginated = $action->run($dto);

    expect($paginated->items()[0])
        ->name->toBe('2');
    expect($paginated->items()[1])
        ->name->toBe('1');
});

