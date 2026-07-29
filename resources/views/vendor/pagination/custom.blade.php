@if ($paginator->hasPages())
    <nav class="flex items-center gap-2" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            {{-- На первой странице не показываем стрелку --}}
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition flex items-center" rel="prev">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-3 text-gray-400">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-3 bg-gray-200 rounded-xl font-medium">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition font-medium">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition flex items-center" rel="next">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        @endif
    </nav>
@endif