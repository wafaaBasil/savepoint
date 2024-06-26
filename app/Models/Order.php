<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class,'customer_id');
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(User::class,'delivery_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

   /* public function delivery_rating_customer(): HasOne
    {
        return $this->belongsTo(Rating::class,'delivery_id','from_user_id');
    }

    public function customer_rating_delivery(): HasOne
    {
        return $this->belongsTo(Rating::class,'delivery_id','from_user_id');
    }*/
    
}
