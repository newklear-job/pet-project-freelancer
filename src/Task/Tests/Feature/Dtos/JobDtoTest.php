<?php

use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Domain\ValueObjects\Id;
use Illuminate\Http\UploadedFile;

uses(\Tests\FeatureTestCase::class);

it('returns valid job dto on create', function () {
    $category = Category::factory()->create();

    $file = UploadedFile::fake()->image('specification.docx');

    $dto = JobDto::create(
        'name',
        'description',
        [$category->id],
        [$file]
    );
    expect($dto)->toBeInstanceOf(JobDto::class)
                ->getName()->toBe('name')
                ->getDescription()->toBe('description')
                ->getMedia()->toBe([$file]);

    expect($dto->getCategoryIds())->toBeArray()
                                  ->toHaveLength(1);

    expect($dto->getCategoryIds()[0])->equals(Id::create($category->id));
});

it('handles job dto validation', function (array $data, array $errors) {
    $data = [
        $data['name'] ?? 'name',
        $data['description'] ?? 'description',
        $data['category_ids'] ?? [],
        $data['media'] ?? []
    ];
    expect(fn() => JobDto::create(
        ...$data
    ))->toBeInvalid($errors);
})->with([
             'name is not set' => [
                 [
                     'name' => '',
                 ],
                 [
                     'name' => 'required'
                 ]
             ],
             'name < 2' => [
                 [
                     'name' => 'a'
                 ],
                 [
                     'name' => '2'
                 ]
             ],
             'name > 255' => [
                 [
                     'name' => str_repeat('a', 256),
                 ],
                 [
                     'name' => '255'
                 ]
             ],
             'description is not set' => [
                 [
                     'description' => '',
                 ],
                 [
                     'description' => 'required'
                 ]
             ],
             'description < 2' => [
                 [
                     'description' => 'a'
                 ],
                 [
                     'description' => '2'
                 ]
             ],
             'description > 10000' => [
                 [
                     'description' => str_repeat('a', 10_001),
                 ],
                 [
                     'description' => '10000'
                 ]
             ],
             'category_ids not array' => [
                 [
                     'category_ids' => 1
                 ],
                 [
                     'category_ids' => 'array'
                 ]
             ],
             'category_ids.* not exist' => [
                 [
                     'category_ids' => [1]
                 ],
                 [
                     'category_ids.0' => 'valid'
                 ]
             ],
             'media not array' => [
                 [
                     'media' => 1
                 ],
                 [
                     'media' => 'array'
                 ]
             ],
             'media.* not file' => [
                 [
                     'media' => ['not a file']
                 ],
                 [
                     'media.0' => 'file'
                 ]
             ],

         ]);

