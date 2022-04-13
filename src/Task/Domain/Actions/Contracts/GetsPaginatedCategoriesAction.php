<?php

namespace Freelance\Task\Domain\Actions\Contracts;

use Filterable\Dtos\FilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GetsPaginatedCategoriesAction
{
    public function run(FilterDto $dto): LengthAwarePaginator;
}
