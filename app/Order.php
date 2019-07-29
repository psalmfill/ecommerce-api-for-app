<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Order extends Model
{
    use UseUuid;

    protected $guarded = ['id'];
    
    public static function boot()
    {
        parent::boot();
        self::bootUsesUuid();
    }

    /**
     * Get user
     *
     * @return model relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get product ordered
     *
     * @return model relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Generate total price of order
     *
     * @return model relationship
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
