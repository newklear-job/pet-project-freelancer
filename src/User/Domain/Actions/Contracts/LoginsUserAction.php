<?php

namespace Freelance\User\Domain\Actions\Contracts;

use Freelance\User\Domain\Dtos\LoginDto;
use Laravel\Sanctum\NewAccessToken;

interface LoginsUserAction
{
    public function run(LoginDto $dto): NewAccessToken;
}
