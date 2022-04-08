<?php

namespace Freelance\User\Infrastructure\Repositories;

use App\ValueObjects\Id;
use Freelance\User\Domain\Dtos\RegisterDto;
use Freelance\User\Domain\Models\User;
use Freelance\User\Domain\ValueObjects\Email;
use Illuminate\Support\Facades\Hash;

final class EloquentUserRepository implements UserRepository
{

    public function findByEmail(Email $email): User
    {
        return User::where('email', $email->value())->firstOrFail();
    }

    public function create(RegisterDto $dto): User
    {
        return User::create([
                                'name'     => $dto->getName(),
                                'email'    => $dto->getEmail(),
                                'password' => Hash::make($dto->getPassword()),
                            ]);
    }

    public function hasRole(Id $id, string $roleName): bool
    {
        return $this->findById($id)->hasRole($roleName);
    }

    public function findById(Id $id): User
    {
        return User::where('id', $id->value())->firstOrFail();
    }

    public function hasPermissionTo(Id $id, string $permissionName): bool
    {
        return $this->findById($id)->hasPermissionTo($permissionName);
    }
}
