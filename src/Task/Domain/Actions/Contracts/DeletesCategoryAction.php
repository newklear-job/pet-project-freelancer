<?php

namespace Freelance\Task\Domain\Actions\Contracts;

use App\ValueObjects\Id;

interface DeletesCategoryAction
{
    public function run(Id $id): void;
}
