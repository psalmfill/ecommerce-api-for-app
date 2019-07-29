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
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        
        
        self::bootUsesUuid();
    }

    /**
     * Get the average rating on the product
     *
     * @return Integer
     */
    public function getRatingAttribute()
    {
        if(!$this->reviews->count())
            return 0;
        $sum = 0;
        foreach($this->reviews as $review)
        {
            $sum += $review->rating;
        }
        return ceil($sum/$this->reviews->count()) ;
    }

    /**
     * Get the orders made on the product
     *
     * @return model relationship
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get product category
     *
     * @return model relationship
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all product images
     *
     * @return model relationship
     */
    public function images()
    {
        return $this->morphMany(Image::class,'imageable');
    }

    /**
     * Get reviews made on product
     *
     * @return model relationship
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
