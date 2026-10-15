@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Paginasi" class="pagination-wrapper" style="display:flex; justify-content:space-between; align-items:center; gap:16px; padding:14px 20px; border-top:1px solid #e5e7eb; flex-wrap:wrap; margin:0; list-style:none;">

        {{-- Info Text - Left Side --}}
        <div class="pagination-info" style="font-size:13px; color:#718784; white-space:nowrap; flex-shrink:0;">
            Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </div>

        {{-- Buttons Container - Right Side --}}
        <div class="pagination-buttons" style="display:flex; flex-direction:row; flex-wrap:nowrap; gap:6px; list-style:none; margin:0; padding:0;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button type="button" disabled aria-disabled="true" aria-label="Sebelumnya" class="pagination-btn pagination-btn--disabled" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d1d5db; border-radius:8px; background:#f9fafb; color:#9ca3af; cursor:not-allowed; transition:all 0.15s ease; opacity:0.5;">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="width:16px; height:16px;">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya" class="pagination-btn" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#374151; text-decoration:none; transition:all 0.15s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.borderColor='#9ca3af';" onmouseout="this.style.background='#fff'; this.style.borderColor='#d1d5db';">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="width:16px; height:16px;">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="pagination-ellipsis" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; color:#9ca3af; font-size:0.875rem; padding:0 4px; border:1px solid transparent; border-radius:8px; background:transparent;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="pagination-btn pagination-btn--active pagination-page-link" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #078577; border-radius:8px; background:#078577; color:#fff; font-weight:600; font-size:0.875rem;">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-btn pagination-page-link" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#374151; text-decoration:none; font-size:0.875rem; transition:all 0.15s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.borderColor='#9ca3af';" onmouseout="this.style.background='#fff'; this.style.borderColor='#d1d5db';" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya" class="pagination-btn" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#374151; text-decoration:none; transition:all 0.15s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.borderColor='#9ca3af';" onmouseout="this.style.background='#fff'; this.style.borderColor='#d1d5db';">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="width:16px; height:16px;">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4-4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <button type="button" disabled aria-disabled="true" aria-label="Berikutnya" class="pagination-btn pagination-btn--disabled" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d1d5db; border-radius:8px; background:#f9fafb; color:#9ca3af; cursor:not-allowed; transition:all 0.15s ease; opacity:0.5;">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="width:16px; height:16px;">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4-4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            @endif
        </div>

    </nav>
@endif

{{-- Mobile Responsive CSS --}}
<style>
@media (max-width: 640px) {
    .pagination-wrapper {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 12px !important;
    }
    .pagination-info {
        text-align: center;
    }
    .pagination-buttons {
        justify-content: center !important;
    }
    .pagination-page-link {
        display: none !important;
    }
    .pagination-btn--active.pagination-page-link {
        display: inline-flex !important;
    }
}
</style>