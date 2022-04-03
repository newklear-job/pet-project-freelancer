<?php

namespace Freelance\User\Domain\Actions\Contracts;

use Freelance\User\Domain\Models\User;

interface LogoutsUserAction
{
    public function run(User $currentUser): void;
}
