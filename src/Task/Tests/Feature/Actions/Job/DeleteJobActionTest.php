<?php

use Freelance\Task\Domain\Actions\Contracts\Job\DeletesJobAction;
use Freelance\Task\Domain\Models\Job;
use Freelance\Task\Domain\ValueObjects\Id;

uses(\Tests\FeatureTestCase::class);

it('deletes job on action call', function () {
    $action = app(DeletesJobAction::class);
    $old = Job::factory()->create();
    $action->run(Id::create($old->id));

    $this->assertDatabaseMissing(Job::class, ['id' => $old->id]);
});
