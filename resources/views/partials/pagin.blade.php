@if ($paginator->hasPages())
    @if ($paginator->onFirstPage())
        <a class="pagination-previous" title="This is the first page" disabled>Previous</a>
    @else
        <a class="pagination-previous" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
    @endif

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
    @else
        <a class="pagination-next" disabled><span>Next<a>
    @endif
        
    <ul class="pagination-list">
        {{-- Previous Page Link --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><span class="pagination-ellipsis">&hellip;</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li ><a class="pagination-link is-current"> {{ $page }}</a></li>
                    @else
                        <li><a class="pagination-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
    </ul>
@endif
