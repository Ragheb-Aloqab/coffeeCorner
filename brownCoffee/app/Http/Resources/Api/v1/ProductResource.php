<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'name' => $this->name_ar,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'desc' => $this->description,
            'price' => (float) $this->price,
            'image' => $this->image_url,
            'icon' => $this->icon,
            'rating' => (float) $this->rating,
            'reviews' => (int) $this->reviews_count,
            'hasMatchaAddon' => (bool) $this->has_matcha_addon,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
