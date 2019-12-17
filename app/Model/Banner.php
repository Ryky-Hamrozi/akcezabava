<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = ['id'];

    const
        POSITION_UP = 1,
        POSITION_LEFT = 2,
        POSITION_RIGHT = 3,
        POSITION_CAROUSEL = 4,
        POSITION_ACTION = 5;

    const locations = [
        self::POSITION_UP => 'Nahoře',
        self::POSITION_LEFT => 'Vlevo',
        self::POSITION_RIGHT => 'Vpravo',
        self::POSITION_CAROUSEL => 'Karusel',
        self::POSITION_ACTION => 'Akce',
    ];

    public function event(){
        return $this->belongsTo('App\Model\Event');
    }

    public function image()
    {
        return $this->morphOne('App\Model\Image','imageable');
    }

    public function getImagePath() {
        $image = $this->image()->first();
        if($image) {
            return $image->path;
        }
    }

}
