<?php

namespace App\Http\Resources;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Provider extends JsonResource
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
            'type' => $this->provider_id == null ? 'main':'branch', 
            'logo' => $this->logo,
            'name' => $this->name,
            'phonenumber' => $this->phonenumber,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'categories'=>$this->categories,
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
            'status' => $this->status,
            'active' => $this->active,
            'branches_count' => $this->branches->count(),
            'order_count' => $this->orders->count(),
            'new_order_count' => $this->orders->where('status','جديد')->count(),
            'deliver_order_count' => $this->orders->where('status','التوصيل')->count(),
            'pending_order_count' => $this->orders->where('status','جاري التجهيز')->count(),
            'completed_order_count' => $this->orders->where('status','تم التوصيل')->count(),
            'deliver_order_monthly' => $this->deliver_order_monthly(),
            'pending_order_monthly' => $this->pending_order_monthly(),
            'completed_order_monthly' => $this->completed_order_monthly(),
            'deliver_order_percent' => $this->deliver_order_percent(),
            'pending_order_percent' => $this->deliver_order_percent(),
            'completed_order_percent' => $this->deliver_order_percent(),
        ];
    }
}
