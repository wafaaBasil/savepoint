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
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        
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
            'deliver_order_monthly' => (Order::where('status','التوصيل')->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count() - Order::where('status','التوصيل')->whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            )/Order::where('status','التوصيل')->whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            ->count()*100,
            'pending_order_monthly' => (Order::where('status','جاري التجهيز')->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count() - Order::where('status','جاري التجهيز')->whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            )/Order::where('status','جاري التجهيز')->whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            ->count()*100,
            'completed_order_monthly' => (Order::where('status','تم التوصيل')->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count() - Order::where('status','تم التوصيل')->whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            )/Order::where('status','تم التوصيل')->whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            ->count()*100,
            'deliver_order_percent' => $this->orders->where('status','التوصيل')->count()/$this->orders->count(),
            'pending_order_percent' => $this->orders->where('status','جاري التجهيز')->count()/$this->orders->count(),
            'completed_order_percent' => $this->orders->where('status','تم التوصيل')->count()/$this->orders->count(),
        ];
    }
}
