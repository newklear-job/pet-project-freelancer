<?php

namespace Freelance\User\Contracts;


interface AuthorizationService
{
    public function userHasRole($id, string $roleName): bool;

    public function userHasPermission($id, string $permissionName): bool;

    public function adminRole(): string;
}
