<?php

namespace Freelance\Task\Domain\Actions\Contracts\Job;

use Filterable\Dtos\FilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GetsPaginatedJobsAction
{
    public function run(FilterDto $filterDto): LengthAwarePaginator;
}
