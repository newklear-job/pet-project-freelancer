<?php

namespace Freelance\Task\Domain\Actions\Contracts;

use App\ValueObjects\Id;
use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;

interface UpdatesCategoryAction
{
    public function run(Id $id, CategoryDto $dto): Category;
}
