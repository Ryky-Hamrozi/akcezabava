<?php

namespace App\Model;

use App\Model\Traits\HasEventsTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasEventsTrait;

    protected $guarded = ['id'];

    public static function getTopCategories($limit = false){

        $topCategories = self::withCount('events')->orderBy('events_count','desc');
        if($limit){

            $topCategories->limit($limit);
        }
        return $topCategories->get();
    }

    public function events() {
        return $this->hasMany(Event::class, 'category_id', 'id');
    }
}
