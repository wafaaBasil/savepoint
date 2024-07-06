<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategory extends JsonResource
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
            'active' => $this->active,
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
        ];
    }
}
