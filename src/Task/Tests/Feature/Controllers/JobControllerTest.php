<?php

use Freelance\Task\Domain\Actions\Contracts\Job\CreatesJobAction;
use Freelance\Task\Domain\Actions\Contracts\Job\DeletesJobAction;
use Freelance\Task\Domain\Actions\Contracts\Job\GetsPaginatedJobsAction;
use Freelance\Task\Domain\Actions\Contracts\Job\ShowsJobAction;
use Freelance\Task\Domain\Actions\Contracts\Job\UpdatesJobAction;
use Freelance\Task\Domain\Models\Job;

uses(\Tests\FeatureTestCase::class);

it('job index returns data and calls action', function () {
    $this->seed();
    $job = Job::factory()->create();
    login();
    $this->getJson(route('jobs.index'))
         ->assertSuccessful()
         ->assertJsonStructure([
                                   'data' => [
                                       [
                                           'id',
                                           'name',
                                           'description',
                                           'categories',
                                           'media',
                                           'created_at',
                                           'updated_at',
                                       ]
                                   ]
                               ])
         ->assertJsonCount(1, 'data')
         ->assertJsonFragment(['name' => $job->name]);
})->shouldHaveCalledAction(GetsPaginatedJobsAction::class);

it('job store returns data and calls proper action', function () {
    $this->seed();
    login();
    $this->postJson(route('jobs.store'), [
        'name'      => 'test name',
        'description' => 'description',
    ])
         ->assertSuccessful()
         ->assertJsonStructure([
                                   'data' => [
                                       'id',
                                       'name',
                                       'description',
                                       'categories',
                                       'media',
                                       'created_at',
                                       'updated_at',
                                   ]
                               ])
         ->assertJsonFragment(['name' => 'test name']);
})->shouldHaveCalledAction(CreatesJobAction::class);

it('job show returns data and calls proper action', function () {
    $this->seed();
    login();
    $job = Job::factory()->create();
    $this->getJson(route('jobs.show', $job->id))
         ->assertSuccessful()
         ->assertJsonStructure([
                                   'data' => [
                                       'id',
                                       'name',
                                       'description',
                                       'categories',
                                       'media',
                                       'created_at',
                                       'updated_at',
                                   ]
                               ])
         ->assertJsonFragment(['name' => $job->name]);
})->shouldHaveCalledAction(ShowsJobAction::class);

it('job update returns data and calls proper action', function () {
    $this->seed();
    login();
    $job = Job::factory()->create();
    $this->patchJson(route('jobs.update', $job->id), [
        'name'      => 'test name',
        'description' => 'description',
    ])
         ->assertSuccessful()
         ->assertJsonStructure([
                                   'data' => [
                                       'id',
                                       'name',
                                       'description',
                                       'categories',
                                       'media',
                                       'created_at',
                                       'updated_at',
                                   ]
                               ])
         ->assertJsonFragment(['name' => 'test name']);
})->shouldHaveCalledAction(UpdatesJobAction::class);

it('job destroy calls proper action', function () {
    $this->seed();
    login();
    $job = Job::factory()->create();
    $this->deleteJson(route('jobs.destroy', $job->id))
         ->assertSuccessful();
})->shouldHaveCalledAction(DeletesJobAction::class);

it('job endpoints are closed to guests', function () {
    $this->getJson(route('jobs.index'))
         ->assertUnauthorized();
    $this->postJson(route('jobs.store'))
         ->assertUnauthorized();
    $this->getJson(route('jobs.show', 1))
         ->assertUnauthorized();
    $this->patchJson(route('jobs.update', 1))
         ->assertUnauthorized();
    $this->deleteJson(route('jobs.destroy', 1))
         ->assertUnauthorized();
});
