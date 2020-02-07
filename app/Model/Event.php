<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;

class Event extends Model
{

    use Sortable;

    public $sortable = ['title', 'date_from', 'date_to', 'district_id', 'place_id', 'created_at', 'fb_url', 'contact_id', 'updated_at'];

    protected $guarded = ['id'];

    public function getDateFromAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d. m. Y  H:i');
    }

    public function getDateToAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d. m. Y  H:i');
    }

    public function getChangedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d. m. Y  H:i');
    }

    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d. m. Y  H:i');
    }

    public function getDateFromMilliseconds()
    {
        return \Carbon\Carbon::parse($this->attributes['date_from'])->setTime(0,0,0,0)->timestamp * 1000;
    }

    public function getDateToMilliseconds()
    {
        return \Carbon\Carbon::parse($this->attributes['date_to'])->setTime(0,0,0,0)->timestamp * 1000;
    }

    public function getFromDate()
    {
        return \Carbon\Carbon::parse($this->attributes['date_from'])->format('d. m. Y');
    }

    public function getToDate()
    {
        return \Carbon\Carbon::parse($this->attributes['date_to'])->format('d. m. Y');
    }

    public function getFromTime()
    {
        return \Carbon\Carbon::parse($this->attributes['date_from'])->format('H:i');
    }

    public function getToTime()
    {
        return \Carbon\Carbon::parse($this->attributes['date_to'])->format('H:i');
    }

    public function district()
    {
        return $this->belongsTo('App\Model\District');
    }

    public function place()
    {
        return $this->belongsTo('App\Model\Place');
    }

    public function contact()
    {
        return $this->belongsTo('App\Model\Contact');
    }

    public function category(){
        return $this->belongsTo('App\Model\Category');
    }

    public function images(){
        return $this->morphMany('App\Model\Image','imageable');
    }

    public function banner() {
        return $this->belongsTo('App\Model\Banner');
    }

    public function getMainImage(){
        $img = $this->images()->first();
        if($img){
            return $img->path;
        }
    }

    public function getImagesInfo(){
        $count = $this->images()->count();
        if($count > 0){
            return "ANO ($count)";
        }
        else{
            return "NE";
        }

    }

    public function getFormatedDate(){
        $dateStr = $this->getFromDate();
        if($dateStr != $this->getToDate()){
            $dateStr .= " - " . $this->getToDate();
        }

        $timeStr = $this->getFromTime();

        if($timeStr != $this->getToTime()){
            $timeStr .= ' - ' . $this->getToTime();
        }

        return $dateStr . ' ' . $timeStr;

    }

    public function upcomingEvents(){

        return $this->where('date_from','>=',now())->where('approved',1);
    }

    public function forApprovalEvents(){
        return $this->where('approved',0);
    }

    public function finishedEvents(){
        return $this->where('date_from','<=',now());
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

    public function getEventsByParams(){
        // tady filtrovaty akce podle typu akce, a data
    }

    public function store($request){
        $data = $this->processData($request);
        if($this->id){
            $this->update($data);
        }
        else{
            $this->fill($data);
            $this->save();
        }
        $this->processImages($request,$this);

        return $this;
    }

    private function processData(Request $request)
    {
        $data = [
            'title' => $request->get('name'),
            'district_id' => $request->get('district'),
            'description' => $request->get('description'),
            'approved' => false,
        ];

        if(Auth::check() && !$request->has('person') && !$request->has('not_approved')){
            $data['approved'] = true;
        }

        $dateStartStr = $request->get('date-start') .' : '.$request->get('time-start');
        $dateEndStr = $request->get('date-end') .' : '.$request->get('time-end');
        $dateStart = date_create_from_format('d.m.Y : H:i',$dateStartStr);
        $dateEnd = date_create_from_format('d.m.Y : H:i',$dateEndStr);

        $data['date_from'] = $dateStart;
        $data['date_to'] = $dateEnd;

        if($request->has('place')){
            $data['place_id'] = $request->get('place');
        }

        if($request->has('category')){
            $data['category_id'] = $request->get('category');
        }

        if($request->has('contact')){
            $data['contact_id'] = $request->get('contact');
        }
        else{
            $data['contact_id'] = $this->processContact($request);
        }

        if($request->has('user_place')){
            $data['place_text'] = $request->get('user_place');
        }

        if($request->has('place_id')){
            $data['place_id'] = $request->get('place_id');
        }

        if($request->has('fb_url')){
            $data['fb_url'] = $request->get('fb_url');
        }

        return $data;

    }

    private function processImages($request,$event){

        $deletedImages = $request->get('deleted-images');
        $deletedImagesIds = [];
        if($deletedImages){
            $deletedImagesIds = explode(',',$deletedImages);
        }

        foreach($deletedImagesIds as $id){
            $image = Image::find($id)->delete();
        }
        if($request->images){
            $i = 1;
            foreach($request->file('images') as $img){
                if($img){
                    $image = new Image();
                    $image->uploadImage($img,$event);
                    //// Smaze obrazky pokud jich je vic..
//                    ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_EVENT_HOMEPAGE_LIST, $event->id . "-" . $i, true);
                }

                $i++;
            }
        }

        /// Smaze hlavni obrazek
        ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_EVENT_HOMEPAGE_CAROUSEL, $event->id);
        ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_EVENT_HOMEPAGE_LIST, $event->id);
        ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_EVENT_DETAIL, $event->id);
    }

    private function processContact($request){
        $contact = Contact::firstOrNew(['name' => $request->person, 'email' => $request->email, 'phone' => $request->phone]);
        $contact->district_id = $request->district;
        $contact->save();

        return $contact->id;
    }

}

