<?php

namespace Freelance\User\Infrastructure\Repositories;

use Freelance\User\Domain\Dtos\FreelancerProfileDto;
use Freelance\User\Domain\Models\Freelancer;
use Freelance\User\Domain\ValueObjects\Id;
use Illuminate\Support\Collection;

interface FreelancerRepository
{
    public function updateOrCreateProfile(FreelancerProfileDto $dto): Freelancer;

    /**
     * @param Id[] $categoryIds
     */
    public function syncCategories(Id $freelancerId, array $categoryIds): void;

    public function findById(Id $id): Freelancer;

    public function getFreelancerCategoriesPivot(Id $freelancerId): Collection;
}
