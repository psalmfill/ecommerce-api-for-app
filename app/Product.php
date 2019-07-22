<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;
class Product extends Model
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

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class,'imageable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
