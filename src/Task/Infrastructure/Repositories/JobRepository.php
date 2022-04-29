<?php

namespace Freelance\Task\Infrastructure\Repositories;

use Freelance\Task\Domain\ValueObjects\Id;
use Filterable\Dtos\FilterDto;
use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Job;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface JobRepository
{
    public function getPaginatedForAdminPanel(FilterDto $filterDto): LengthAwarePaginator;

    public function create(JobDto $dto): Job;

    public function update(Id $id, JobDto $dto): Job;

    public function getById(Id $id): Job;

    public function deleteById(Id $id): void;

    /**
     * @param Id[] $categoryIds
     */
    public function syncCategories(Id $jobId, array $categoryIds): void;

    public function loadRelations(Job $job): void;
}
