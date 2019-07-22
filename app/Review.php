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
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        
        self::bootUsesUuid();
        
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
