<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'description',
        'room_type_id',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
