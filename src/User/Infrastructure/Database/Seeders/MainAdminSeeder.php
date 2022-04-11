<?php

namespace Freelance\User\Infrastructure\Database\Seeders;

use Freelance\User\Domain\Enums\RoleEnum;
use Freelance\User\Domain\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class MainAdminSeeder extends Seeder
{
    public function run()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@mail.mail'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );
        $admin->assignRole(RoleEnum::SUPER_ADMIN->value);
    }
}
