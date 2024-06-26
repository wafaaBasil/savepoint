<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_type',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function setImageAttribute($image)
    {
        if(gettype($image) != 'string') {
            $i = $image->store('images/profiles', 'public');
            $this->attributes['image'] = $image->hashName();
        } else {
            $this->attributes['image'] = $image;
        }
    }

    public function getImageAttribute($image)
    {
        $img = $image?? 'male.jpeg';
        return asset('storage/images/profiles') . '/' . $img;
    }

    public function setPasswordAttribute($password)
    {
            $this->attributes['password'] = bcrypt($password);
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }
    public function customer_orders(): HasMany
    {
        return $this->hasMany(Order::class,'customer_id');
    }

    public function delivery_orders(): HasMany
    {
        return $this->hasMany(Order::class,'delivery_id');
    }

    public function generateCode()
    {
        $this->timestamps = false;
        //$this->code = rand(100000, 999999);
        $this->code = 123456;
        $this->code_expires_at = now()->addMinutes(10);
        $this->save();
    }

    public function resetCode()
    {
        $this->timestamps = false;
        $this->code = null;
        $this->code_expires_at = null;
        $this->save();
    }
}
