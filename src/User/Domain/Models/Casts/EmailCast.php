<?php

namespace Freelance\User\Domain\Models\Casts;

use Freelance\User\Domain\ValueObjects\Email;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

final class EmailCast implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        return Email::create($attributes['email']);
    }

    public function set($model, $key, $value, $attributes)
    {
        if (!$value instanceof Email) {
            $value = Email::create($value);
        }

        return [
            'email' => $value->value(),
        ];
    }
}
