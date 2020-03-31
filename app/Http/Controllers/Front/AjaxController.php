<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\FrontBaseController;
use App\Model\Banner;
use App\Model\Category;
use App\Model\District;
use App\Model\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends FrontBaseController {

	public function getHomepageEventList(Request $request) {

		$eventList = $this->getEventsByRequest($request)['eventList'];

		$actionBanner = Banner::all()->where('location', '=', Banner::POSITION_EVENT_LIST);

		return response()->json([
			'events' => view('front.event.components.eventList',[
				'events' => $eventList,
				'actionBanner' => $actionBanner
			])->render()
		]);
	}

	public function getFilterEventList(Request $request) {
		$data = $this->getEventsByRequest($request);
		$eventList = $data['eventList'];

		$selectedDistrict = District::find($data['districtId']);
		$selectedCategory = Category::find($data['categoryId']);

		$date = $data['date'];

		$actionBanner = Banner::all()->where('location', '=', Banner::POSITION_EVENT_LIST);

		return response()->json([
			'events' => view('front.event.components.eventSearchFormListResult',[
				'events' => $eventList,
				'selectedDistrict' => $selectedDistrict,
				'selectedDate' => $date,
				'selectedCategory' => $selectedCategory,
				'actionBanner' => $actionBanner
			])->render(),
		]);
	}

	private function getEventsByRequest(Request $request) {
		$districtId = $request->input('district_id');
		$categoryId = $request->input('category_id');
		$date = strtotime($request->input('date_from'));

		$eventList = Event::where('approved','=', true);

		if($categoryId){
			$eventList->where('category_id',(int)$categoryId);
		}

		if($districtId) {
			$eventList->where('district_id',(int)$districtId);
		}

        /// Ukoncene akce nezobrazovat
        $eventList->whereDate('date_to', '>=', date('Y-m-d') .' 00:00:00');

		if($date) {
			$eventList->whereDate('date_from', '>=', date('Y-m-d', $date) .' 00:00:00');
		} else {
//			$eventList
//				->whereDate('date_from', '>=', date('Y-m-d'))
//				->whereDate('date_to', '>=', date('Y-m-d'));
		}



		$eventList->orderBy('date_from');

		$eventList = $eventList->paginate($this->itemsPerPage);
		//$eventList->appends([$request]);
		$eventList->withPath('?' . $request->getQueryString());

		$data['eventList'] = $eventList;
		$data['districtId'] = $districtId;
		$data['categoryId'] = $categoryId;
		$data['date'] = $date;

		return $data;
	}

	public function addFileCount(Request $request) {
        $fileId = $request->get('id');
        $file = DB::table('files_downloads')->where('id', '=', $fileId)->get()->first();
        $downloads = $file->downloads + 1;
        DB::table('files_downloads')->where('id', '=', $fileId)->update(['downloads' => $downloads]);
    }

}
