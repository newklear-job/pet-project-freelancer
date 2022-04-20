<?php

namespace Freelance\User\Domain\Actions;

use Freelance\User\Domain\Actions\Contracts\SetsFreelancerProfileAction;
use Freelance\User\Domain\Dtos\FreelancerProfileDto;
use Freelance\User\Domain\Models\Freelancer;
use Freelance\User\Domain\ValueObjects\Id;
use Freelance\User\Infrastructure\Repositories\FreelancerRepository;

final class SetFreelancerProfileAction implements SetsFreelancerProfileAction
{
    public function __construct(
        private FreelancerRepository $repository
    ) {
    }

    public function run(FreelancerProfileDto $dto): Freelancer
    {
        $freelancer = $this->repository->updateOrCreateProfile($dto);

        $freelancerId = Id::create($freelancer->id);
        $this->repository->syncCategories($freelancerId, $dto->getCategoryIds());
        return $freelancer;
    }
}
