<?php

namespace App;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use UseUuid;

    public static function boot()
    {
        parent::boot();
        self::bootUsesUuid();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getRemainingAttribute()
    {
        return $this->quantity - $this->orders->count();
    }
}
