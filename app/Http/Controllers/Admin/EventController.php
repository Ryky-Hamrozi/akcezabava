<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Model\Image;
use Illuminate\Http\Request;
use App\Model\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::paginate($this->itemsPerPage);
        return view('admin.event.list')->with(['events' => $events]);
    }

    public function forApproval()
    {
        $events  = Event::where('approved','=',0)->paginate($this->itemsPerPage);
        return view('admin.event.forApprovalList')->with(['events' => $events]);
    }

    public function finished()
    {
        $events = Event::where('date_to','<',now())->paginate($this->itemsPerPage);
        return view('admin.event.list')->with(['events' => $events]);
    }

    public function upcoming()
    {
        $events = Event::where('date_from','>',now())->paginate($this->itemsPerPage);
        return view('admin.event.list')->with(['events' => $events]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $event = new Event();
        $event->store($request);
        return response()->redirectToRoute('event.index');
    }

    public function update(UpdateEventRequest $request, Event $event){
        $event->store($request);
        return redirect()->back();       
    }


    public function approve(Request $request){
        $eventId = $request->get('id');
        $event = Event::findOrFail($eventId);
        if($event->place_id && $event->category->id){
            $event->approved = $event->approved == 1 ? 0 : 1;
            $event->save();
        }
        else{
            return response()->json(['message' => 'Před schválením je nutné nastavit místo a kategorii.'],422);
        }
        
    }

}
