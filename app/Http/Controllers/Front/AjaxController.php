<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\FrontBaseController;
use App\Model\Category;
use App\Model\District;
use App\Model\Event;
use Illuminate\Http\Request;

class AjaxController extends FrontBaseController {

	public function getHomepageEventList(Request $request) {

		$eventList = $this->getEventsByRequest($request)['eventList'];

		return response()->json([
			'events' => view('front.event.components.eventList',['events' => $eventList->get()])->render()
		]);
	}

	public function getFilterEventList(Request $request) {
		$data = $this->getEventsByRequest($request);
		$eventList = $data['eventList'];

		$selectedDistrict = District::find($data['districtId']);
		$selectedCategory = Category::find($data['categoryId']);

		$date = $data['date'];

		return response()->json([
			'events' => view('front.event.components.eventSearchFormListResult',[
				'events' => $eventList->get(),
				'selectedDistrict' => $selectedDistrict,
				'selectedDate' => $date,
				'selectedCategory' => $selectedCategory
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

		if($date) {
			$eventList->whereDate('date_from', '>=', date('Y-m-d', $date) .' 00:00:00');
		} else {
			$eventList
				->whereDate('date_from', '>=', date('Y-m-d'))
				->whereDate('date_to', '>=', date('Y-m-d'));
		}

		$eventList->orderBy('date_from');
		$data['eventList'] = $eventList;
		$data['districtId'] = $districtId;
		$data['categoryId'] = $categoryId;
		$data['date'] = $date;

		return $data;
	}

}