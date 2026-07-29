<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Категория ' . fake()->unique()->numberBetween(1, 100),
            'slug' => fake()->unique()->slug(),
        ];
    }
}