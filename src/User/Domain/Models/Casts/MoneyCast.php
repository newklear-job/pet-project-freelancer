<?php

namespace Freelance\User\Domain\Models\Casts;

use Freelance\User\Domain\ValueObjects\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

final class MoneyCast implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        return Money::create($attributes[$key]);
    }

    public function set($model, $key, $value, $attributes)
    {
        if (!$value instanceof Money) {
            $value = Money::create($value);
        }

        return [
            $key => $value->value(),
        ];
    }
}
