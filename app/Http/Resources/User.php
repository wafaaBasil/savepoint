<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class User extends JsonResource
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
            'image' => $this->image,
            'name' => $this->name,
            'phonenumber' => $this->phonenumber,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'user_type' => $this->user_type,
            'last_login_at' => $this->last_login_at ? 
                Carbon::parse($this->last_login_at)->diffForHumans() :
                'لم يقم بتسجيل الدخول من قبل',
            'customer_orders' => $this->customer_orders->count(),
            'points' => 0, //later
            'reward_balance' => 0, //later
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('YYYY/D ، MMMM'),
        ];
    }
}
