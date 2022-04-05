<?php

use Freelance\Task\Domain\Actions\Contracts\CreatesCategoryAction;
use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;

uses(\Tests\FeatureTestCase::class);

it('creates category and returns it on action call', function () {
    $action = app(CreatesCategoryAction::class);
    $dto = CategoryDto::create(
        'test name',
        null
    );
    $category = $action->run($dto);
    expect($category)
        ->name->toBe('test name')
        ->parent_id->toBe(null);

    $this->assertDatabaseHas(Category::class, ['id' => $category->id]);
});
