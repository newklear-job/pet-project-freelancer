<?php

use Freelance\Task\Contracts\CategoryService;
use Freelance\User\Domain\Actions\Contracts\SetsFreelancerProfileAction;
use Freelance\User\Domain\Models\User;

uses(\Tests\FeatureTestCase::class);

it('update freelancer profile method calls proper action and returns correct data', function () {
    $user = User::factory()->create();
    login($user);

    $this->putJson(route('freelancer.profile.update'), [
        'hour_rate'    => 100_00,
        'category_ids' => [2, 3]
    ])
         ->assertSuccessful()
         ->assertJsonStructure(['data' => ['hour_rate', 'user_id']])
         ->assertJsonFragment(['hour_rate' => "100.00"])
         ->assertJsonFragment(['category_ids' => [2,  3]]);
})->shouldHaveCalledAction(SetsFreelancerProfileAction::class, function () {
    app()->instance(
        CategoryService::class,
        mock(CategoryService::class)->expect(
            doesCategoriesExist: fn($name) => 123,
        )
    );
});

it('update freelancer profile is closed to guests.', function () {
    $this->putJson(route('freelancer.profile.update'))
         ->assertUnauthorized();
});
