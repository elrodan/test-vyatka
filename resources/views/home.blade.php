@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="min-h-screen">

        <!-- Hero Block -->
        <section class="bg-gray-100 py-20 mb-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="max-w-3xl">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 text-gray-900 leading-tight">Строим тёплые деревянные дома</h1>
                    <p class="text-gray-900 mb-10 text-xl leading-relaxed">Учитывая ключевые сценарии поведения, существующая теория в значительной степени обусловливает важность дальнейших направлений развития.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                        <div class="flex flex-col items-start gap-3">
                            <svg class="w-8 h-8 text-gray-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="9" stroke-dasharray="4 3"/>
                            </svg>
                            <span class="text-base text-gray-900 leading-snug">Построим дом по вашему дизайн-проекту</span>
                        </div>
                        <div class="flex flex-col items-start gap-3">
                            <svg class="w-8 h-8 text-gray-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="9" stroke-dasharray="4 3"/>
                            </svg>
                            <span class="text-base text-gray-900 leading-snug">Уникальный дизайн с удобной планировкой</span>
                        </div>
                        <div class="flex flex-col items-start gap-3">
                            <svg class="w-8 h-8 text-gray-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="9" stroke-dasharray="4 3"/>
                            </svg>
                            <span class="text-base text-gray-900 leading-snug">Подберем мебель и подключим технику</span>
                        </div>
                    </div>

                    <button class="bg-black text-white px-8 py-4 rounded-xl hover:bg-gray-800 transition font-medium text-base">Подробнее</button>
                </div>
            </div>
        </section>

        <!-- Товары -->
        @if($newProducts->count())
            <section class="mb-12" x-data="carousel(4)">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-bold">Товары</h2>
                        <div class="flex gap-2">
                            <button @click="prev" class="border border-gray-300 rounded-lg p-2 hover:bg-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button @click="next" class="border border-gray-300 rounded-lg p-2 hover:bg-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentIndex * 100}%)`">
                            <template x-for="(chunk, index) in chunks" :key="index">
                                <div class="w-full flex-shrink-0 px-2">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                        <template x-for="product in chunk" :key="product.id">
                                            <!-- Карточка товара -->
                                            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">

                                                <!-- Кликабельная верхняя часть -->
                                                <a :href="`/product/${product.slug}`" class="block">
                                                    <div class="bg-gray-100 h-52 mb-4 relative rounded-xl">
                                                        <span x-show="product.is_new" class="absolute top-3 left-3 bg-black text-white text-[10px] font-bold px-2 py-1 rounded">NEW</span>
                                                        <div class="flex items-center justify-center h-full text-gray-400">Нет фото</div>
                                                    </div>
                                                    <div class="text-green-600 text-sm mb-2">В наличии</div>
                                                    <h3 class="font-medium mb-1 text-base" x-text="product.name"></h3>
                                                    <div class="mb-5">
                                                        <span class="font-bold text-2xl" x-text="formatPrice(product.price) + ' ₽'"></span>
                                                        <template x-if="product.old_price">
                                                            <span class="text-gray-400 text-base line-through ml-2" x-text="formatPrice(product.old_price) + ' ₽'"></span>
                                                        </template>
                                                    </div>
                                                </a>

                                                <!-- Интерактивная нижняя часть (вне ссылки) -->
                                                <div class="flex gap-2">
                                                    <div class="flex items-center gap-4 bg-gray-100 rounded-xl px-4 py-3 flex-1 justify-between" x-data="{ qty: 1 }">
                                                        <button @click="qty = Math.max(1, qty - 1)" class="text-gray-600 hover:text-black text-xl select-none">−</button>
                                                        <span class="text-base font-medium" x-text="qty"></span>
                                                        <button @click="qty++" class="text-gray-600 hover:text-black text-xl select-none">+</button>
                                                    </div>
                                                    <button class="bg-black text-white px-5 py-3 rounded-xl hover:bg-gray-800 transition flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                                                        </svg>
                                                        <span class="text-base font-medium">В корзину</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Каталог -->
        <section class="mb-12">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold mb-8">Каталог</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($categories as $category)
                        <a href="{{ route('category', $category->slug) }}" class="bg-gray-100 rounded-2xl overflow-hidden hover:shadow-lg transition flex h-56 group">
                            <div class="w-1/2 p-6 flex flex-col justify-between bg-gray-100">
                                <div>
                                    <h3 class="font-bold text-2xl mb-2">{{ $category->name }}</h3>
                                    <p class="text-gray-500 text-sm">Описание категории</p>
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
            </div>
        </section>

        <!-- Новости -->
        <section class="mb-16" x-data="carousel(3)">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold">Новости</h2>
                    <div class="flex gap-2">
                        <button @click="prev" class="border border-gray-300 rounded-lg p-2 hover:bg-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button @click="next" class="border border-gray-300 rounded-lg p-2 hover:bg-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentIndex * 100}%)`">
                        <template x-for="(chunk, index) in chunks" :key="index">
                            <div class="w-full flex-shrink-0 px-2">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <template x-for="news in chunk" :key="news.id">
                                        <a :href="`/news/${news.slug}`" class="relative h-96 rounded-2xl overflow-hidden group block">
                                            <div class="absolute inset-0 bg-gray-200"></div>
                                            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.7) 25%, rgba(0,0,0,0.3) 45%, transparent 65%);"></div>
                                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                                <h3 class="font-bold text-lg mb-3" x-text="news.title"></h3>
                                                <p class="text-sm text-gray-200 leading-relaxed" x-text="news.excerpt"></p>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <a href="{{ route('news') }}" class="block w-full bg-gray-100 text-center py-4 rounded-xl hover:bg-gray-200 transition font-medium mt-6">
                    Все новости
                </a>
            </div>
        </section>

    </div>

    <script>
        function carousel(itemsPerSlide) {
            return {
                currentIndex: 0,
                itemsPerSlide: itemsPerSlide,

                get chunks() {
                    const items = this.$data.items || [];
                    const chunks = [];
                    for (let i = 0; i < items.length; i += this.itemsPerSlide) {
                        chunks.push(items.slice(i, i + this.itemsPerSlide));
                    }
                    return chunks;
                },

                init() {
                    // Получаем данные из PHP
                    const data = this.$el.getAttribute('x-data').includes('carousel(4)')
                        ? @json($newProducts)
                        : @json($latestNews);
                    this.$data.items = data;
                },

                next() {
                    if (this.currentIndex < this.chunks.length - 1) {
                        this.currentIndex++;
                    } else {
                        this.currentIndex = 0;
                    }
                },

                prev() {
                    if (this.currentIndex > 0) {
                        this.currentIndex--;
                    } else {
                        this.currentIndex = this.chunks.length - 1;
                    }
                },

                formatPrice(price) {
                    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                }
            }
        }
    </script>
@endsection