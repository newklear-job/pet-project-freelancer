<?php

namespace Freelance\Task\Domain\Actions\Contracts\Job;

use Freelance\Task\Domain\Models\Job;
use Freelance\Task\Domain\ValueObjects\Id;

interface ShowsJobAction
{
    public function run(Id $id): Job;
}
