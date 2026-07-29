<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest('published_at')->paginate(12);
        $breadcrumbs = [
            ['title' => 'Главная', 'url' => route('home')],
            ['title' => 'Блог', 'url' => route('news')],
        ];
        return view('news', compact('news', 'breadcrumbs'));
    }

    public function show(News $news)
    {
        $breadcrumbs = [
            ['title' => 'Главная', 'url' => route('home')],
            ['title' => 'Блог', 'url' => route('news')],
            ['title' => $news->title, 'url' => route('news.show', $news->slug)],
        ];
        return view('news.show', compact('news', 'breadcrumbs'));
    }
}