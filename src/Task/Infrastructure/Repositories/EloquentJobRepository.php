<?php

namespace Freelance\Task\Infrastructure\Repositories;

use Filterable\Dtos\FilterDto;
use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Job;
use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\Task\Infrastructure\Filters\JobFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EloquentJobRepository implements JobRepository
{
    public function getPaginatedForAdminPanel(FilterDto $filterDto): LengthAwarePaginator
    {
        return Job::query()
                  ->filter((new JobFilter())->setFilters($filterDto->getFilters()))
                  ->when(
                      $filterDto->getSort(),
                      fn($query) => $query->orderBy(
                          $filterDto->getSort()->getName(),
                          $filterDto->getSort()->getDirection()
                      )
                  )
                  ->paginate(
                      perPage: $filterDto->getPagination()->getPerPage(),
                      page   : $filterDto->getPagination()->getPage()
                  );
    }

    public function create(JobDto $dto): Job
    {
        return Job::create([
                               'name' => $dto->getName(),
                               'description' => $dto->getDescription()
                           ]);
    }

    public function update(Id $id, JobDto $dto): Job
    {
        $entity = $this->getById($id);
        $entity->name = $dto->getName();
        $entity->description = $dto->getDescription();
        $entity->save();
        return $entity;
    }

    public function getById(Id $id): Job
    {
        return Job::findOrFail($id->value());
    }

    public function deleteById(Id $id): void
    {
        $entity = $this->getById($id);
        $entity->delete();
    }

    /**
     * @param Id[] $categoryIds
     */
    public function syncCategories(Id $jobId, array $categoryIds): void
    {
        $job = $this->getById($jobId);
        $job->categories()->sync(array_map(fn(Id $id) => $id->value(), $categoryIds));
    }
}
