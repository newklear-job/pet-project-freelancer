<?php

namespace Freelance\User\Domain\Actions;

use Freelance\User\Domain\Actions\Contracts\LoginsUserAction;
use Freelance\User\Domain\Dtos\LoginDto;
use Freelance\User\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

final class LoginUserAction implements LoginsUserAction
{
    public function __construct(
        private UserRepository $repository,
    ) {
    }

    public function run(LoginDto $dto): NewAccessToken
    {
        $user = $this->repository->findByEmail($dto->getEmail());

        if (!Hash::check($dto->getPassword(), $user->password)) {
            throw ValidationException::withMessages([
                                                        'email' => ['Incorrect credentials.'],
                                                    ]);
        }

        return $user->createToken('default');
    }
}
