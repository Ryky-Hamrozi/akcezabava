<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\Banner;
use App\Model\Category;
use App\Model\District;
use App\Model\Event;
use Illuminate\Http\Request;


class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCategories = Category::all();
        $categories = $allCategories->take(5);

        $districts = District::all();
                

        $categoryId = request()->category;

        if($categoryId){            
            $events = Event::where('approved','=', 1)
                        ->where('date_from','>=',date('Y-m-d'))
                        ->where('category_id',(int)$categoryId)->paginate(5);
        }
        else{
            $events = Event::where('approved','=', 1)
                        ->where('date_from','>=',date('Y-m-d'))
                        ->paginate(5);
        } 
        
        $carouselBanners = Banner::all()->where('location','=', Banner::POSITION_CAROUSEL);

        $actionBanner = Banner::all()->where('location', '=', Banner::POSITION_ACTION);

        return view('front.homepage',[
            'categories' => $categories,
            'allCategories' => $allCategories,
            'events' => $events,
            'districts' => $districts,
            'categoryId' => $categoryId,
            'carouselBanners' => $carouselBanners,
            'actionBanner' => $actionBanner
        ]);
    }

    public function aboutUs(){

        return view('front.about-us');
    }

    public function howItWorks(){
        return view('front.how-it-works');
    }

    public function advertising(){
        return view('front.advertising');
    }

    public function processAdvertising(){
       $from = request()->get('email');
       $phone = request()->get('phone');
       $message = request()->get('des');
       $name = request()->get('person');

       if($from && $phone && $message && $name){

           $headers = "MIME-Version: 1.0" . "\r\n";
           $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
           $headers .= "From: $from" . "\r\n";
           $to = 'stanislav.cech@leksys.cz';
           $subject = 'Zpráva z reklamního formuláře';

           mail($to,$subject,$message,$headers);
       }

    }

}
