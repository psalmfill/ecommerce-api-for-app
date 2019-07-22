<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Cart extends Model
{
    use UseUuid;
    protected $guarded =[];
     /**
     * boot model to use uuid
     */

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
