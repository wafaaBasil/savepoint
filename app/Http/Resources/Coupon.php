<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Coupon extends JsonResource
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
            'coupon_type' => $this->coupon_type,
            'image' => $this->image,
            'name' => $this->name,
            'type' => $this->type,
            'discount' =>(string) $this->discount,
            'top_discount' => (string)$this->top_discount,
            'end_date' => $this->end_date,
            'num_of_use' => $this->num_of_use,
            'num_of_use_person' => $this->num_of_use_person,
            'min_bill' => $this->min_bill,
            'active' => (bool)$this->active,
            'status' => $this->status,
            'provider' => new Provider($this->provider),
            'branch' => new Branch($this->branch),
            'customer' => new User($this->customer),
            'product' => new Product($this->product),
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
        ];
    }
}
