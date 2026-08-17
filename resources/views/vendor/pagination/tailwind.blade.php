<div class="flex items-center justify-between mt-4 mb-4">
    <div>
        <p class="text-sm text-gray-500 font-medium">
            Página <span class="text-gray-700 font-bold">{{ $paginator->currentPage() }}</span> de <span class="text-gray-700 font-bold">{{ $paginator->lastPage() }}</span>
        </p>
    </div>
    <div class="flex items-center gap-1.5">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-200 text-gray-300 cursor-not-allowed bg-white">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-200 text-gray-500 bg-white hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="w-8 h-8 flex items-center justify-center text-gray-400 text-sm">...</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-md bg-green-600 text-white text-sm font-semibold shadow-sm">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-200 text-gray-700 bg-white hover:bg-gray-50 transition-colors text-sm font-medium">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-200 text-gray-500 bg-white hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </a>
        @else
            <span class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-200 text-gray-300 cursor-not-allowed bg-white">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </span>
        @endif
    </div>
</div>
