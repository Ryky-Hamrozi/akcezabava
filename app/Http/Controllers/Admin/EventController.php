<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Model\Image;
use App\Model\Import;
use Illuminate\Http\Request;
use App\Model\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends AdminBaseController
{


    public function __construct()
    {
        $this->searchAvailable = true;

        parent::__construct();
    }

    public function requests(Request $request, $events) {
        if($request->get('q')) {
            $events->where('title', 'like', '%'.$request->get('q').'%');
            $events->where('description', 'like', '%'.$request->get('q').'%');
        }

        return $events;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = Event::sortable()->whereDate('date_to', '>=', date('y.m-d h:i:s'));
        $events = $this->requests($request, $events);
        $events = $events->paginate($this->itemsPerPage);

        return view('admin.event.list')->with(['events' => $events]);
    }

    public function forApproval(Request $request)
    {
        $events  = Event::sortable()->where('approved','=',0)->orderBy('id', 'desc');
        $events = $this->requests($request, $events);
        $events = $events->paginate($this->itemsPerPage);

        return view('admin.event.forApprovalList')->with(['events' => $events]);
    }

    public function finished(Request $request)
    {
        $events = Event::sortable()->where('date_to','<',now())->orderBy('id', 'desc');
        $events = $this->requests($request, $events);
        $events = $events->paginate($this->itemsPerPage);

        return view('admin.event.list')->with(['events' => $events]);
    }

    public function upcoming(Request $request)
    {
        $events = Event::sortable()->where('date_from','>',now())->orderBy('id', 'desc');
        $events = $this->requests($request, $events);
        $events = $events->paginate($this->itemsPerPage);

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

        if(!$request->get('name') && $request->get('fb_url')) {
            require_once('../vendor/simple_html_dom/simple_html_dom.php');
            $exploded = explode('/', parse_url($request->get('fb_url'), PHP_URL_PATH));
            $id = $exploded[2];

            $udalost = Import::vratOstatniInformaceZEventu($request->get('fb_url'));

            if(!is_array($udalost)) {
                flash('Událost vyžaduje přihlášení byla přeskočena')->error();
                return response()->redirectToRoute('event.index');
            }

            $udalost['fb_id'] = $id;
            $udalost['fb_url'] = $request->get('fb_url');
            $udalost['approved'] = false;

            $data = Import::importEvents([$udalost]);

            if($data['udalostiErrors']) {
                foreach ($data['udalostiErrors'] as $error) {
                    flash($error['error'])->error();
                }
            } else {
                flash('Akce byla úspěšně naimportována - ' . $udalost['title'])->success();
            }


        } else {
            $event->store($request);
            flash('Akce byla úspěšně přidána')->success();
        }


        return response()->redirectToRoute('event.index');
    }

    public function update(UpdateEventRequest $request, Event $event){
        $event->store($request);
        flash('Akce byla úspěšně upravena.')->success();
        return redirect()->back();
    }


    public function approve(Request $request){
        $eventId = $request->get('id');
        $event = Event::findOrFail($eventId);
        if($event->place_id && $event->category->id){
            $event->approved = $event->approved == 1 ? 0 : 1;
            $event->save();

            flash("Udalost schválena - " . $event->title)->success();
        }
        else{
            flash("Před schválením je nutné nastavit místo a kategorii.")->error();
        }
        $eventsCount  = Event::where('approved','=',0)->get();
        $events  = Event::where('approved','=',0)->orderBy('id', 'desc')->paginate($this->itemsPerPage);

        return response()->json([
            'flashes' => view('flash::message')->render(),
            'events' => view('admin.event.components.events_table_forApproval', ['events' => $events])->render(),
            'eventsCount' => count($eventsCount->all())
        ]);



    }

}
