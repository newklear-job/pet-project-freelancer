<?php

namespace Freelance\Task\Domain\Actions\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GetsPaginatedCategoriesAction
{
    public function run(): LengthAwarePaginator;
}
