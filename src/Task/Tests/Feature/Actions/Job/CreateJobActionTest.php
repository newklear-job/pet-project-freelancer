<?php

use Freelance\Task\Domain\Actions\Contracts\Job\CreatesJobAction;
use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Domain\Models\Job;
use Illuminate\Http\UploadedFile;

uses(\Tests\FeatureTestCase::class);

it('creates job and returns it on action call', function () {
    $action = app(CreatesJobAction::class);

    $category = Category::factory()->create();

    $file = UploadedFile::fake()->create('file');
    $dto = JobDto::create(
        'name',
        'description',
        [$category->id],
        [$file],
    );

    $job = $action->run($dto);
    expect($job)
        ->name->toBe('name')
        ->description->toBe('description');

    expect($job->categories)->toHaveLength(1);
    expect($job->categories->first())->id->toBe($category->id);

    $this->assertDatabaseHas(Job::class, ['id' => $job->id]);
});
