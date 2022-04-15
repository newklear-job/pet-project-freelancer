<?php

use Freelance\User\Domain\Actions\Contracts\SetsFreelancerProfileAction;
use Freelance\User\Domain\Dtos\FreelancerProfileDto;
use Freelance\User\Domain\Models\Freelancer;
use Freelance\User\Domain\Models\User;
use Freelance\User\Domain\ValueObjects\Money;

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
