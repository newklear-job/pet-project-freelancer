<?php

namespace Freelance\User\Contracts;

use App\ValueObjects\Id;

interface AuthorizationService
{
    public function userHasRole(Id $id, string $roleName): bool;

    public function userHasPermission(Id $id, string $permissionName): bool;
}
