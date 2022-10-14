@foreach ($elements as $element)
    @if(is_array($element))
        @foreach ($element as $page => $url)
            @if ($paginator->currentPage() > 4 && $page === 2)
                <span class="page-link">...</span>
            @endif

            @if ($page == $paginator->currentPage())
                <span class="active">{{ $page }}</span>
            @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2 || $page === $paginator->lastPage() || $page === 1)
                <a href="{{ $url }}">{{ $page }}</a>
            @endif

            @if ($paginator->currentPage() < $paginator->lastPage() - 3 && $page === $paginator->lastPage() - 1)
                <span class="page-link">...</span>
            @endif
        @endforeach
    @endif
@endforeach
