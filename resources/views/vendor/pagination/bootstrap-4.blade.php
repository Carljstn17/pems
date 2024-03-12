<style>
    .pagination-custom .page-link {
        color: #343a40; /* Dark text color */
        background-color: #fff; /* White background color */
        border: 1px solid #dee2e6; /* Border color */
    }
    
    .pagination-custom .page-link:hover {
        background-color: #f8f9fa; /* Hover background color */
    }
    
    .pagination-custom .page-item.active .page-link {
        color: #fff; /* White text color */
        background-color: #343a40; /* Dark background color */
        border-color: #343a40; /* Border color */
    }
    
    .pagination-custom .page-item.disabled .page-link {
        color: #6c757d; /* Disabled text color */
        pointer-events: none; /* Disable click events */
    }

</style>

@if ($paginator->hasPages())
    <nav>
        <ul class="pagination pagination-custom">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
