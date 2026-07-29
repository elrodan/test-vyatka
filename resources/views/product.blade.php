@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8" x-data="productPage()">
            <!-- Хлебные крошки -->
            <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Галерея изображений -->
                <div class="relative">
                    <div class="bg-gray-100 rounded-2xl h-[600px] relative overflow-hidden">
                        <!-- Основное изображение -->
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                            <span class="text-lg">Нет фото</span>
                        </div>

                        <!-- Стрелки навигации -->
                        <button @click="prevImage" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button @click="nextImage" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <!-- Точки навигации -->
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                            <template x-for="i in 5">
                                <button @click="currentImage = i"
                                        class="w-2 h-2 rounded-full transition"
                                        :class="currentImage === i ? 'bg-black' : 'bg-gray-300'"></button>
                            </template>
                        </div>
                    </div>

                    <!-- Бейджи -->
                    @if($product->is_new)
                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="bg-black text-white text-xs font-bold px-2 py-1 rounded">NEW</span>
                        </div>
                    @endif
                </div>

                <!-- Информация о товаре -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <!-- Артикул и наличие -->
                    <div class="flex items-center gap-4 mb-2">
                        <span class="text-sm text-gray-500">Арт: {{ strtoupper(substr($product->slug, 0, 8)) }}</span>
                        <span class="text-sm text-green-600">• В наличии</span>
                    </div>

                    <h1 class="text-3xl font-bold mb-3">{{ $product->name }}</h1>

                    <!-- Краткое описание -->
                    <p class="text-gray-600 text-sm mb-6 line-clamp-3">
                        {{ $product->description }}
                    </p>

                    <!-- Характеристики (таблица) -->
                    @if($product->attributes->count())
                        <div class="mb-6">
                            <table class="w-full text-sm">
                                <tbody>
                                @foreach($product->attributes->take(4) as $attribute)
                                    <tr class="border-b border-gray-100">
                                        <td class="py-3 text-gray-500">Характеристика</td>
                                        <td class="py-3 text-right font-medium">Значение</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Селект свойства -->
                    <div class="mb-6" x-data="{ open: false, selected: 'Темно-серый' }">
                        <div class="relative">
                            <button @click="open = !open"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-4 text-left hover:border-gray-400 transition relative">
                                <div class="text-xs text-gray-500 mb-1">Свойство</div>
                                <div class="text-base font-medium" x-text="selected"></div>
                                <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 transition-transform"
                                     :class="open ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-cloak @click.away="open = false" x-transition
                                 class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg py-2 z-50">
                                <button @click="selected = 'Темно-серый'; open = false"
                                        class="w-full text-left px-4 py-3 hover:bg-gray-50 transition"
                                        :class="selected === 'Темно-серый' ? 'font-medium' : ''">
                                    Темно-серый
                                </button>
                                <button @click="selected = 'Светло-серый'; open = false"
                                        class="w-full text-left px-4 py-3 hover:bg-gray-50 transition"
                                        :class="selected === 'Светло-серый' ? 'font-medium' : ''">
                                    Светло-серый
                                </button>
                                <button @click="selected = 'Белый'; open = false"
                                        class="w-full text-left px-4 py-3 hover:bg-gray-50 transition"
                                        :class="selected === 'Белый' ? 'font-medium' : ''">
                                    Белый
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Цена и кнопки -->
                    <div class="mb-6">
                        <div class="flex items-baseline gap-3 mb-4">
                            <span class="text-4xl font-bold">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                            @if($product->old_price)
                                <span class="text-xl text-gray-400 line-through">{{ number_format($product->old_price, 0, '.', ' ') }} ₽</span>
                            @endif
                        </div>

                        <div class="flex gap-3 mb-4">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button @click="quantity = Math.max(1, quantity - 1)"
                                        class="px-4 py-3 hover:bg-gray-50 transition text-xl">−</button>
                                <span class="px-4 py-3 font-medium" x-text="quantity"></span>
                                <button @click="quantity++"
                                        class="px-4 py-3 hover:bg-gray-50 transition text-xl">+</button>
                            </div>
                            <button class="flex-1 bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                                </svg>
                                В корзину
                            </button>
                        </div>

                        <button @click="showModal = true"
                                class="w-full border-2 border-gray-300 text-gray-900 px-6 py-3 rounded-lg hover:border-black transition">
                            Купить в 1 клик
                        </button>
                    </div>
                </div>
            </div>

            <!-- Табы -->
            <div class="mb-12">
                <div class="border-b border-gray-200 mb-8">
                    <div class="flex gap-8">
                        <button @click="activeTab = 'description'"
                                class="pb-4 text-sm font-medium transition relative"
                                :class="activeTab === 'description' ? 'text-black' : 'text-gray-500 hover:text-gray-700'">
                            ОПИСАНИЕ
                            <span x-show="activeTab === 'description'"
                                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-black"></span>
                        </button>
                        <button @click="activeTab = 'characteristics'"
                                class="pb-4 text-sm font-medium transition relative"
                                :class="activeTab === 'characteristics' ? 'text-black' : 'text-gray-500 hover:text-gray-700'">
                            ХАРАКТЕРИСТИКИ
                            <span x-show="activeTab === 'characteristics'"
                                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-black"></span>
                        </button>
                        <button @click="activeTab = 'documents'"
                                class="pb-4 text-sm font-medium transition relative"
                                :class="activeTab === 'documents' ? 'text-black' : 'text-gray-500 hover:text-gray-700'">
                            ДОКУМЕНТЫ
                            <span x-show="activeTab === 'documents'"
                                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-black"></span>
                        </button>
                        <button @click="activeTab = 'delivery'"
                                class="pb-4 text-sm font-medium transition relative"
                                :class="activeTab === 'delivery' ? 'text-black' : 'text-gray-500 hover:text-gray-700'">
                            ОПЛАТА И ДОСТАВКА
                            <span x-show="activeTab === 'delivery'"
                                  class="absolute bottom-0 left-0 right-0 h-0.5 bg-black"></span>
                        </button>
                    </div>
                </div>

                <div x-show="activeTab === 'description'" x-transition>
                    <div class="prose max-w-none text-gray-700 leading-relaxed space-y-4">
                        <p>{{ $product->description }}</p>
                    </div>
                </div>

                <div x-show="activeTab === 'characteristics'" x-transition>
                    <table class="w-full text-sm">
                        <tbody>
                        @foreach($product->attributes as $attribute)
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500">{{ $attribute->name }}</td>
                                <td class="py-3 font-medium">Значение</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div x-show="activeTab === 'documents'" x-transition>
                    <p class="text-gray-500">Документы пока не добавлены</p>
                </div>

                <div x-show="activeTab === 'delivery'" x-transition>
                    <p class="text-gray-700">Информация об оплате и доставке будет здесь</p>
                </div>
            </div>

            <!-- Похожие товары с каруселью -->
            @if($similarProducts->count())
                <section class="mb-12" x-data="similarCarousel()">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-3xl font-bold">Похожие товары</h2>
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
                                            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
                                                <a :href="`/product/${product.slug}`" class="block">
                                                    <div class="bg-gray-100 h-52 mb-4 relative rounded-xl">
                                                        <span x-show="product.is_new" class="absolute top-3 left-3 bg-black text-white text-[10px] font-bold px-2 py-1 rounded">NEW</span>
                                                        <div class="flex items-center justify-center h-full text-gray-400">
                                                            Нет фото
                                                        </div>
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
                </section>
            @endif

            <!-- Модальное окно "Купить в 1 клик" -->
            <div x-show="showModal"
                 x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                 @click.self="showModal = false">

                <div class="bg-white rounded-2xl max-w-md w-full p-8 relative" @click.stop>
                    <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 border border-gray-200 rounded-lg p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <h3 class="text-3xl font-bold mb-2 text-center">Оставьте заявку</h3>
                    <p class="text-gray-600 mb-8 text-center">Мы свяжемся с Вами в ближайшее время</p>

                    <form @submit.prevent="submitForm" class="space-y-4">
                        <div>
                            <input type="text" x-model="form.name" placeholder="Ваше имя" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-black focus:border-transparent">
                        </div>

                        <div>
                            <input type="tel" x-model="form.phone" placeholder="Телефон" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-black focus:border-transparent">
                        </div>

                        <div>
                        <textarea x-model="form.message" placeholder="Сообщение" rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-black focus:border-transparent"></textarea>
                        </div>

                        <label class="flex items-start gap-2 cursor-pointer">
                            <input type="checkbox" required class="mt-1 w-4 h-4 text-black rounded border-gray-300 focus:ring-black">
                            <span class="text-sm text-gray-600">Даю согласие на обработку персональных данных</span>
                        </label>

                        <button type="submit"
                                class="w-full bg-black text-white py-4 rounded-lg hover:bg-gray-800 transition font-medium">
                            Отправить
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function similarCarousel() {
            return {
                currentIndex: 0,
                itemsPerSlide: 4,

                get chunks() {
                    const items = @json($similarProducts);
                    const chunks = [];
                    for (let i = 0; i < items.length; i += this.itemsPerSlide) {
                        chunks.push(items.slice(i, i + this.itemsPerSlide));
                    }
                    return chunks;
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

    <script>
        function productPage() {
            return {
                currentImage: 1,
                activeTab: 'description',
                quantity: 1,
                showModal: false,
                form: {
                    name: '',
                    phone: '',
                    message: ''
                },

                prevImage() {
                    this.currentImage = this.currentImage > 1 ? this.currentImage - 1 : 5;
                },

                nextImage() {
                    this.currentImage = this.currentImage < 5 ? this.currentImage + 1 : 1;
                },

                submitForm() {
                    alert('Заявка отправлена! Мы свяжемся с вами.');
                    this.showModal = false;
                    this.form = { name: '', phone: '', message: '' };
                }
            }
        }
    </script>
@endsection