<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\News;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = Attribute::factory()->count(30)->create();

        $categories = Category::factory()->count(6)->create();

        $categories->each(function ($category) use ($attributes) {
            Product::factory()->count(20)->create([
                'category_id' => $category->id,
            ])->each(function ($product) use ($attributes) {
                $product->attributes()->attach(
                    $attributes->random(rand(2, 6))->pluck('id')->toArray()
                );
            });
        });

        News::factory()->count(30)->create();
    }
}