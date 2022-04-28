<?php

namespace Freelance\Task\Domain\Actions\Job;

use Filterable\Dtos\FilterDto;
use Freelance\Task\Domain\Actions\Contracts\Job\GetsPaginatedJobsAction;
use Freelance\Task\Infrastructure\Repositories\JobRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class GetPaginatedJobsAction implements GetsPaginatedJobsAction
{
    public function __construct(
        private JobRepository $repository,
    ) {
    }

    public function run(FilterDto $filterDto): LengthAwarePaginator
    {
        return $this->repository->getPaginatedForAdminPanel($filterDto);
    }
}
