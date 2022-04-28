<?php

use Freelance\Task\Domain\Actions\Contracts\Job\UpdatesJobAction;
use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Domain\Models\Job;
use Freelance\Task\Domain\ValueObjects\Id;
use Illuminate\Http\UploadedFile;

uses(\Tests\FeatureTestCase::class);

it('updates job and returns on action call', function () {
    Storage::fake();
    $action = app(UpdatesJobAction::class);

    $category = Category::factory()->create();

    $old = Job::factory()->create();

    $file = UploadedFile::fake()->create('specification.docx');
    $dto = JobDto::create(
        'name',
        'description',
        [$category->id],
        [$file],
    );

    $job = $action->run(Id::create($old->id), $dto);
    expect($job)
        ->name->toBe('name')
        ->description->toBe('description');

    $this->assertDatabaseHas(Job::class, ['id' => $job->id]);

    expect($job->categories)->toHaveLength(1);
    expect($job->categories->first())->id->toBe($category->id);

    expect($job->media)->toHaveLength(1);
    $uploadedMedia = $job->media->first();
    expect($uploadedMedia)->file_name->toBe('specification.docx');
    Storage::disk()->assertExists("$uploadedMedia->id/$uploadedMedia->full_name");
});

