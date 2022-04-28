<?php

namespace Freelance\Task\Infrastructure\Database\Factories;

use Freelance\Task\Domain\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'      => $this->faker->name(),
            'description' => $this->faker->sentence(),
        ];
    }


    public function name(string $name)
    {
        return $this->state(fn(array $attributes) => [
            'name' => $name,
        ]
        );
    }

    public function description(string $description)
    {
        return $this->state(fn(array $attributes) => [
            'description' => $description,
        ]
        );
    }
}
