<?php

namespace App\Models;

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
