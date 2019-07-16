<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\UseUuid;

class User extends Authenticatable
{
    use Notifiable,UseUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->hasMany(Role::class,'user_role');
    }

    public function cartItems()
    {
        return $this->belongsToMany(Product::class,'carts','user_id','product_id');
    }

    public function wishListItems()
    {
        return $this->belongsToMany(Product::class,'wish_lists','user_id','product_id');
    }

    public function orders()
    {
        return $this->hasMany(Product::class,'orders');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
