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
            'image' => $this->image,
            'name' => $this->name,
            'type' => $this->type,
            'discount' =>(string) $this->discount,
            'top_discount' => (string)$this->top_discount,
            'end_date' => $this->end_date,
            'num_of_use' => $this->num_of_use,
            'active' => (bool)$this->active,
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
        ];
    }
}
