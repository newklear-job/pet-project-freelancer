<?php

namespace Freelance\User\Domain\Actions\Contracts;

use Freelance\User\Domain\Dtos\FreelancerProfileDto;
use Freelance\User\Domain\Models\Freelancer;

interface SetsFreelancerProfileAction
{
    public function run(FreelancerProfileDto $dto): Freelancer;
}
