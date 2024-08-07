<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(ProductOption::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class,'products_categories','product_id','category_id');
    }

    public function enhancements(): BelongsToMany
    {
        return $this->belongsToMany(Enhancement::class,'products_enhancements');
    }
    
}
