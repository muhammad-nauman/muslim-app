<?php


namespace App\Classes;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class PopularSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $query->withCount('devices')
            ->orderByRaw("devices_count DESC");
    }
}
