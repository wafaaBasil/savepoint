<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    
    public function setImageAttribute($image)
    {
        if(gettype($image) != 'string') {
            $i = $image->store('images/coupons', 'public');
            $this->attributes['image'] = $image->hashName();
        } else {
            $this->attributes['image'] = $image;
        }
    }

    public function getImageAttribute($image)
    {
        $img = $image?? 'male.jpeg';
        return asset('storage/images/coupons') . '/' . $img;
    }
}
