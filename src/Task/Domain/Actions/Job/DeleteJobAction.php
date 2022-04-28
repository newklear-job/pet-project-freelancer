<?php

namespace Freelance\Task\Domain\Actions\Job;

use Freelance\Task\Domain\Actions\Contracts\Job\DeletesJobAction;
use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\Task\Infrastructure\Repositories\JobRepository;

final class DeleteJobAction implements DeletesJobAction
{
    public function __construct(
        private JobRepository $repository,
    ) {
    }

    public function run(Id $id): void
    {
        $this->repository->deleteById($id);
    }
}
