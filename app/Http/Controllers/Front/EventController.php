<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Model\District;
use App\Model\Event;

class EventController extends Controller
{

    public function create(){
        $districts = District::all();
        return view('front.event.add',['districts' => $districts]);
    }

    public function store(StoreEventRequest $request){           
        $event = new Event();
        $event->store($request);
        return redirect()->route('success-event');
    }

    public function success(){
        return view('front.event.success');
    }

    public function detail(Event $event){

        $similarEvents = Event::where([
            'approved' => 1,
            'category_id' => $event->category_id,            
        ])
        ->where('id','!=',$event->id)
        ->where('date_from','>=',date('Y-m-d'))->get();
     
        return view('front.event.detail',['event' => $event, 'similarEvents' => $similarEvents]);
    }

}
