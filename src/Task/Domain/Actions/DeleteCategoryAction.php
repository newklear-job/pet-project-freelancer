<?php

namespace Freelance\Task\Domain\Actions;

use Freelance\Task\Domain\Actions\Contracts\DeletesCategoryAction;
use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\Task\Infrastructure\Repositories\CategoryRepository;

final class DeleteCategoryAction implements DeletesCategoryAction
{
    public function __construct(
        private CategoryRepository $repository,
    ) {
    }

    public function run(Id $id): void
    {
        $this->repository->deleteById($id);
    }
}
