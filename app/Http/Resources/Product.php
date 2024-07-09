<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'name_ar' => $this->name_ar,
            'details' => $this->details,
            'price' => $this->price,
            'offer_price' => $this->offer_price,
            'calories' => $this->calories,
            'categories' => ProductCategory::collection($this->categories),
            'earned_points' => $this->earned_points,
            'purchase_points' => $this->purchase_points,
            'images' => ProductImage::collection($this->images),
            'options' => ProductOption::collection($this->options),
            'enhancements' => Enhancement::collection($this->enhancements),
            'active' => (bool)$this->active,
            'created_at' =>Carbon::parse($this->created_at)->isoFormat('a h:m - YYYY/D ، MMMM'),
        ];
    }
}
