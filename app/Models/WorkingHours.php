<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkingHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_id',
        'mode',
        'morningStart',
        'morningEnd',
        'eveningStart',
        'eveningEnd',
    ];
    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }
}
