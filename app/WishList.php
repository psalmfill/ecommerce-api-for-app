<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class WishList extends Model
{
    use UseUuid;

    protected $guarded = [];


    protected static function boot()
    {
        parent::boot();

        self::bootUsesUuid();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
