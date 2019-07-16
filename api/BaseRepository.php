<?php
use App\Api;
use Illuminate\Support\Str;

class BaseRepository {

    public function generateUuid() {
        
        return Str::uuid()->toString();
    }
}