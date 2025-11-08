<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByCategory
{
    public function handle(Builder $query, Closure $next)
    {
        if ($cat = request('category_id')) {
            $query->where('category_id', $cat);
        }
        return $next($query);
    }
}
