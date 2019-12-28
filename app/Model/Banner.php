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
        self::POSITION_UP => 'Nahoře',
        self::POSITION_LEFT => 'Vlevo',
        self::POSITION_RIGHT => 'Vpravo',
        self::POSITION_CAROUSEL => 'Hlavní stránka - Carousel',
        self::POSITION_EVENT_LIST => 'Akce - seznam',
        self::POSITION_EVENT_DETAIL => 'Akce - detail',
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
