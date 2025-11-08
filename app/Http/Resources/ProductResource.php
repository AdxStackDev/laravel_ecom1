<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'slug'      => $this->slug,
            'price'     => $this->price,
            'stock'     => $this->whenNotNull($this->stock),
            'owner'     => new UserResource($this->whenLoaded('user')),
            'category'  => new CategoryResource($this->whenLoaded('category')),
            'tags'      => TagResource::collection($this->whenLoaded('tags')),
            'meta'      => $this->whenHas('metadata'),
            'created_at'=> $this->created_at,
        ];
    }
}

