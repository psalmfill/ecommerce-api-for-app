<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Order extends Model
{
    use UseUuid;

    protected $guarded = [];
    
    public static function boot()
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

    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
