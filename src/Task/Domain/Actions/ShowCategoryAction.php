<?php

namespace Freelance\Task\Domain\Actions;

use App\ValueObjects\Id;
use Freelance\Task\Domain\Actions\Contracts\ShowsCategoryAction;
use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Infrastructure\Repositories\CategoryRepository;

final class ShowCategoryAction implements ShowsCategoryAction
{
    public function __construct(
        private CategoryRepository $repository,
    ) {
    }

    public function run(Id $id): Category
    {
        return $this->repository->getById($id);
    }
}
