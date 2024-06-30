<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $dates = ['deleted_at'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class,'categories_providers');
    }
        public function branches(): HasMany
    {
        return $this->hasMany(Provider::class);
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function completed_order_monthly()
    {
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;
        if($this->hasMany(Order::class)->where('status','تم التوصيل')->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)
        ->count() == 0){
            return 100;
        }
        return ($this->hasMany(Order::class)->where('status',)->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count() - $this->hasMany(Order::class)->where('status','تم التوصيل')->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)->count()
        )/$this->hasMany(Order::class)->where('status','تم التوصيل')->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)
        ->count()*100;
    }

    public function pending_order_monthly()
    {
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;
        if($this->hasMany(Order::class)->where('status','جاري التجهيز')->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)
        ->count() == 0){
            return 100;
        }
        return ($this->hasMany(Order::class)->where('status','جاري التجهيز')->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count() - $this->hasMany(Order::class)->where('status','جاري التجهيز')->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)->count()
        )/$this->hasMany(Order::class)->where('status','جاري التجهيز')->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)
        ->count()*100;
    }

    public function deliver_order_monthly()
    {
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;
        if($this->hasMany(Order::class)->where('status','التوصيل')->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)
        ->count() == 0){
            return 100;
        }
        return ($this->hasMany(Order::class)->where('status','التوصيل')->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count() - $this->hasMany(Order::class)->where('status','التوصيل')->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)->count()
        )/$this->hasMany(Order::class)->where('status','التوصيل')->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)
        ->count()*100;
    }

    public function main(): BelongsTo
    {
        return $this->BelongsTo(Provider::class);
    }
    public function setImageAttribute($image)
    {
        if(gettype($image) != 'string') {
            $i = $image->store('images/providers', 'public');
            $this->attributes['image'] = $image->hashName();
        } else {
            $this->attributes['image'] = $image;
        }
    }

    public function getImageAttribute($image)
    {
        $img = $image?? 'male.jpeg';
        return asset('storage/images/providers') . '/' . $img;
    }
}
