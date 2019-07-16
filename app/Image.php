<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    
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
