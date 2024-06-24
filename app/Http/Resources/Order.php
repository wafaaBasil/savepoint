<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        Carbon::setLocale('ar');
        
        return [
            'id' => $this->id,
            'customer_name' => $this->customer->name,
            'customer_address' => $this->customer->address,
            'provider_name' => $this->provider->name,
            'delivery_name' => $this->delivery->name,
            'order_price' => $this->order_price,
            'delivery_price' => $this->delivery_price,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
        ];
    }
}
