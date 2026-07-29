@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Хлебные крошки -->
            <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

            <article class="py-4">
                <!-- Заголовок -->
                <h1 class="text-5xl md:text-6xl font-bold mb-6 text-gray-900 leading-tight">
                    {{ $news->title }}
                </h1>
                <!-- Вступительный абзац (Lead) -->
                @if($news->excerpt)
                    <p class="text-xl text-gray-700 leading-relaxed mb-8 max-w-7xl">
                        {{ $news->excerpt }}
                    </p>
                @endif

                <!-- Основной контент -->
                <div class="text-gray-700 leading-relaxed space-y-6 text-lg max-w-7xl">
                    {!! $news->content !!}
                </div>
            </article>
        </div>
    </div>
@endsection