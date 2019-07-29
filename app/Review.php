<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Review extends Model
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
     * Get review user
     *
     * @return model relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get reviewed product
     *
     * @return model relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
