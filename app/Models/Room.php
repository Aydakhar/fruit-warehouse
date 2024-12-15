<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function boxes() {
        return $this->hasMany(Box::class);
    }
}
