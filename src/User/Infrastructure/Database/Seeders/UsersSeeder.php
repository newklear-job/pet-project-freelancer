<?php

namespace Freelance\User\Infrastructure\Database\Seeders;

use Freelance\User\Domain\Enums\RoleEnum;
use Freelance\User\Domain\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UsersSeeder extends Seeder
{
    public function run()
    {
        $client = User::firstOrCreate(
            ['email' => 'client@mail.mail'],
            [
                'name'     => 'Client',
                'password' => Hash::make('12345678'),
            ]
        );
        $client->assignRole(RoleEnum::CLIENT->value);

        $freelancer = User::firstOrCreate(
            ['email' => 'freelancer@mail.mail'],
            [
                'name'     => 'Freelancer',
                'password' => Hash::make('12345678'),
            ]
        );
        $freelancer->assignRole(RoleEnum::FREELANCER->value);
    }
}
