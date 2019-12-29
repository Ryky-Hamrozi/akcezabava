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



		$data = Import::getEventsArray($file, $from, $to);
		$udalostiErrors = $data['udalostiErrors'];

		Import::importEvents($data['udalostiArray']);

		return response()->json([
			'success' => 1,
			'id' => $fileId . "_" . $from,
			'errors' => json_encode($udalostiErrors)
		]);
	}


	public function testCurl() {
		$content = Import::getLocality('Všechovice (okres Přerov)');
		dd($content);

	}



}