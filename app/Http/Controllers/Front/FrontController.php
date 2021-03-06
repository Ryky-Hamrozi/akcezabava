<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\FrontBaseController;
use App\Model\Banner;
use App\Model\Category;
use App\Model\District;
use App\Model\Event;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class FrontController extends FrontBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $allCategories = Category::whereHas('events', function($q) {
            $q->where('date_to', '>=', date('Y-m-d H:i:s', time()));
//            $q->where('approved', '=', true);
        })->get();

        $categories = $allCategories->take(5);

        $districts = District::whereHas('events', function($q) {
            $q->where('date_to', '>=', date('Y-m-d H:i:s', time()));
//            $q->where('approved', '=', true);
        })->get();


        $categoryId = request()->category;

        if($categoryId){
            $events = Event::where('approved','=', 1)
                        ->where('date_from','>=',date('Y-m-d H:i:s'))
                        ->where('date_to', '>=', date('Y-m-d H:i:s'))
                        ->where('category_id',(int)$categoryId)
                        ->orderBy('date_from', 'asc');
        }
        else{
            $events = Event::where('approved','=', 1)
                        ->where('date_from','>=',date('Y-m-d H:i:s'))
                        ->where('date_to', '>=', date('Y-m-d H:i:s'))
                        ->orderBy('date_from', 'asc');
        }

//        $events->groupBy('title');
        $events->paginate($this->itemsPerPage);

        $carouselBanners = Banner::all()->where('location','=', Banner::POSITION_CAROUSEL);

        $actionBanner = Banner::all()->where('location', '=', Banner::POSITION_EVENT_LIST);

        return view('front.homepage',[
            'categories' => $categories,
            'allCategories' => $allCategories,
            'events' => $events->get()->unique(),
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

    public function akceAZabava(){
        return view('front.akce-a-zabava');
    }

	public function successAdvertising() {
		return view('front.successAdvertising');
	}

	public function processAdvertising(Request $request) {

        $validator = Validator::make($request->all(), [
            'person' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'dsc' => 'required',
        ], [], [
            'person' => 'Jméno a příjmení',
            'email' => 'E-mail',
            'phone' => 'Telefon',
            'dsc' => 'Popis navrhované spolupráce',
        ]);

        if ($validator->fails()) {
            if($request->ajax()) {
                return response()->view('front.advertistingForm', ['errors' => $validator->errors(), 'request' => $request]);
            } else {
                return redirect()->route('advertising')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

		$emailFrom = $request->post('email');
		$phone = $request->post('phone');
		$dsc = (string)$request->post('dsc');
		$name = $request->post('person');
		$file = $request->post('upload');


		Mail::send('emails.reklama-na-webu', [
			'name' => $name,
			'phone' => $phone,
			'email' => $emailFrom,
			'dsc' => $dsc
		], function ($m) use ($emailFrom, $name, $file) {
//			$m->from($emailFrom, $name);
            $m->replyTo($emailFrom);
            $m->to("risakczexx@gmail.com");
			$m->subject("Zpráva z Reklamy na webu");
			if($file) {
				/** @var UploadedFile $file */
				$m->attach($file->getRealPath(), array(
					'as' => $file->getClientOriginalName(),
					'mime' => $file->getMimeType())
				);
			}
		});

        return redirect()->route('success-message');


	}

}
