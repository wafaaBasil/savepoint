<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Delivery extends JsonResource
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
            'name' => $this->name,
            'phonenumber' => $this->phonenumber,
            'image' => $this->image,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'vehicle_type' => $this->delivery->vehicle_type,
            'brand' => $this->delivery->brand,
            'license' => $this->delivery->license,
            'user_type' => $this->user_type,
            'last_login_at' => $this->last_login_at ? 
                Carbon::parse($this->last_login_at)->diffForHumans() :
                'لم يقم بتسجيل الدخول من قبل',
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('YYYY/D ، MMMM'),
            'order_count' => $this->delivery_orders->count(),
            'points' => 0,    /////////////update
            'reward_balance' => 0, /////////////update
            'rating_avg' => $this->ratings()->avg(),
        ];
    }
}
