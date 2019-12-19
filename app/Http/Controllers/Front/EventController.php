<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\FrontBaseController;
use App\Model\Category;
use App\Model\District;
use App\Model\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends FrontBaseController
{

    public function create(){
        $districts = District::all();
        return view('front.event.add',['districts' => $districts]);
    }

    public function store(Request $request){

        $today = date('d.m.Y');
        $validator = Validator::make($request->all(), ['name' => 'required',
            'description' => 'required',
            'date-start' => "required|date_format:d.m.Y|after_or_equal:$today",
            'date-end' => "required|date_format:d.m.Y",
            'time-start' => "required|date_format:H:i",
            'time-end' => "required|date_format:H:i",
            'images.*' => 'mimes:jpeg,png,svg|max:2048',
            'person' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required',
            'user_place' => 'sometimes|required'
        ], [], [
            'description' => 'Popis akce',
            'date-start' => "Datum začátku",
            'date-end' => "Datum konce",
            'time-start' => "Čas začátku",
            'time-end' => "Čas konce",
            'images.*' => 'Plakát v akci',
            'person' => 'Kontaktní osoba',
            'email' => 'E-mail',
            'phone' => 'Telefon',
            'user_place' => 'Místo'
        ]);

        if ($validator->fails()) {
            if($request->ajax()) {
                $districts = District::all();
                return response()->view('front.event.addForm', [
                    'errors' => $validator->errors(),
                    'request' => $request,
                    'districts' => $districts
                ]);
            } else {
                return redirect()->route('new-event')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

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

    public function eventList(Request $request) {

        $districtId = $request->input('district_id');
        $categoryId = $request->input('category_id');
        $date = strtotime($request->input('date_from'));

        $allCategories = Category::all();
        $districts = District::all();

        $selectedDistrict = District::find($districtId);
        $selectedCategory = Category::find($categoryId);

        $eventList = Event::where('approved','=', true);

        if($categoryId){
            $eventList->where('category_id',(int)$categoryId);
        }

        if($districtId) {
            $eventList->where('district_id',(int)$districtId);
        }

        if($date) {
            $eventList->whereDate('date_from', '>=', date('Y-m-d', $date) .' 00:00:00');
        }

        return view('front.event.list', [
            'events' => $eventList->get(),
            'allCategories' => $allCategories,
            'districts' => $districts,
            'selectedDistrict' => $selectedDistrict,
            'selectedDate' => $date,
            'selectedCategory' => $selectedCategory
        ]);
    }

}
