<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Cart extends Model
{
    use UseUuid;
    protected $guarded = ['id'];
     /**
     * boot model to use uuid
     */

    protected static function boot()
    {
        parent::boot();
        
        
        self::bootUsesUuid();
    }

    /**
     * get cart item owner
     *
     * @return model relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get product
     *
     * @return model relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
