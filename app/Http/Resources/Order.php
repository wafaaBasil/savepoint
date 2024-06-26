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
            'customer_id' => $this->customer->id,
            'customer_name' => $this->customer->name,
            'customer_device_token' => $this->customer->device_token,
            'customer_phonenumber' => $this->customer->phonenumber,
            'customer_address' => $this->customer->address,
            'provider_id' => $this->provider->id,
            'provider_name' => $this->provider->name,
            'provider_device_token' => $this->provider->device_token,
            'delivery_id' => $this->delivery->id,
            'delivery_name' => $this->delivery->name,
            'delivery_phonenumber' => $this->delivery->phonenumber,
            'delivery_device_token' => $this->delivery->device_token,
            'order_price' => $this->order_price,
            'delivery_price' => $this->delivery_price,
            'is_accept_offer_price' => 'true',   /////////////update
            //'distance_from_store' => $this->distance_from_store,   /////////////update
            'payment_method' =>  new PaymentMethod($this->payment_method),   /////////////update
            //'customer_rating_driver' =>  $this->customer_rating_driver,   /////////////update
            //'driver_rating_customer' =>  $this->driver_rating_customer,   /////////////update
            //'product' =>  $this->product,   /////////////update
            'total' => $this->total,
            'status' => $this->status,
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
        ];
    }
}
