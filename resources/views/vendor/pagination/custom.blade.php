@if ($paginator->hasPages())
    <ul class="wg-pagination justify-content-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true">
                <span class="pagination-item text-button"><i class="icon-arrLeft"></i></span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item text-button" rel="prev">
                    <i class="icon-arrLeft"></i>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true">
                    <span class="pagination-item text-button">{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page">
                            <div class="pagination-item text-button">{{ $page }}</div>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}" class="pagination-item text-button">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item text-button" rel="next">
                    <i class="icon-arrRight"></i>
                </a>
            </li>
        @else
            <li class="disabled" aria-disabled="true">
                <span class="pagination-item text-button"><i class="icon-arrRight"></i></span>
            </li>
        @endif
    </ul>
@endif
