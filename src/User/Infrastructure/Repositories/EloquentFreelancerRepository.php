<?php

namespace Freelance\User\Infrastructure\Repositories;

use Freelance\User\Domain\Dtos\FreelancerProfileDto;
use Freelance\User\Domain\Models\Freelancer;

final class EloquentFreelancerRepository implements FreelancerRepository
{
    public function updateOrCreateProfile(FreelancerProfileDto $dto): Freelancer
    {
        return Freelancer::updateOrCreate(
            [
                'user_id' => $dto->getUserId()
            ],
            [
                'hour_rate' => $dto->getHourRate()
            ]
        );
    }
}
