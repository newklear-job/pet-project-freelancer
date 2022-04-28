<?php

namespace Freelance\Task\Domain\Actions\Contracts\Job;

use Freelance\Task\Domain\ValueObjects\Id;

interface DeletesJobAction
{
    public function run(Id $id): void;
}
