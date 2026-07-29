<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Название компании')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .logo-stretched {
            font-family: 'Arial Black', sans-serif;
            font-weight: 900;
            letter-spacing: 0.05em;
            transform: scaleY(1.4);
            display: inline-block;
            transform-origin: center;
        }
    </style>
</head>
<body class="text-gray-800 font-sans min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-white mb-12">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-8">
            <a href="{{ route('home') }}" class="logo-stretched text-2xl">ЛОГОТИП</a>
            <nav class="hidden md:flex gap-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-gray-600">Главная</a>
                <a href="{{ route('catalog') }}" class="hover:text-gray-600">Каталог</a>
                <a href="{{ route('news') }}" class="hover:text-gray-600">Блог</a>
                <a href="#" class="hover:text-gray-600">Контакты</a>
            </nav>
        </div>
        <button class="border border-gray-300 rounded-lg p-2.5 hover:bg-gray-50 transition">
            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
            </svg>
        </button>
    </div>
    <!-- Border с отступами -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="border-b border-gray-200"></div>
    </div>
</header>

<!-- Main Content -->
<main class="flex-grow">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-gray-100 mt-12">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="logo-stretched text-2xl mb-6">ЛОГОТИП</div>
        <div class="border-t border-gray-300 pt-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 text-sm text-gray-500">
            <div class="flex flex-wrap gap-4">
                <span>© 2025, «Название компании»</span>
                <a href="#" class="hover:text-gray-700 border-b border-dashed border-gray-400">Политика конфиденциальности</a>
                <a href="#" class="hover:text-gray-700 border-b border-dashed border-gray-400">Реквизиты</a>
            </div>
            <span>Разработано в Вятка IT</span>
        </div>
    </div>
</footer>

</body>
</html>