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
        POSITION_EVENT_LIST = 5,
        POSITION_EVENT_DETAIL = 6;

    const locations = [
        self::POSITION_UP => 'Nahoře (1110 x 200 px)',
        self::POSITION_LEFT => 'Vlevo (418 x 980 px)',
        self::POSITION_RIGHT => 'Vpravo (418 x 980 px)',
        self::POSITION_CAROUSEL => 'Hlavní stránka - Carousel (1050 x 420 px)',
        self::POSITION_EVENT_LIST => 'Akce - seznam (330 x 400 px)',
        self::POSITION_EVENT_DETAIL => 'Akce - detail (310 x 321 px)',
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
