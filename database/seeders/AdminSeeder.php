<?php

namespace Database\Seeders;

use Freelance\User\Domain\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class AdminSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@admin.admin'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
