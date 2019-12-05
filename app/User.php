<?php

namespace App;

use App\Mail\RegistrationCompleted;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\UseUuid;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    private $ADMIN = 'admin';
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
        self::created(function($user){
            
            Mail::to($user)
                ->send(new RegistrationCompleted($user));
                
        });
    }

    /**
     * Get all roles owned by the user
     *
     * @return model relationship
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_user');
    }

    /**
     * Get user items on cart
     *
     * @return model relationship
     */
    public function cartItems()
    {
        return $this->belongsToMany(Product::class,'carts','user_id','product_id');
    }

    /**
     * Get users Item on Wish List
     *
     * @return model relationship
     */
    public function wishListItems()
    {
        return $this->belongsToMany(Product::class,'wish_lists','user_id','product_id');
    }

    /**
     * Get User order
     *
     * @return model relationship
     */
    public function orders()
    {
        return $this->hasMany(Order::class,'user_id');
    }

    /**
     * Get User reviews on product
     *
     * @return model relationship
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if the user has an admin role
     *
     * @return void
     */
    public function getIsAdminAttribute(){
        $roles = $this->roles;
        foreach($roles as $role){
            if(strtolower($role->name) == $this->ADMIN)
            {
                return true;
            }
        }
        return false;
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name .' '.$this->last_name . ' '. $this->middle_name);
    }

    public function getAvatarAttribute()
    {
        return asset(Storage::url($this->photo));
    }
}
