<?php

namespace Freelance\Task\Domain\Actions\Contracts\Job;

use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Job;
use Freelance\Task\Domain\ValueObjects\Id;

interface UpdatesJobAction
{
    public function run(Id $id, JobDto $dto): Job;
}
