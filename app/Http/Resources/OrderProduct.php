<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product->id,
            'product_image' => $this->product->images()->where('main',1)->first() ? $this->product->images()->where('main',1)->first()->image :null,
            'product_name' => $this->product->name,
            'product_name_ar' => $this->product->name_ar,
            'amount' => $this->amount,
            'price' => (string)$this->price,
        ];
    }
}
