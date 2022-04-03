<?php

namespace Freelance\User\Domain\ValueObjects;

use InvalidArgumentException;

final class Email
{
    private function __construct(private string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'Email ' . $email . ' is not valid'
            );
        }
    }

    public static function create(string $email)
    {
        return new self($email);
    }

    public function value(): string
    {
        return $this->email;
    }

    public function equals(Email $other): bool
    {
        return $this->email === $other->email;
    }
}
