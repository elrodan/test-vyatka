@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8" x-data="categoryPage()">
            <!-- Хлебные крошки -->
            <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

            <h1 class="text-5xl font-bold mb-8 text-gray-900">{{ $category->name }}</h1>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar с фильтрами -->
                <aside class="w-full lg:w-1/4">
                    <!-- Цена -->
                    <div class="mb-8" x-data="priceRange()">
                        <h3 class="font-bold text-xl mb-4 flex items-center gap-2">
                            Цена, ₽
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? '' : 'rotate-180'" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4l8 14H4z"/>
                            </svg>
                        </h3>
                        <div class="flex gap-3 mb-4">
                            <input type="number" x-model.number="minPrice" @input="updateFromMin" placeholder="от"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-black focus:border-transparent">
                            <span class="text-gray-400 self-center">-</span>
                            <input type="number" x-model.number="maxPrice" @input="updateFromMax" placeholder="до"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-black focus:border-transparent">
                        </div>

                        <!-- Range slider -->
                        <div class="relative h-1 bg-gray-200 rounded-full mt-6 select-none">
                            <!-- Progress bar -->
                            <div class="absolute h-full bg-black rounded-full"
                                 :style="`left: ${minPosition}%; right: ${100 - maxPosition}%`"></div>

                            <!-- Min thumb -->
                            <div class="absolute w-4 h-4 bg-white border-2 border-black rounded-full -top-1.5 cursor-pointer shadow-sm hover:scale-110 transition-transform"
                                 :style="`left: ${minPosition}%`"
                                 @mousedown="startDrag('min')"
                                 @touchstart="startDrag('min')"></div>

                            <!-- Max thumb -->
                            <div class="absolute w-4 h-4 bg-white border-2 border-black rounded-full -top-1.5 cursor-pointer shadow-sm hover:scale-110 transition-transform"
                                 :style="`left: ${maxPosition}%`"
                                 @mousedown="startDrag('max')"
                                 @touchstart="startDrag('max')"></div>
                        </div>
                    </div>

                    <!-- Фильтры (сворачиваемые) -->
                    @foreach($filterGroups as $index => $group)
                        <div class="mb-6" x-data="{ open: {{ $index < 2 ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="font-bold text-xl mb-4 flex items-center gap-2">
                                <h3 class="font-bold text-xl">Фильтр</h3>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? '' : 'rotate-180'" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 4l8 14H4z"/>
                                </svg>
                            </button>

                            <div x-show="open" x-transition class="space-y-3">
                                @if(count($group) > 0)
                                    @foreach($group as $attribute)
                                        <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-1 rounded">
                                            @php
                                                $type = $filterTypes[$index] ?? 'checkbox';
                                                // Надежная проверка: приводим всё к строкам для сравнения
                                                $currentAttributes = array_map('strval', (array)request()->input('attributes', []));
                                                $isChecked = in_array((string)$attribute->id, $currentAttributes);
                                            @endphp

                                            @if($type === 'checkbox')
                                                <input type="checkbox" value="{{ $attribute->id }}"
                                                       @if($isChecked) checked @endif
                                                       @change="applyFilters()"
                                                       class="w-5 h-5 border-2 border-gray-300 rounded focus:ring-black focus:ring-2">
                                            @else
                                                <input type="radio" name="filter_{{ $index }}" value="{{ $attribute->id }}"
                                                       @if($isChecked) checked @endif
                                                       @change="applyFilters()"
                                                       class="w-5 h-5 border-2 border-gray-300 rounded-full focus:ring-black focus:ring-2">
                                            @endif
                                            <span class="text-base">{{ $attribute->name }}</span>
                                        </label>
                                    @endforeach

                                    @if(count($group) > 8)
                                        <button class="text-blue-600 text-sm border-b border-dashed border-blue-600">Показать все</button>
                                    @endif
                                @else
                                    <p class="text-gray-400 text-sm py-2">Нет фильтров</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </aside>

                <!-- Список товаров -->
                <div class="w-full lg:w-3/4">
                    <!-- Сортировка и количество -->
                    <div class="flex justify-between items-center mb-8">
                        <!-- Сортировка -->
                        <div class="flex items-center gap-3" x-data="{ open: false, selected: 'По умолчанию' }">
                            <span class="text-gray-500 text-base">Сортировка</span>
                            <div class="relative">
                                <button @click="open = !open" class="flex items-center gap-2 text-base font-medium">
                                    <span x-text="selected"></span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" x-cloak @click.away="open = false" x-transition
                                     class="absolute top-full left-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg py-2 min-w-[200px] z-50">
                                    <template x-for="option in [
                                    {value: 'default', label: 'По умолчанию'},
                                    {value: 'price_asc', label: 'Цена: по возрастанию'},
                                    {value: 'price_desc', label: 'Цена: по убыванию'},
                                    {value: 'name', label: 'По названию'}
                                ]" :key="option.value">
                                        <button @click="selected = option.label; sortBy = option.value; applyFilters(); open = false"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-50 text-sm"
                                                :class="sortBy === option.value ? 'font-medium' : ''"
                                                x-text="option.label"></button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Выводить товаров -->
                        <div class="flex items-center gap-3" x-data="{ open: false, selected: '12' }">
                            <span class="text-gray-500 text-base">Выводить товаров</span>
                            <div class="relative">
                                <button @click="open = !open" class="flex items-center gap-2 text-base font-medium">
                                    <span x-text="selected"></span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" x-cloak @click.away="open = false" x-transition
                                     class="absolute top-full right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg py-2 min-w-[100px] z-50">
                                    <template x-for="option in ['12', '25', '50']" :key="option">
                                        <button @click="selected = option; perPage = option; applyFilters(); open = false"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-50 text-sm"
                                                :class="perPage === option ? 'font-medium' : ''"
                                                x-text="option"></button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($products->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 mb-8">
                            @foreach($products as $product)
                                <!-- Карточка товара -->
                                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
                                    <a href="{{ route('product', $product->slug) }}" class="block">
                                        <div class="bg-gray-100 h-52 mb-4 relative rounded-xl">
                                            @if($product->is_new)
                                                <span class="absolute top-3 left-3 bg-black text-white text-[10px] font-bold px-2 py-1 rounded">NEW</span>
                                            @endif
                                            <div class="flex items-center justify-center h-full text-gray-400">
                                                Нет фото
                                            </div>
                                        </div>

                                        <div class="text-green-600 text-sm mb-2">В наличии</div>
                                        <h3 class="font-medium mb-1 text-base">{{ $product->name }}</h3>
                                        <div class="mb-5">
                                            <span class="font-bold text-2xl">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                                            @if($product->old_price)
                                                <span class="text-gray-400 text-base line-through ml-2">{{ number_format($product->old_price, 0, '.', ' ') }} ₽</span>
                                            @endif
                                        </div>
                                    </a>

                                    <!-- Кнопки вынесены за пределы ссылки -->
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
                            @endforeach
                        </div>

                        <!-- Пагинация -->
                        @if($products->hasPages())
                            <div class="flex justify-start mt-8">
                                {{ $products->links() }}
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 text-center py-12 bg-white rounded-2xl border">Товары не найдены</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function priceRange() {
            return {
                minPrice: null,
                maxPrice: null,
                minPosition: 0,
                maxPosition: 100,
                isDragging: null,
                priceMin: 0,
                priceMax: 10000,

                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const priceFrom = urlParams.get('price_from');
                    const priceTo = urlParams.get('price_to');

                    if (priceFrom) {
                        this.minPrice = parseInt(priceFrom);
                        this.minPosition = (this.minPrice / this.priceMax) * 100;
                    }
                    if (priceTo) {
                        this.maxPrice = parseInt(priceTo);
                        this.maxPosition = (this.maxPrice / this.priceMax) * 100;
                    }

                    document.addEventListener('mousemove', this.onDrag.bind(this));
                    document.addEventListener('mouseup', this.stopDrag.bind(this));
                    document.addEventListener('touchmove', this.onDrag.bind(this));
                    document.addEventListener('touchend', this.stopDrag.bind(this));
                },

                startDrag(type) {
                    this.isDragging = type;
                },

                onDrag(e) {
                    if (!this.isDragging) return;

                    const slider = document.querySelector('.relative.h-1');
                    if (!slider) return;

                    const rect = slider.getBoundingClientRect();
                    const clientX = e.touches ? e.touches[0].clientX : e.clientX;

                    let position = ((clientX - rect.left) / rect.width) * 100;
                    position = Math.max(0, Math.min(100, position));

                    if (this.isDragging === 'min') {
                        if (position > this.maxPosition) position = this.maxPosition;
                        this.minPosition = position;
                        this.minPrice = Math.round((position / 100) * this.priceMax);
                    } else {
                        if (position < this.minPosition) position = this.minPosition;
                        this.maxPosition = position;
                        this.maxPrice = Math.round((position / 100) * this.priceMax);
                    }
                },

                stopDrag() {
                    if (this.isDragging) {
                        this.isDragging = null;
                        window.dispatchEvent(new CustomEvent('price-filter-changed', {
                            detail: { from: this.minPrice, to: this.maxPrice }
                        }));
                    }
                },

                updateFromMin() {
                    if (this.minPrice !== null) {
                        this.minPosition = (this.minPrice / this.priceMax) * 100;
                        if (this.minPosition > this.maxPosition) {
                            this.maxPosition = this.minPosition;
                            this.maxPrice = this.minPrice;
                        }
                        window.dispatchEvent(new CustomEvent('price-filter-changed', {
                            detail: { from: this.minPrice, to: this.maxPrice }
                        }));
                    }
                },

                updateFromMax() {
                    if (this.maxPrice !== null) {
                        this.maxPosition = (this.maxPrice / this.priceMax) * 100;
                        if (this.maxPosition < this.minPosition) {
                            this.minPosition = this.maxPosition;
                            this.minPrice = this.maxPrice;
                        }
                        window.dispatchEvent(new CustomEvent('price-filter-changed', {
                            detail: { from: this.minPrice, to: this.maxPrice }
                        }));
                    }
                }
            }
        }
    </script>

    <script>
        function categoryPage() {
            return {
                priceFrom: '',
                priceTo: '',
                sortBy: 'default',
                perPage: '12',

                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    this.priceFrom = urlParams.get('price_from') || '';
                    this.priceTo = urlParams.get('price_to') || '';
                    this.sortBy = urlParams.get('sort') || 'default';
                    this.perPage = urlParams.get('per_page') || '12';

                    window.addEventListener('price-filter-changed', (e) => {
                        this.priceFrom = e.detail.from;
                        this.priceTo = e.detail.to;
                        this.applyFilters();
                    });
                },

                applyFilters() {
                    const params = new URLSearchParams();

                    // 1. Собираем ВСЕ отмеченные чекбоксы и радио-кнопки напрямую из DOM
                    // Это гарантирует, что мы возьмем актуальное состояние, которое уже отрисовал PHP
                    const checkedInputs = document.querySelectorAll('aside input[type="checkbox"]:checked, aside input[type="radio"]:checked');
                    const attributes = [];
                    checkedInputs.forEach(input => {
                        attributes.push(input.value);
                    });

                    // 2. Добавляем их в URL
                    attributes.forEach(attr => {
                        params.append('attributes[]', attr);
                    });

                    // 3. Добавляем остальные параметры из состояния Alpine
                    if (this.priceFrom) params.set('price_from', this.priceFrom);
                    if (this.priceTo) params.set('price_to', this.priceTo);
                    if (this.sortBy !== 'default') params.set('sort', this.sortBy);
                    if (this.perPage !== '12') params.set('per_page', this.perPage);

                    // 4. Перезагружаем страницу
                    window.location.href = window.location.pathname + '?' + params.toString();
                }
            }
        }
    </script>
@endsection