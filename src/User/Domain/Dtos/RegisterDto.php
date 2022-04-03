<?php

namespace Freelance\User\Domain\Dtos;

use Freelance\User\Domain\Models\User;
use Freelance\User\Domain\ValueObjects\Email;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

final class RegisterDto
{
    private function __construct(
        private Email  $email,
        private string $name,
        private string $password,
    ) {
    }

    public static function create(string $email, string $name, string $password, string $password_confirmation)
    {
        self::validate(get_defined_vars());
        return new self (
            email   : Email::create($email),
            name    : $name,
            password: $password,
        );
    }

    private static function validate(array $args): void
    {
        Validator::validate(
            $args, [
                     'name'     => ['required', 'string', 'max:255'],
                     'email'    => [
                         'required',
                         'string',
                         'email',
                         'max:255',
                         Rule::unique(User::class),
                     ],
                     'password' => ['required', 'string', new Password, 'confirmed']
                 ]

        );

    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
