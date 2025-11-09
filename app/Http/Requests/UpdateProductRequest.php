<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->user()->is_admin()) {
            return true;
        }

        $product = $this->route('product');
        return $product && $this->user()?->can('update', $product);
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;
        return [
            'category_id' => ['sometimes','integer','exists:categories,id'],
            'name' => ['sometimes','string','max:255'],
            'slug' => ['sometimes','string','max:255',"unique:products,slug,{$productId}"],
            'description' => ['nullable','string'],
            'price' => ['sometimes','numeric','min:0'],
            'stock' => ['sometimes','integer','min:0'],
            'metadata' => ['nullable','array'],
            'tag_ids' => ['sometimes','array'],
            'tag_ids.*' => ['integer','exists:tags,id'],
        ];
    }
}

