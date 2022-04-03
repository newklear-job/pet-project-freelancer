<?php

namespace Freelance\User\Domain\Dtos;

use Freelance\User\Domain\ValueObjects\Email;
use Illuminate\Support\Facades\Validator;

final class LoginDto
{
    private function __construct(
        private Email  $email,
        private string $password,
    ) {
    }

    public static function create(string $email, string $password)
    {
        self::validate(get_defined_vars());
        return new self (
            email   : Email::create($email),
            password: $password,
        );
    }

    private static function validate(array $args): void
    {
        Validator::validate(
            $args,
            [
                'email'    => [
                    'required',
                    'email',
                    'exists:users,email'
                ],
                'password' => [
                    'required'
                ],
            ]
        );
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
