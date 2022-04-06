<?php

namespace Freelance\User\Infrastructure\Database\Seeders;

use Freelance\User\Domain\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::firstOrCreate(['name' => RoleEnum::SUPER_ADMIN]);
        Role::firstOrCreate(['name' => RoleEnum::CLIENT]);
        Role::firstOrCreate(['name' => RoleEnum::FREELANCER]);
    }
}
