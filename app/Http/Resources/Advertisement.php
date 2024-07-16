<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Advertisement extends JsonResource
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
            'url' => $this->url,
            'start_date' => $this->start_date,
            'num_of_day' => $this->num_of_day,
            'details' => $this->details,
            'active' => (bool)$this->active,
            'status' => $this->status,
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
        ];
    }
}
