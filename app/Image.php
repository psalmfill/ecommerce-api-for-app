<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;
use Psy\Util\Str;

class Image extends Model
{
    use UseUuid;

    protected static function boot()
    {
        parent::boot();

        self::bootUsesUuid();
    }

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
