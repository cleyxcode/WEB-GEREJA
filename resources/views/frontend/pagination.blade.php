@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-2">
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <button disabled class="flex items-center justify-center size-10 rounded-lg border border-[#f0f2f5] bg-white text-[#60708a] opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center size-10 rounded-lg border border-[#f0f2f5] bg-white text-[#60708a] hover:border-primary hover:text-primary transition-all">
                <span class="material-symbols-outlined">chevron_left</span>
            </a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="flex items-center justify-center size-10 rounded-lg bg-primary text-white font-semibold shadow-md shadow-blue-200">
                            {{ $page }}
                        </button>
                    @else
                        <a href="{{ $url }}" class="flex items-center justify-center size-10 rounded-lg border border-[#f0f2f5] bg-white text-[#60708a] hover:bg-[#f5f7f8] hover:text-[#111418] transition-all font-medium">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center size-10 rounded-lg border border-[#f0f2f5] bg-white text-[#60708a] hover:border-primary hover:text-primary transition-all">
                <span class="material-symbols-outlined">chevron_right</span>
            </a>
        @else
            <button disabled class="flex items-center justify-center size-10 rounded-lg border border-[#f0f2f5] bg-white text-[#60708a] opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        @endif
    </nav>
@endif