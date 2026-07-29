<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['category', 'attributes']);

        // Убрали limit - теперь получаем все похожие товары
        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->get();

        $breadcrumbs = [
            ['title' => 'Главная', 'url' => route('home')],
            ['title' => 'Каталог', 'url' => route('catalog')],
            ['title' => $product->category->name, 'url' => route('category', $product->category->slug)],
            ['title' => $product->name, 'url' => route('product', $product->slug)],
        ];

        return view('product', compact('product', 'similarProducts', 'breadcrumbs'));
    }
}