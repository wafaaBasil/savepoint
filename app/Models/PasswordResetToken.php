<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $primaryKey = 'phonenumber';
    protected $fillable = [
        'phonenumber', 'token'
    ];
}
