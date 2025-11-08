<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function delete(Product $product): void;
    public function findById(int $id): ?Product;
    public function findBySlug(string $slug): ?Product;
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
}
