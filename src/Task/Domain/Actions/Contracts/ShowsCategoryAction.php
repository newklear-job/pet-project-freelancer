<?php

namespace Freelance\Task\Domain\Actions\Contracts;

use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Domain\ValueObjects\Id;

interface ShowsCategoryAction
{
    public function run(Id $id): Category;
}
