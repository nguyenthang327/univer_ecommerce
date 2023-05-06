@php
    $currentPage = $paginator->currentPage();
    $perPage = $paginator->perPage();
    $total = $paginator->total();
@endphp
@if ($paginator->hasPages())
    <ul>
        {{--Previous Page Link--}}
        @if ($paginator->onFirstPage())

        @else
            <li class="prev">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" data-page="{{$paginator->currentPage() - 1}}">
                    <i class="fas fa-long-arrow-alt-left"></i> Prev
                </a>
            </li>
        @endif

        @if($paginator->currentPage() > 3)
            <li><a href="{{ $paginator->url(1) }}" data-page="1">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li><span class="page-link px-1">...</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="active"><a href="#">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}" data-page="{{ $i }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li><span class="page-link px-1">...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}" data-page="{{ $paginator->lastPage() }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{--Next Page Link--}}
        @if ($paginator->hasMorePages())
            <li class="next">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" data-page="{{$paginator->currentPage() + 1}}">
                    Next <i class="fas fa-long-arrow-alt-right"></i>
                </a>
            </li>
        @else
        @endif
    </ul>
@endif