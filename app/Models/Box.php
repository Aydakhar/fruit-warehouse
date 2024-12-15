<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = ['fruit_type', 'room_id'];

    public function room() {
        return $this->belongsTo(Room::class);
    }
}
