<?php

use Freelance\User\Domain\Actions\Contracts\SetsFreelancerProfileAction;
use Freelance\User\Domain\Models\User;

uses(\Tests\FeatureTestCase::class);

it('register store method calls proper action and returns token', function () {
    $user = User::factory()->create();
    login($user);
    $categoryOne = \Freelance\Task\Domain\Models\Category::factory()->create();
    $categoryTwo = \Freelance\Task\Domain\Models\Category::factory()->create();
    $this->putJson(route('freelancer.profile.update'), [
        'hour_rate'    => 100_00,
        'category_ids' => [$categoryOne->id, $categoryTwo->id]
    ])
         ->assertSuccessful()
         ->assertJsonStructure(['data' => ['hour_rate', 'user_id']])
         ->assertJsonFragment(['hour_rate' => "100.00"])
         ->assertJsonFragment(['category_ids' => [$categoryOne->id,  $categoryTwo->id]]);
})->shouldHaveCalledAction(SetsFreelancerProfileAction::class);

it('update freelancer profile is closed to guests.', function () {
    $this->putJson(route('freelancer.profile.update'))
         ->assertUnauthorized();
});
