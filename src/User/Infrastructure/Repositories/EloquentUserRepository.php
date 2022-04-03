<?php

namespace Freelance\User\Infrastructure\Repositories;

use Freelance\User\Domain\Dtos\RegisterDto;
use Freelance\User\Domain\Models\User;
use Freelance\User\Domain\ValueObjects\Email;
use Illuminate\Support\Facades\Hash;

final class EloquentUserRepository implements UserRepository
{

    public function findByEmail(Email $email)
    {
        return User::where('email', $email->value())->firstOrFail();
    }

    public function create(RegisterDto $dto)
    {
        return User::create([
                                'name'     => $dto->getName(),
                                'email'    => $dto->getEmail(),
                                'password' => Hash::make($dto->getPassword()),
                            ]);
    }
}
