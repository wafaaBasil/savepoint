<?php

namespace App\Http\Resources;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Branch extends JsonResource
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
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'provider' => $this->provider,
            'city' => new City($this->city),
            'workingHours' => WorkingHours::collection($this->workingHours),
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
            'active' => (bool)$this->active,
            'order_count' => $this->orders->count(),
            'order_monthly' => $this->order_monthly(),
        ];
    }
}
