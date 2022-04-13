<?php

namespace Freelance\Task\Domain\Actions;

use Filterable\Dtos\FilterDto;
use Freelance\Task\Domain\Actions\Contracts\GetsPaginatedCategoriesAction;
use Freelance\Task\Infrastructure\Repositories\CategoryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class GetPaginatedCategoriesAction implements GetsPaginatedCategoriesAction
{
    public function __construct(
        private CategoryRepository $repository,
    ) {
    }

    public function run(FilterDto $filterDto): LengthAwarePaginator
    {
        return $this->repository->getPaginatedForAdminPanel($filterDto);
    }
}
