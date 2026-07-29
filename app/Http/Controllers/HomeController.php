<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $newProducts = Product::where('is_new', true)->get();
        $categories = Category::withCount('products')->limit(4)->get();
        $latestNews = News::latest('published_at')->get();

        $breadcrumbs = [
            ['title' => 'Главная', 'url' => route('home')],
        ];

        return view('home', compact('newProducts', 'categories', 'latestNews', 'breadcrumbs'));
    }
}