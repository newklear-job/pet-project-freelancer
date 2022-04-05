<?php

use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;

uses(\Tests\FeatureTestCase::class);

it('returns valid category dto on create', function () {
    $category = Category::factory()->create();
    $dto = CategoryDto::create(
        'test@test.test',
        $category->id,
    );
    expect($dto)->toBeInstanceOf(CategoryDto::class);
});

it('handles category dto validation', function (array $data, array $errors) {
    $data = [
        $data['name'] ?? 'name',
        $data['parent_id'] ?? null,
    ];
    expect(fn() => CategoryDto::create(
        ...$data
    ))->toBeInvalid($errors);
})->with([
             'name is not set'          => [
                 [
                     'name' => '',
                 ],
                 [
                     'name' => 'required'
                 ]
             ],
             'name > 255'               => [
                 [
                     'name' => str_repeat('a', 256),
                 ],
                 [
                     'name' => '255'
                 ]
             ],
             'parent_id is not numeric'        => [
                 [
                     'parent_id' => 'abc',
                 ],
                 [
                     'parent_id' => 'number',
                 ]
             ],
             'parent_id does not exist'        => [
                 [
                     'parent_id' => 10,
                 ],
                 [
                     'parent_id' => 'valid',
                 ]
             ],
         ]);

