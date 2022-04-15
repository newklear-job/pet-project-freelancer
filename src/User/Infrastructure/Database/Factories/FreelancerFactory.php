<?php

namespace Freelance\User\Infrastructure\Database\Factories;

use Freelance\User\Domain\Models\User;
use Freelance\User\Domain\ValueObjects\Money;
use Illuminate\Database\Eloquent\Factories\Factory;


class FreelancerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'   => User::factory(),
            'hour_rate' => Money::create($this->faker->numberBetween(1, 100000)),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */

    public function hourRate(Money $hourRate)
    {
        return $this->state(fn(array $attributes) => [
            'hour_rate' => $hourRate,
        ]
        );
    }
}
