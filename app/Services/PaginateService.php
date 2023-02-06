<?php

namespace App\Services;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PaginateService{

    /**
     * config paginate page
     * @param $items
     * @param int $perPage
     * @param $page
     * @param array $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}