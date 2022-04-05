<?php

namespace Freelance\Task\Domain\Actions;

use Freelance\Task\Domain\Actions\Contracts\UpdatesCategoryAction;
use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\Task\Infrastructure\Repositories\CategoryRepository;

final class UpdateCategoryAction implements UpdatesCategoryAction
{
    public function __construct(
        private CategoryRepository $repository,
    ) {
    }

    public function run(Id $id, CategoryDto $dto): Category
    {
        return $this->repository->update($id, $dto);
    }
}
