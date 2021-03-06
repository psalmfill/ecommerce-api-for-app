<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Role extends Model
{
    use UseUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    protected static function boot()
    {
        parent::boot();
        
        
        self::bootUsesUuid();
    }


    /**
     * Get Users with role 
     *
     * @return model relationship
     */
    public function users()
    {
        return $this->belongsToMany(User::class,'role_user');
    }
}
