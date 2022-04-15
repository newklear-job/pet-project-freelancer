<?php

namespace Freelance\User\Infrastructure\Repositories;

use Freelance\User\Domain\Dtos\FreelancerProfileDto;
use Freelance\User\Domain\Models\Freelancer;

interface FreelancerRepository
{
    public function updateOrCreateProfile(FreelancerProfileDto $dto): Freelancer;
}
