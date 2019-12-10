<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Category extends Model
{
    use UseUuid;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        self::bootUsesUuid();
    }

    /**
     * get all product belonging to category
     *
     * @return model relationship
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all category that are children of the category
     *
     * @return model relationship
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function scopeNoSubCategories($query)
    {
        return $query->where('parent_id', null)->get();
    }

    public function scopeSubCategories($query, $category_id)
    {
        return $query->where('parent_id', $category_id)->get();
    }
}
