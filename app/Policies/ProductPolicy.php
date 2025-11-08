<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_admin ? true : null;
    }

    public function viewAny(User $user): bool { return true; }

    public function view(User $user, Product $product): bool { return true; }

    public function create(User $user): bool { return $user->is_admin || $user->is_seller; }

    public function update(User $user, Product $product): Response
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny('Not owner of product.');
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }
}

