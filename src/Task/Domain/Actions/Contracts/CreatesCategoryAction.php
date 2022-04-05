<?php

namespace Freelance\Task\Domain\Actions\Contracts;

use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;

interface CreatesCategoryAction
{
    public function run(CategoryDto $dto): Category;
}
