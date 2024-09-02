<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkingHours extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'day' => new Day($this->day),
            'mode' => $this->mode,
            'morningStart' => $this->morningStart,
            'morningEnd'  => $this->morningEnd ? 
           date('hh:mm',strtotime($this->morningEnd)):
            $this->morningEnd,
            'eveningStart' => $this->eveningStart,
            'eveningEnd'  => $this->eveningEnd,
        ];
    }
}
