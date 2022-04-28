<?php

namespace Freelance\Task\Domain\Actions\Job;

use Freelance\Task\Domain\Actions\Contracts\Job\CreatesJobAction;
use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Job;
use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\Task\Infrastructure\Repositories\JobRepository;

final class CreateJobAction implements CreatesJobAction
{
    public function __construct(
        private JobRepository $repository,
    ) {
    }

    public function run(JobDto $dto): Job
    {
        $job =  $this->repository->create($dto);
        $this->repository->syncCategories(Id::create($job->id), $dto->getCategoryIds());

        return $job;
    }
}
