<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\UseUuid;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,UseUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


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


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * boot model to use uuid
     */

    protected static function boot()
    {
        parent::boot();
        
        
        self::bootUsesUuid();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_user');
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
        return $this->hasMany(Order::class,'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    
}
