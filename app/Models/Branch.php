<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
class Branch extends Model
{
    use HasFactory, SoftDeletes;
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function workingHours(): HasMany
    {
        return $this->hasMany(WorkingHours::class);
    }

    public function order_monthly()
    {
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;
        if($this->hasMany(Order::class)->count() == 0){
            return 0;
        }
        if($this->hasMany(Order::class)->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)
        ->count() == 0){
            return 100;
        }
        
        return ($this->hasMany(Order::class)->where('status',)->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count() - $this->hasMany(Order::class)->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)->count()
        )/$this->hasMany(Order::class)->whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)
        ->count()*100;
    }

    

}
