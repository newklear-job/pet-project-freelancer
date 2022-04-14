<?php

use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\Task\Domain\Actions\Contracts\UpdatesCategoryAction;
use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;

uses(\Tests\FeatureTestCase::class);

it('updates category and returns on action call', function () {
    $action = app(UpdatesCategoryAction::class);
    $old = Category::factory()->create();
    $dto = CategoryDto::create(
        'test name',
        null
    );
    $updated = $action->run(Id::create($old->id), $dto);
    expect($updated)
        ->name->toBe('test name')
        ->parent_id->toBe(null);

    $this->assertDatabaseHas(Category::class, ['name' => 'test name']);
});

it('throws exception if parent_id is self id on category update', function () {
    $action = app(UpdatesCategoryAction::class);
    $old = Category::factory()->create();
    $dto = CategoryDto::create(
        'test name',
        $old->id
    );
    expect(fn() => $action->run(Id::create($old->id), $dto))
        ->toBeInvalid([
                          'parent_id' => 'himself'
                      ]);
});
