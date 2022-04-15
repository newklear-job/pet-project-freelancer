<?php

namespace Freelance\User\Domain\ValueObjects;

use InvalidArgumentException;

final class Money
{
    private function __construct(private int $amount)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException(
                'Amount ' . $amount . ' is negative number.'
            );
        }
    }

    public static function create(int $amount)
    {
        return new self($amount);
    }

    public function value(): string
    {
        return $this->amount;
    }

    public function formatted(): string
    {
        return number_format($this->amount / 100, 2);
    }

    public function equals(Money $other): bool
    {
        return $this->amount === $other->amount;
    }
}
