<?php

use Freelance\User\Domain\Actions\Contracts\SetsFreelancerProfileAction;
use Freelance\User\Domain\Models\User;

uses(\Tests\FeatureTestCase::class);

it('register store method calls proper action and returns token', function () {
    $user = User::factory()->create();
    login($user);
    $this->putJson(route('freelancer.profile.update'), [
        'hour_rate' => 100_00,
    ])
         ->assertSuccessful()
         ->assertJsonStructure(['data' => ['hour_rate', 'user_id']])
         ->assertJsonFragment(['hour_rate' => "100.00"]);
})->shouldHaveCalledAction(SetsFreelancerProfileAction::class);

it('update freelancer profile is closed to guests.', function () {
    $this->putJson(route('freelancer.profile.update'))
         ->assertUnauthorized();
});
