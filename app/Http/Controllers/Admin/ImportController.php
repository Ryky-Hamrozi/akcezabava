<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Model\Event;
use App\Model\Import;
use App\Model\UploadChunkPlupload;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
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
		Config::set('app.debug', true);
		$from = $request['from'];
		$to = $request['to'];
		$file = $request['file'];
		$fileId = $request['file_id'];

		$data = Import::getEventsArray($file, $from, $to);
		$udalostiErrors = $data['udalostiErrors'];
		$data = Import::importEvents($data['udalostiArray']);

		$udalostiErrors = array_merge($udalostiErrors, $data['udalostiErrors']);

		return response()->json([
			'success' => 1,
			'id' => $fileId . "_" . $from,
			'errors' => json_encode($udalostiErrors)
		]);
	}

	public function testCurl() {
        set_time_limit(99999);
	    Import::importPlaces();
	    die;
	    $content = Import::phantomJsGetContent("https://www.facebook.com/events/793174614428313/");
	    dd($content);
		$image = Import::curlImageDownload("https://scontent-prg1-1.xx.fbcdn.net/v/t1.0-9/71027177_2140754056028984_7270803062833283072_o.jpg?_nc_cat=109&_nc_ohc=vXfrF0gutn0AQm55Ozc89qkF4MJedspeX97iNvwvRTuZ2TyCFwQGQduYw&_nc_ht=scontent-prg1-1.xx&oh=cbffa29bc82b9d5303637c3ef26994eb&oe=5E9A1730");
//		$content = Import::phantomJsGetContent("https://www.facebook.com/events/discovery/");
		dd($image);

	}

	public function preimportuj() {
	    $events = Event::all()->where('fb_id', '!=', null);
	    Import::importEvents($events->toArray(), true);
    }



}
