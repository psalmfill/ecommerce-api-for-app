<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function cities()
    {
        return $this->hasManyThrough(City::class, State::class);
    }
}
