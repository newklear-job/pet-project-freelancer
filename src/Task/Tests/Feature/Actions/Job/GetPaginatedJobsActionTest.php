<?php

use Filterable\Dtos\FilterDto;
use Freelance\Task\Domain\Actions\Contracts\Job\GetsPaginatedJobsAction;
use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Domain\Models\Job;

uses(\Tests\FeatureTestCase::class);

test('GetPaginatedJobsAction filters by name', function () {
    $action = app(GetsPaginatedJobsAction::class);

    Job::factory()->name('test name')->create();
    Job::factory()->name('another name')->create();
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

test('GetPaginatedJobsAction filters by description', function () {
    $action = app(GetsPaginatedJobsAction::class);

    $shouldBeFound = Job::factory()->name('test name')->description('description')->create();
    Job::factory()->name('another name')->description('other one')->create();
    $data = [
        'description' => 'description'
    ];
    $dto = FilterDto::createFromArrayBag($data);

    $paginated = $action->run($dto);

    expect($paginated)
        ->total()->toBe(1);

    expect($paginated->items()[0])
        ->name->toBe($shouldBeFound->name);
});

test('GetPaginatedJobsAction filters by category ids', function () {
    $action = app(GetsPaginatedJobsAction::class);

    Job::factory()->create();

    $shouldBeFound = Job::factory()->has(Category::factory())->create();
    $data = [
        'category_ids' => $shouldBeFound->categories()->pluck('categories.id')->toArray()
    ];
    $dto = FilterDto::createFromArrayBag($data);

    $paginated = $action->run($dto);

    expect($paginated)
        ->total()->toBe(1);

    expect($paginated->items()[0])
        ->name->toBe($shouldBeFound->name);
});

test('GetPaginatedJobsAction paginates', function () {
    $action = app(GetsPaginatedJobsAction::class);

    Job::factory()->name('first')->create();
    Job::factory()->name('second')->create();
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
test('GetPaginatedJobsAction sorts', function () {
    $action = app(GetsPaginatedJobsAction::class);

    Job::factory()->name('2')->create();
    Job::factory()->name('1')->create();
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

