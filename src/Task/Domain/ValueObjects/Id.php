<?php

namespace Freelance\Task\Domain\ValueObjects;

use InvalidArgumentException;

final class Id
{
    private function __construct(private $id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException(
                'Id ' . $id . ' is not valid'
            );
        }
    }

    public static function create($id)
    {
        return new self($id);
    }

    public function value(): string
    {
        return $this->id;
    }

    public function equals(self $other): bool
    {
        return $this->id === $other->id;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
