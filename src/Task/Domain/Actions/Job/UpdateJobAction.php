<?php

namespace Freelance\Task\Domain\Actions\Job;

use Freelance\Task\Domain\Actions\Contracts\Job\UpdatesJobAction;
use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Job;
use Freelance\Task\Infrastructure\Repositories\JobRepository;

final class UpdateJobAction implements UpdatesJobAction
{
    public function __construct(
        private JobRepository $repository,
    ) {
    }

    public function run(Id $id, JobDto $dto): Job
    {
        $job = $this->repository->update($id, $dto);
        $this->repository->syncCategories($id, $dto->getCategoryIds());

        foreach ($dto->getMedia() as $media) {
            $job->addMedia($media)->toMediaCollection();
        }
        return $job;
    }
}
