<?php

namespace Freelance\User\Domain\Actions;

use Freelance\User\Domain\Actions\Contracts\RegistersUserAction;
use Freelance\User\Domain\Dtos\RegisterDto;
use Freelance\User\Domain\Models\User;
use Freelance\User\Infrastructure\Repositories\UserRepository;

final class RegisterUserAction implements RegistersUserAction
{
    public function __construct(
        private UserRepository $repository,
    ) {
    }

    public function run(RegisterDto $dto): User
    {
        return $this->repository->create($dto);
    }
}
