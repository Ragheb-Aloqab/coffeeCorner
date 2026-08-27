<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'productId' => $this->product_id,
            'label' => $this->label_ar,
            'label_ar' => $this->label_ar,
            'label_en' => $this->label_en,
            'discount' => (float) $this->discount_amount,
            'desc' => $this->description,
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
