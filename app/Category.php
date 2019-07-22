<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Category extends Model
{
    use UseUuid;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        self::bootUsesUuid();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
