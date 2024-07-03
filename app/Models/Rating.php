<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    public function from_user(): BelongsTo
    {
        return $this->BelongsTo(User::class,'from_user_id')->withTrashed();
    }

    public function to_user(): BelongsTo
    {
        return $this->BelongsTo(User::class,'to_user_id')->withTrashed();
    }
}
