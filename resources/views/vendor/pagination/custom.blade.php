@if ($paginator->hasPages())
    <nav class="flex justify-center items-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled class="size-10 flex items-center justify-center rounded-lg border border-[#e5e7eb] bg-white text-[#111418] opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-sm">chevron_left</span>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="size-10 flex items-center justify-center rounded-lg border border-[#e5e7eb] bg-white text-[#111418] hover:bg-gray-50">
                <span class="material-symbols-outlined text-sm">chevron_left</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="size-10 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-sm">
                            {{ $page }}
                        </button>
                    @else
                        <a href="{{ $url }}" class="size-10 flex items-center justify-center rounded-lg border border-[#e5e7eb] bg-white text-[#111418] hover:bg-gray-50 font-medium text-sm">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="size-10 flex items-center justify-center rounded-lg border border-[#e5e7eb] bg-white text-[#111418] hover:bg-gray-50">
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </a>
        @else
            <button disabled class="size-10 flex items-center justify-center rounded-lg border border-[#e5e7eb] bg-white text-[#111418] opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </button>
        @endif
    </nav>
@endif