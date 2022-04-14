<?php

namespace Freelance\User\Infrastructure\Services;

use Freelance\User\Domain\ValueObjects\Id;
use Freelance\User\Contracts\AuthorizationService as AuthorizationServiceContract;
use Freelance\User\Domain\Enums\RoleEnum;
use Freelance\User\Infrastructure\Repositories\UserRepository;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

final class AuthorizationService implements AuthorizationServiceContract
{

    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function userHasRole($id, string $roleName): bool
    {
        return $this->repository->hasRole(Id::create($id), $roleName);
    }

    public function userHasPermission($id, string $permissionName): bool
    {
        try {
            return $this->repository->hasPermissionTo(Id::create($id), $permissionName);
        }
        catch (PermissionDoesNotExist $exception) {
            return false;
        }
    }

    public function adminRole(): string
    {
        return RoleEnum::SUPER_ADMIN->value;
    }
}
