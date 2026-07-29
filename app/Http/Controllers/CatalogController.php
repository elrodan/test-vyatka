<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $breadcrumbs = [
            ['title' => 'Главная', 'url' => route('home')],
            ['title' => 'Каталог', 'url' => route('catalog')],
        ];
        return view('catalog', compact('categories', 'breadcrumbs'));
    }

    public function show(Category $category)
    {
        $query = $category->products();

        if (request('attributes')) {
            $attributeIds = (array) request('attributes');
            $query->whereHas('attributes', function ($q) use ($attributeIds) {
                $q->whereIn('attributes.id', $attributeIds);
            });
        }

        if (request('price_from')) {
            $query->where('price', '>=', request('price_from'));
        }

        if (request('price_to')) {
            $query->where('price', '<=', request('price_to'));
        }

        $sortBy = request('sort', 'default');
        if ($sortBy === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sortBy === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sortBy === 'name') {
            $query->orderBy('name', 'asc');
        }

        $perPage = request('per_page', 12);
        $products = $query->paginate($perPage);

        $allAttributes = $category->products()->with('attributes')->get()
            ->pluck('attributes')->flatten()->unique('id');

        $filterGroups = [];
        $filterTypes = [];
        $attributesArray = $allAttributes->values()->all();

        $filterGroups[] = array_slice($attributesArray, 0, 8);
        $filterTypes[] = 'checkbox';

        if (count($attributesArray) > 8) {
            $filterGroups[] = array_slice($attributesArray, 8, 8);
            $filterTypes[] = 'radio';
        }

        while (count($filterGroups) < 5) {
            $filterGroups[] = [];
            $filterTypes[] = 'checkbox';
        }

        $breadcrumbs = [
            ['title' => 'Главная', 'url' => route('home')],
            ['title' => 'Каталог', 'url' => route('catalog')],
            ['title' => $category->name, 'url' => route('category', $category->slug)],
        ];

        return view('category', compact(
            'category', 'products', 'filterGroups', 'filterTypes', 'breadcrumbs'
        ));
    }
}