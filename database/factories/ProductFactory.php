<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'name' => 'Название товара',
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraphs(3, true),
            'price' => 1000,
            'old_price' => 1600,
            'is_new' => true,
        ];
    }
}