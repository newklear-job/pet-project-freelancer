<?php

namespace Freelance\Task\Domain\Actions;

use Freelance\Task\Domain\Actions\Contracts\CreatesCategoryAction;
use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Infrastructure\Repositories\CategoryRepository;

final class CreateCategoryAction implements CreatesCategoryAction
{
    public function __construct(
        private CategoryRepository $repository,
    ) {
    }

    public function run(CategoryDto $dto): Category
    {
        return $this->repository->create($dto);
    }
}
