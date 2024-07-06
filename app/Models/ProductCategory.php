<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;
    public function setImageAttribute($image)
    {
        if(gettype($image) != 'string') {
            $i = $image->store('images/product_categories', 'public');
            $this->attributes['image'] = $image->hashName();
        } else {
            $this->attributes['image'] = $image;
        }
    }

    public function getImageAttribute($image)
    {
        $img = $image?? 'male.jpeg';
        return asset('storage/images/product_categories') . '/' . $img;
    }
}
