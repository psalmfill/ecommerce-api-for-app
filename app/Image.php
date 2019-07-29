<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;
use Psy\Util\Str;

class Image extends Model
{
    use UseUuid;
    protected $guarded = ['id'];
    
    protected static function boot()
    {
        parent::boot();

        self::bootUsesUuid();
    }

    /**
     * Get the model that the image belongs to
     *
     * @return morph relationship
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
