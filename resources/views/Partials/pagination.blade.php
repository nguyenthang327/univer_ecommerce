@php
    $currentPage = $paginator->currentPage();
    $perPage = $paginator->perPage();
    $total = $paginator->total();
@endphp
@if($total > 0)
<span>{{ trans('language.display'). ' ' . (($currentPage-1)*$perPage+1) . '-' . ($currentPage*$perPage >= $total? $total : $currentPage*$perPage) . '/' . $total }}</span>
@endif
@if ($paginator->hasPages())
    <ul class="pagination justify-content-end m-0">
        {{--Previous Page Link--}}
        @if ($paginator->onFirstPage())
            {{--<li class="disabled page-item"><span class="page-link">«</span></li>--}}
        @else
            <li class="page-item d-none d-sm-block">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" data-page="{{$paginator->currentPage() - 1}}">«</a>
            </li>
        @endif

        @if($paginator->currentPage() > 3)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}" data-page="1">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="page-item"><span class="page-link px-1">...</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="active page-item"><span class="page-link">{{ $i }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}" data-page="{{ $i }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item"><span class="page-link px-1">...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" data-page="{{ $paginator->lastPage() }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{--Next Page Link--}}
        @if ($paginator->hasMorePages())
            <li class="page-item d-none d-sm-block">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" data-page="{{$paginator->currentPage() + 1}}">»</a>
            </li>
        @else
            {{--<li class="disabled page-item"><span class="page-link">»</span></li>--}}
        @endif
    </ul>
@endif
