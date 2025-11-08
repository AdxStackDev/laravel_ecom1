<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;

class ProductService
{
    public function __construct(private ProductRepositoryInterface $products) {}

    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $product = $this->products->create($data);
            // dispatch domain events or queue downstream jobs as needed
            return $product;
        });
    }

    public function update(Product $product, array $data): Product
    {
        return DB::transaction(fn() => $this->products->update($product, $data));
    }

    public function delete(Product $product): void
    {
        DB::transaction(fn() => $this->products->delete($product));
    }
}
