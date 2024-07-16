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
            'customer' => $this->customer,
            //'customer_name' => $this->customer->name,
            //'customer_device_token' => $this->customer->device_token,
            //'customer_phonenumber' => $this->customer->phonenumber,
            //'customer_address' => $this->customer->address,
            'provider' => $this->provider,
            //'provider_name' => $this->provider->name,
            //'provider_address' => $this->provider->address,
            //'provider_phonenumber' => $this->provider->phonenumber,
            //'provider_device_token' => $this->provider->device_token,
            'delivery' => $this->delivery,
            //'delivery_name' => $this->delivery->name,
            //'delivery_address' => $this->delivery->address,
            //'delivery_phonenumber' => $this->delivery->phonenumber,
            //'delivery_device_token' => $this->delivery->device_token,
            'order_price' => (string)$this->order_price,
            'delivery_price' => (string)$this->delivery_price,
            'coupon' => $this->coupon,  
            //'distance_from_store' => $this->distance_from_store,   /////////////update
            'payment_method' =>  new PaymentMethod($this->payment_method),   /////////////update
            //'customer_rating_driver' =>  $this->customer_rating_driver,   /////////////update
            //'driver_rating_customer' =>  $this->driver_rating_customer,   /////////////update
            'product' =>  OrderProduct::collection($this->order_products),   
            'total' => (string)$this->total,
            'status' => $this->status,
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
        ];
    }
}
