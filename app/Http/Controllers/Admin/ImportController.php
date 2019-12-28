<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Model\Event;
use App\Model\Import;
use App\Model\UploadChunkPlupload;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use JonnyW\PhantomJs\Client;
use simple_html_dom;

class ImportController extends AdminBaseController{

	public function index() {
		$files = glob('../storage/app/temp/udalosti/*');
		$filesInfo = [];
		foreach($files as $file) {
			$filesInfo[] = [
				'file' => $file,
				'count' => Import::getEventsCount($file),
				'file_id' => uniqid()
			];
		}
		return view('admin.import.index', ['filesInfo' => $filesInfo]);
	}

	public function store(Request $request) {
		$file = $request->file('import_file');
		$file->storeAs("temp/udalosti/", $file->getClientOriginalName());
		return redirect('admin/import');
	}

	public function delete(Request $request) {
		unlink($request['file']);
		return redirect('admin/import');
	}

	public function import(Request $request) {
		//place this before any script you want to calculate time
		require_once('../vendor/simple_html_dom/simple_html_dom.php');

		$from = $request['from'];
		$to = $request['to'];
		$file = $request['file'];
		$fileId = $request['file_id'];


		$EventsArray = Import::getEventsArray($file, $from, $to);
		Import::importEvents($EventsArray, $from, $to);

		return response()->json([
			'success' => 1,
			'id' => $fileId . "_" . $from
		]);
	}


	public function testCurl() {
		$content = Import::curlImageDownload('https://scontent-prg1-1.xx.fbcdn.net/v/t1.0-9/79317802_2614606471949400_7998555464067448832_o.jpg?_nc_cat=101&_nc_ohc=-ehGYWWYTNIAQmIMrKv9oj_l6uAih2-ggFTtHFvkhjwdNZhj5HBWUOnIQ&_nc_ht=scontent-prg1-1.xx&oh=56849e0eda6e06db20754b2ae108e8aa&oe=5EAAE51F');
		$photo = fopen("event1" . ".jpg", 'w+');
		fwrite($photo, $content);

		dd($photo);

	}



}