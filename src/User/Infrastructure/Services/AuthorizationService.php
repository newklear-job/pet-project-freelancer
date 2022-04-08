<?php

namespace Freelance\User\Infrastructure\Services;

use App\ValueObjects\Id;
use Freelance\User\Contracts\AuthorizationService as AuthorizationServiceContract;
use Freelance\User\Infrastructure\Repositories\UserRepository;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

final class AuthorizationService implements AuthorizationServiceContract
{

    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function userHasRole(Id $id, string $roleName): bool
    {
        return $this->repository->hasRole($id, $roleName);
    }

    public function userHasPermission(Id $id, string $permissionName): bool
    {
        try {
            return $this->repository->hasPermissionTo($id, $permissionName);
        }
        catch (PermissionDoesNotExist $exception) {
            return false;
        }
    }
}
