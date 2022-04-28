<?php

namespace Freelance\Task\Domain\Actions\Contracts\Job;

use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Job;

interface CreatesJobAction
{
    public function run(JobDto $dto): Job;
}
