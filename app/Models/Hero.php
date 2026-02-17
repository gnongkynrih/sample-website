<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $guarded = ['id'];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
