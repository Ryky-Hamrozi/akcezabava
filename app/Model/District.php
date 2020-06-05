<?php

namespace App\Model;

use App\Model\Traits\HasEventsTrait;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasEventsTrait;

    protected $guarded = ['id'];

    public function places()
    {
        return $this->hasMany('App\Model\Place');
    }

    public static function getTopDistricts($limit = false){
        $topDistricts = self::withCount('events')->orderBy('events_count','desc');
        if($limit){
            $topDistricts->limit($limit);
        }
        return $topDistricts->get();
    }

    public function events() {
        return $this->hasMany(Event::class, 'district_id', 'id');
    }

}
