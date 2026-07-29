@extends('layouts.app')

@section('title', 'Блог')

@section('content')
    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Хлебные крошки -->
            <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

            <h1 class="text-5xl font-bold mb-8 text-gray-900">Блог</h1>

            @if($news->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    @foreach($news as $item)
                        <a href="{{ route('news.show', $item->slug) }}" class="relative h-96 rounded-2xl overflow-hidden group block">
                            <!-- Фон -->
                            <div class="absolute inset-0 bg-gray-200"></div>

                            <!-- Градиент снизу вверх, начинается с середины -->
                            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.7) 25%, rgba(0,0,0,0.3) 45%, transparent 65%);"></div>

                            <!-- Контент поверх градиента -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <h3 class="font-bold text-lg mb-2">{{ $item->title }}</h3>
                                <p class="text-sm text-gray-200 leading-relaxed">{{ $item->excerpt }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Пагинация -->
                @if($news->hasPages())
                    <div class="flex justify-start mt-8">
                        {{ $news->links() }}
                    </div>
                @endif
            @else
                <p class="text-gray-500 text-center py-12 bg-white rounded-2xl border">Новостей пока нет</p>
            @endif
        </div>
    </div>
@endsection