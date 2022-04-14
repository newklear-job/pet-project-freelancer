<?php

namespace Freelance\User\Infrastructure\Repositories;

use Freelance\User\Domain\ValueObjects\Id;
use Freelance\User\Domain\Dtos\RegisterDto;
use Freelance\User\Domain\Models\User;
use Freelance\User\Domain\ValueObjects\Email;

interface UserRepository
{
    public function findByEmail(Email $email): User;

    public function findById(Id $id): User;

    public function create(RegisterDto $dto): User;

    public function hasRole(Id $id, string $roleName): bool;

    public function hasPermissionTo(Id $id, string $permissionName): bool;
}
