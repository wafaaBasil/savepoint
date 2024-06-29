<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    public function user_from(): BelongsTo
    {
        return $this->BelongsTo(User::class,'user_from_id');
    }

    public function user_to(): BelongsTo
    {
        return $this->BelongsTo(User::class,'user_to_id');
    }
}
