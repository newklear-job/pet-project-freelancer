<?php

namespace Freelance\User\Domain\Actions\Contracts;

use Freelance\User\Domain\Dtos\RegisterDto;
use Freelance\User\Domain\Models\User;

interface RegistersUserAction
{
    public function run(RegisterDto $dto): User;
}
