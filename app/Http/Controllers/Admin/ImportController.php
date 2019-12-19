<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use simple_html_dom;

class ImportController extends AdminBaseController{

	public function index() {
		return view('admin.import.index');
	}

	public function store(Request $request) {

		//place this before any script you want to calculate time
		$time_start = microtime(true);

		require_once('../vendor/simple_html_dom/simple_html_dom.php');
		$file = $request->file('import_file');

		//// Ulozime si soubor
		$file->storeAs('/temp/udalosti', $file->getClientOriginalName());

		$html = file_get_contents('../storage/app/temp/udalosti/' . $file->getClientOriginalName());

		$dom = new simple_html_dom();
		$dom->load($html);

		/// Seznam udalosti UL
		$udalostiUl = $dom->find('ul[class="uiList _4kg _6-i _6-h _6-j"]');

		$udalostiArray = [];

		foreach($udalostiUl as $ul) {
			$i = 1;
			foreach($ul->find('li') as $li) {
				$udalost = [];

				if($nazev = $li->find('a._7ty', 0)){
					$udalost['nazev'] = $nazev->plaintext;
					$href = $nazev->href;
					$id = explode('/', $href)[2];
					$udalost['url'] = $href;
					$udalost['id'] = $id;
				}

				if($popis = $li->find('p._4etw span', 0)) {
					$udalost['popis'] = $popis->plaintext;
				}

				$udalost = array_merge($udalost, $this->vratOstatniInformaceZEventu("https://facebook.com/events/".$udalost['id']));


				$udalostiArray[] = $udalost;

			}
		}

		$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes otherwise seconds
		$execution_time = ($time_end - $time_start)/60;

		dump($execution_time);
		dd($udalostiArray);


//		dump($dom);

		dd("aaa");

	}

	public function vratOstatniInformaceZEventu($eventUrl) {
		$data = $this->curlDownload($eventUrl);
		file_put_contents('../storage/app/temp/udalosti/test.html', $data);
		$html = new simple_html_dom();
		$html->load($data);

		dump($html->doc);
		dd($html->find('*[class="_2ycp _5xhk"]', 0));

		$info = [];

		if($date = $html->find('*[class="_2ycp _5xhk"]', 0)) {
			$info['date'] = $date->content;
		}

		if($district = $html->find('div[class="_5xhp fsm fwn fcg"]')) {
			$info['district'] = $district->plaintext;
		}

		dd($info);

		return $info;
	}

	public function vratObrazekZPodstranky($imageUrlHref) {

	}


	private function curlDownload($url) {
		$ch = curl_init($url);
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_REFERER, 'origin-when-cross-origin' );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36");
		curl_setopt( $ch, CURLINFO_CONTENT_TYPE, "application/x-www-form-urlencoded" );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, 32);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$data = curl_exec( $ch );
		return $data;

	}

	public function testCurl() {
		require_once('../vendor/simple_html_dom/simple_html_dom.php');
		$data = $this->curlDownload("https://facebook.com/events/394953048124975");
		$html = new simple_html_dom();
		$html->load($data);

		if($popis = $html->find('*[class="_62hs _4-u3"]',0)) {
			dd($popis->plaintext);
		}

		dd($html->plaintext);
	}



}