<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'productId' => $this->product_id,
            'name' => $this->product_name,
            'unitPrice' => (float) $this->unit_price,
            'qty' => (int) $this->quantity,
            'addonDetails' => $this->addon_details,
            'lineTotal' => (float) $this->line_total,
        ];
    }
}
