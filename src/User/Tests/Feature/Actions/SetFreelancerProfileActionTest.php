<?php

use Freelance\Task\Contracts\CategoryService;
use Freelance\User\Domain\Actions\Contracts\SetsFreelancerProfileAction;
use Freelance\User\Domain\Dtos\FreelancerProfileDto;
use Freelance\User\Domain\Models\Freelancer;
use Freelance\User\Domain\Models\User;
use Freelance\User\Domain\ValueObjects\Money;
use Illuminate\Support\Facades\DB;

uses(\Tests\FeatureTestCase::class);

it('returns freelancer on freelancer profile action', function () {
    $action = app(SetsFreelancerProfileAction::class);
    $dto = FreelancerProfileDto::create(
        $userId = User::factory()->create()->id,
        1000,

    );
    $freelancer = $action->run($dto);

    expect($freelancer->refresh())->toBeInstanceOf(Freelancer::class)
        ->user_id->toBe($userId)
        ->hour_rate->equals(Money::create(1000));
});

it('updates freelancer profile when profile existed on freelancer profile action', function () {
    $action = app(SetsFreelancerProfileAction::class);
    $freelancerProfile = Freelancer::factory()->create();
    $dto = FreelancerProfileDto::create(
        $userId = $freelancerProfile->user_id,
        1000,

    );
    $freelancer = $action->run($dto);

    expect($freelancer->refresh())->toBeInstanceOf(Freelancer::class)
        ->user_id->toBe($userId)
        ->hour_rate->equals(Money::create(1000));
});

it('syncs freelancer categories', function () {
    $this->instance(
        CategoryService::class,
        mock(CategoryService::class)->expect(
            doesCategoriesExist: fn($name) => true,
        )
    );

    $action = app(SetsFreelancerProfileAction::class);

    $freelancerProfile = Freelancer::factory()->create();
    $dto = FreelancerProfileDto::create(
        $freelancerProfile->user_id,
        1000,
        [2, 3]
    );

    DB::table('category_freelancer')->insert([
                                                 ['category_id' => 1, 'freelancer_id' => $freelancerProfile->id],
                                                 ['category_id' => 3, 'freelancer_id' => $freelancerProfile->id]
                                             ]);

    $action->run($dto);

    $this->assertDatabaseCount('category_freelancer', 2);
    $this->assertDatabaseHas('category_freelancer', ['category_id' => 2]);
    $this->assertDatabaseHas('category_freelancer', ['category_id' => 3]);
});

it('throws validation error when passed categories does not exist', function () {
    $action = app(SetsFreelancerProfileAction::class);

    $dto = FreelancerProfileDto::create(
        User::factory()->create()->id,
        1000,
        [2, 3]
    );

    expect(fn() => $action->run($dto))->toBeInvalid(['category_ids' => 'exist']);
});
