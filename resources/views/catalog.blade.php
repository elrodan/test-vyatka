@extends('layouts.app')

@section('title', 'Каталог')

@section('content')
    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Хлебные крошки -->
            <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

            <h1 class="text-4xl font-bold mb-8 text-gray-900">Каталог</h1>

            @if($categories->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($categories as $category)
                        <a href="{{ route('category', $category->slug) }}" class="bg-gray-100 rounded-2xl overflow-hidden hover:shadow-lg transition flex h-56 group">
                            <div class="w-1/2 p-6 flex flex-col justify-between bg-gray-100">
                                <div>
                                    <h3 class="font-bold text-2xl mb-2">{{ $category->name }}</h3>
                                    <p class="text-gray-500 text-sm">Описание категории ({{ $category->products_count }} товаров)</p>
                                </div>
                                <span class="text-blue-600 text-sm font-medium flex items-center gap-2">
                                Перейти
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </span>
                            </div>
                            <div class="w-1/2 bg-gray-200"></div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-12 bg-white rounded-2xl border">Категории пока не добавлены</p>
            @endif
        </div>
    </div>
@endsection