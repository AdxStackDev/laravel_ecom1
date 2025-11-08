<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $data): Product
    {
        $product = Product::create($data);
        if (!empty($data['tag_ids'])) {
            $product->tags()->sync($data['tag_ids']);
        }
        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        if (array_key_exists('tag_ids', $data)) {
            $product->tags()->sync($data['tag_ids'] ?? []);
        }
        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function findById(int $id): ?Product
    {
        return Product::with(['user','category','tags'])->find($id);
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::with(['user','category','tags'])->where('slug', $slug)->first();
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Product::query()->with(['user','category','tags']);
        return $query->paginate($perPage);
    }
}
