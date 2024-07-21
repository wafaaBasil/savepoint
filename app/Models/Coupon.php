<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;
    
    public function setImageAttribute($image)
    {   if(!is_null($image)){
            if(gettype($image) != 'string') {
                $i = $image->store('images/coupons', 'public');
                $this->attributes['image'] = $image->hashName();
            } else {
                $this->attributes['image'] = $image;
            }
        }
        
    }

    public function getImageAttribute($image)
    {
        if(is_null($image)){
            return null;
        }
        return asset('storage/images/coupons') . '/' . $image;
    }
}
