<?php

namespace App\Model;

use App\Model\Traits\HasEventsTrait;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasEventsTrait;

    protected $guarded = ['id'];

    public function district(){
        return $this->belongsTo('App\Model\District');
    }

}
