<?php

namespace Freelance\Task\Domain\Actions\Contracts;

use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Domain\ValueObjects\Id;

interface UpdatesCategoryAction
{
    public function run(Id $id, CategoryDto $dto): Category;
}
