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
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        
        
        self::bootUsesUuid();
    }


    public function users()
    {
        return $this->belongsToMany(User::class,'role_user');
    }
}
