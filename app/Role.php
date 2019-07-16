<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use UseUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
