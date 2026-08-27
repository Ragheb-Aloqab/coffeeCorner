<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'orderNumber' => $this->order_number,
            'customerName' => $this->customer_name,
            'customerPhone' => $this->customer_phone,
            'deliveryAddress' => $this->delivery_address,
            'subtotal' => (float) $this->subtotal,
            'discount' => (float) $this->discount,
            'deliveryFee' => (float) $this->delivery_fee,
            'totalAmount' => (float) $this->total_amount,
            'status' => $this->status,
            'paymentMethod' => $this->payment_method,
            'paymentStatus' => $this->payment_status,
            'notes' => $this->notes,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'createdAt' => $this->created_at?->toDateTimeString(),
        ];
    }
}
