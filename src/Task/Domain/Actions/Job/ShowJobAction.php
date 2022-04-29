<?php

namespace Freelance\Task\Domain\Actions\Job;

use Freelance\Task\Domain\Actions\Contracts\Job\ShowsJobAction;
use Freelance\Task\Domain\Models\Job;
use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\Task\Infrastructure\Repositories\JobRepository;

final class ShowJobAction implements ShowsJobAction
{
    public function __construct(
        private JobRepository $repository,
    ) {
    }

    public function run(Id $id): Job
    {
        $job = $this->repository->getById($id);
        $this->repository->loadRelations($job);
        return $job;
    }
}
