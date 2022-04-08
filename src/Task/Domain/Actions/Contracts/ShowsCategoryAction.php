<?php

namespace Freelance\Task\Domain\Actions\Contracts;

use App\ValueObjects\Id;
use Freelance\Task\Domain\Models\Category;

interface ShowsCategoryAction
{
    public function run(Id $id): Category;
}
