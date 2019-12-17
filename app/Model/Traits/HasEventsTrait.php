<?php

namespace App\Model\Traits;

trait HasEventsTrait{

    public function events(){
        return $this->hasMany('App\Model\Event');
    }

    public function upcomingEvents(){

        return $this->hasMany('App\Model\Event')->where('date_from','>=',now())->where('approved',1);
    }

    public function forApprovalEvents(){
        return $this->hasMany('App\Model\Event')->where('approved',0);
    }

    public function finishedEvents(){
        return $this->hasMany('App\Model\Event')->where('date_from','<=',now());
    }

    public function getEventsCount(){
        return $this->events()->count();
    }

    public function getUpcomingEventsCount(){
        return $this->upcomingEvents()->count();
    }

    public function getForApprovalEventsCount(){
        return $this->forApprovalEvents()->count();
    }

    public function getFinishedEventsCount(){
        return $this->finishedEvents()->count();
    }
}