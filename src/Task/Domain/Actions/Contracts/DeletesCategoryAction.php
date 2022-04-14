<?php

namespace Freelance\Task\Domain\Actions\Contracts;

use Freelance\Task\Domain\ValueObjects\Id;

interface DeletesCategoryAction
{
    public function run(Id $id): void;
}
