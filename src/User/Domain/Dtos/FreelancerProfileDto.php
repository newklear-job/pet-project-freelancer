<?php

namespace Freelance\User\Domain\Dtos;

use Freelance\User\Domain\Models\User;
use Freelance\User\Domain\ValueObjects\Id;
use Freelance\User\Domain\ValueObjects\Money;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

final class FreelancerProfileDto
{
    private function __construct(
        private Id    $userId,
        private Money $hourRate,
    ) {
    }

    public static function create($user_id, $hour_rate)
    {
        self::validate(get_defined_vars());
        return new self (
            userId  : Id::create($user_id),
            hourRate: Money::create($hour_rate),
        );
    }

    private static function validate(array $args): void
    {
        Validator::validate(
            $args, [
                     'hour_rate'     => ['required', 'numeric', 'gt:0'],
                     'user_id'    => [
                         'required',
                         Rule::exists(User::class, 'id'),
                     ],
                 ]

        );
    }

    public function getHourRate(): Money
    {
        return $this->hourRate;
    }

    public function getUserId(): Id
    {
        return $this->userId;
    }

}
