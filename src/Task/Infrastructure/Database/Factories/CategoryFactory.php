<?php

namespace Freelance\Task\Infrastructure\Database\Factories;

use Freelance\Task\Domain\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
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
            'parent_id' => null,
        ];
    }


    public function name(string $name)
    {
        return $this->state(fn(array $attributes) => [
            'name' => $name,
        ]
        );
    }

    public function childOf(Category $parent)
    {
        return $this->state(fn(array $attributes) => [
            'parent_id' => $parent->id,
        ]
        );
    }


}
