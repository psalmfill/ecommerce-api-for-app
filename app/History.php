<?php

namespace App;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use UseUuid;

    protected $fillable = ['comment','user_id'];

    protected static function boot()
    {
        parent::boot();
        self::bootUsesUuid();
    }

    public function historable()
    {
        return $this->morphTo();
    }
}
