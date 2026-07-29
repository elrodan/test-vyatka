<nav class="text-sm text-gray-500 mb-6">
    <div class="flex items-center gap-2 flex-wrap">
        @foreach($breadcrumbs as $index => $crumb)
            @if($index > 0)
                <span class="text-gray-300">•</span>
            @endif
            @if($loop->last)
                <span class="text-gray-900 font-medium">{{ $crumb['title'] }}</span>
            @else
                <a href="{{ $crumb['url'] }}" class="hover:text-gray-700">{{ $crumb['title'] }}</a>
            @endif
        @endforeach
    </div>
</nav>