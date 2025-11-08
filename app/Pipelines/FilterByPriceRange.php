<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByPriceRange
{
    public function handle(Builder $query, Closure $next)
    {
        $min = request('min_price');
        $max = request('max_price');

        if ($min !== null) { $query->where('price', '>=', $min); }
        if ($max !== null) { $query->where('price', '<=', $max); }

        return $next($query);
    }
}
