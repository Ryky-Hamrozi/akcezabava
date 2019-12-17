<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = ['id'];

    public const locations = [
        1 => 'Nahoře',
        2 => 'Vlevo',
        3 => 'Vpravo',
        4 => 'Karusel',
        5 => 'Akce',
    ];

    public function event(){
        return $this->belongsTo('App\Model\Event');
    }

    public function image()
    {
        return $this->morphOne('App\Model\Image','imageable');
    }

}
