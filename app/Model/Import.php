<?php

namespace App\Model;

use App\Model\Event;
use Illuminate\Database\Eloquent\Model;
use JonnyW\PhantomJs\Client;
use simple_html_dom;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Import extends Model
{
	public static function rand_color() {
		return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
	}

	public static function formatDescription($description) {
		$description = str_replace("\r\n" , '<br>', $description);
		$description = str_replace("&amp;" , '', $description);
		return "<p>" . $description . "</p>";
	}

	public static function formatTitle($title) {
		$out = str_replace('&amp;', '', $title);
		return $out;
	}

	public static function importEvents($eventsArray) {
		$i = 0;

		$udalostiErrors = [];

		foreach($eventsArray as $event) {

			//// 10 prvku by měla mit udalost
			if(count($event) < 7) {
				$udalostiErrors[] = array(
					'fb_url' => $event['fb_url'],
					'fb_id' => $event['fb_id'],
					'error' => 'Udalost bude preskocena byla spatne naimportovana zkuste to znovu'
				);

				continue;
			}

			/// Nekdy se stava ze eventy prochazi prazdne zatim nvm proc
			if(!isset($event['fb_id'])) {
				continue;
			}

			/// Event existuje
			if($Event = Event::where('fb_id', '=', $event['fb_id'])->first()) {
				continue;
			}


			if(!$District = District::where('name', '=', $event['district'])->first()) {
				$District = new District();
				$District->fill([
					'name' => $event['district']
				]);
				$District->save();
			}

			if(!$Place = Place::where('name', '=', $event['place'])->first()) {
				$Place = new Place();
				$Place->fill([
					'name' => trim($event['place']),
					'district_id' => $District->id
				]);
				$Place->save();
			}

			$categories = [];
			/// Category?
			if(isset($event['keywords'])) {
				foreach(explode(',', $event['keywords']) as $keyword) {
					if(!$Category = Category::where('name', '=', $keyword)->first()) {
						$Category = new Category();
						$Category->fill([
							'name' => $keyword,
							'foreColor' => self::rand_color(),
							'backColor' => self::rand_color()
						]);

						$Category->save();
					}

					$categories[] = $Category->id;
				}
			}

			$Event = new Event();
			$Event->fill([
//				'id' => $event['id'],
				'fb_id' => $event['fb_id'],
				'title' => self::formatTitle($event['title']),
				'description' => self::formatDescription($event['description']),
				'fb_url' => $event['fb_url'],
//				'place_text' => $event['place_text'],
				'date_from' => $event['date_from'],
				'date_to' => $event['date_to'],
				'approved' => $event['approved'],
				'district_id' => $District->id,
				'place_id' => $Place->id,
				'categories' => implode(',', $categories),
				'category_id' => isset($Category) ? $Category->id : 1,
				'contact_id' => 1,
				'keywords' => isset($event['keywords']) ? $event['keywords'] : ""
			]);
			$Event->save();

			$image = self::curlImageDownload($event['image']);
			$path = public_path() . "/" . $Event->id . ".jpg";
			$photo = fopen($path, 'w+');
			fwrite($photo, $image);

			$Image = new ImageImport();
			$Image->uploadImage($path, $Event);
			unlink($path);

			$i++;
		}

		return [
			'udalostiErrors' => $udalostiErrors
		];
	}

	public static function getEventsCount($file) {
		require_once('../vendor/simple_html_dom/simple_html_dom.php');
		$html = file_get_contents($file);

		$dom = new simple_html_dom();
		$dom->load($html);

		/// Seznam udalosti UL
		$udalostiLi = $dom->find('ul[class="uiList _4kg _6-i _6-h _6-j"] li');
		$count = 0;

		foreach($udalostiLi as $li) {
			$nazev = $li->find('a._7ty', 0);
			if(!$nazev) {
				continue;
			}
			$count++;
		}

		return $count;
	}

	public static function getEventsArray($file, $from, $to) {
		require_once('../vendor/simple_html_dom/simple_html_dom.php');

		$html = file_get_contents($file);

		$dom = new simple_html_dom();
		$dom->load($html);

		/// Seznam udalosti UL
		$udalostiUl = $dom->find('ul[class="uiList _4kg _6-i _6-h _6-j"]');

		$udalostiArray = [];
		$udalostiErrors = [];

		foreach($udalostiUl as $ul) {
			$i = 0;
			foreach($ul->find('li') as $li) {

				$nazev = $li->find('a._7ty', 0);
				if(!$nazev) {
					continue;
				}

				if($i < $from) {
					$i++;
					continue;
				}

				if($i >= $to) {
					break;
				}

				$udalost = [];

				if($nazev){
					$udalost['title'] = $nazev->plaintext;
					$href = $nazev->href;
					$url = $href;
					$exploded = explode('/', parse_url($url, PHP_URL_PATH));
					$id = $exploded[2];
					$udalost['fb_url'] = "https://www.facebook.com/events/".$id;
					$udalost['fb_id'] = $id;

					$udalostInfo = self::vratOstatniInformaceZEventu("https://www.facebook.com/events/".$udalost['fb_id']);
					$udalost = array_merge($udalost, $udalostInfo);

					//// Udalosti ktere vyzaduji nejspis prihlaseni preskocit
					//// Nema vice nez dve informace
					if(count($udalostInfo) < 2) {
						$udalostiErrors[] = array(
							'fb_url' => $udalost['fb_url'],
							'fb_id' => $udalost['fb_id'],
							'error' => 'Událost vyžaduje přihlášení byla přeskočena'
						);
						continue;
					}
				} else {
				}

				$udalost['approved'] = false;

				/// Pokud neni obrazek z detailu?
				if(isset($udalost['image']) && !$udalost['image']) {
					/// vem ho ze seznamu
					if($image = $li->find('._5i4g.img', 0)) {
						$udalost['image'] = htmlspecialchars_decode($image->src);
					}
				}

				$udalostiArray[] = $udalost;
				$i++;
			}
		}


		return array(
			'udalostiArray' => $udalostiArray,
			'udalostiErrors' => $udalostiErrors
		);

	}

	public static function getLocality($address) {
		$address = str_replace(' ', '+', $address);
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyAnaBpf8OAbqCLf8Cg7rowpjEmubbswZfA";

		// Decode json
		$json = self::curlDownload($url);
		$decoded_json = json_decode($json);

		$locality = false;
		$administrative_area_level_2 = false;

		foreach($decoded_json->results as $results) {
			foreach($results->address_components as $address_components) {
				// Check types is set then get first element (may want to loop through this to be safe,
				// rather than getting the first element all the time)
				if(isset($address_components->types) && $address_components->types[0] == 'administrative_area_level_2') {
					// Do what you want with data here
					$administrative_area_level_2 = $address_components->long_name;
				}
				if(isset($address_components->types) && $address_components->types[0] == 'locality') {
					// Do what you want with data here
					$locality = $address_components->long_name;
				}
			}
		}

		if(!$locality) {
			$administrative_area_level_2 = str_replace('-město', '', $administrative_area_level_2);
			return $administrative_area_level_2;
		}

		return $locality;
	}

	public static function vratOstatniInformaceZEventu($eventUrl) {
		$data = self::phantomJsGetContent($eventUrl);

		$html = new simple_html_dom();
		$html->load($data);

		$info = [];

		if($place = $html->find('._3xd0._3slj div[class="_5xhp fsm fwn fcg"]', 0)) {
			$place = $place->plaintext;
			if(!$place) {
				if($place = $html->find('._3xd0._3slj ._6a ._6a._6b ._xkh a._5xhk', 0)) {
					$place = $place->plaintext;
				}
			}
			$exploded = explode(',', $place);

			if($club = $html->find('._6a._6b ._xkh a._5xhk', 0)) {
				$club = $club->plaintext;
			}

			/// Mesto je vzdy na konci
//			$district = $exploded[count($exploded) - 1];

			$info['district'] = self::getLocality($place);
			$info['place'] = $club . " " . $place;
		}

		if($popis = $html->find('._63eu ._63ew span',0)) {
			$info['description'] = $popis->plaintext;
		}

		if($date = $html->find('._2ycp._5xhk', 0)) {

			if(strpos($date->content, 'to') !== false) {
				list($dateFrom, $dateTo) = explode(' to ', $date->content);
			} else {
				$dateFrom = $date->content;
				$dateTo = $date->content;
			}

			$dateFrom = new \DateTime($dateFrom);
			$dateFrom->modify("+9 hours"); ///Facebook logika skrytych hodin
			$dateTo = new \DateTime($dateTo);
			$dateTo->modify('+9 hours'); ///Facebook logika skrytych hodin
			$info['date_from'] = $dateFrom->format('Y-m-d H:i:s');
			$info['date_to'] = $dateTo->format('Y-m-d H:i:s');
		}

		if($slova = $html->find('ul._63er li a')) {
			$slovaArray = [];
			foreach($slova as $slovo) {
				$slovaArray[] = $slovo->plaintext;
			}
			$info['keywords'] = implode(',', $slovaArray);
		}

		if($image = $html->find('._3kwh a', 0)) {
			$property = 'data-ploi';
			$info['image'] = htmlspecialchars_decode($image->$property);
		} else {
			/// Neni to obrazek? tak je to video musime ho vzít z náhledu udalosti (spatna kvalita..)
			$info['image'] = false;
		}


		return $info;
	}

	public static function phantomJsGetContent($url, $image = false) {

		require_once('phantomJs/vendor/autoload.php');

		$client = Client::getInstance();
		if($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
			$client->getEngine()->setPath(public_path() . '/phantomJs/bin/phantomjs.exe');
		} else {
			$client->getEngine()->setPath(public_path() . '/phantomJs/bin/linux-phantomjs');
		}
		$request = $client->getMessageFactory()->createRequest($url, 'GET');

		if($image) {
			$request = $client->getMessageFactory()->createCaptureRequest($url, 'GET');
			$request->setOutputFile('test1.jpg');
		}

		/**
		 * @see JonnyW\PhantomJs\Http\Response
		 **/
		$response = $client->getMessageFactory()->createResponse();

// Send the request
		$client->send($request, $response);

		if($response->getStatus() === 200) {

			// Dump the requested page content
			return $response->getContent();
		}

		echo $client->getLog();
	}

	public static function curlDownload($url) {

		$header = array(
//			'access-control-allow-origin: *',
//			'alt-svc: quic=":443"; ma=2592000; v="46,43",h3-Q050=":443"; ma=2592000,h3-Q049=":443"; ma=2592000,h3-Q048=":443"; ma=2592000,h3-Q046=":443"; ma=2592000,h3-Q043=":443"; ma=2592000',
			'cache-control: no-cache, must-revalidate',
//			'content-encoding: gzip',
//			'content-length: 538',
			'content-type: application/json; charset=UTF-8',
			'date: Sat, 28 Dec 2019 20:09:13 GMT',
			'expires: Fri, 01 Jan 1990 00:00:00 GMT',
			'pragma: no-cache',
			'server: mafe',
			'server-timing: gfet4t7; dur=45',
			'status: 200',
			'vary: Accept-Language',
			'x-frame-options: SAMEORIGIN',
			'x-xss-protection: 0',
		);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$data = curl_exec( $ch );
		return $data;

	}

	public static function curlImageDownload($url) {

		$header = array(
//			':authority: scontent-prg1-1.xx.fbcdn.net',
//			':method: GET',
//			':path: /v/t1.0-9/79317802_2614606471949400_7998555464067448832_o.jpg?_nc_cat=101&_nc_ohc=-ehGYWWYTNIAQmIMrKv9oj_l6uAih2-ggFTtHFvkhjwdNZhj5HBWUOnIQ&_nc_ht=scontent-prg1-1.xx&oh=56849e0eda6e06db20754b2ae108e8aa&oe=5EAAE51F',
//			':scheme: https',
			'accept: image/webp,image/apng',
			'accept-encoding: gzip, deflate, br',
			'accept-language: cs-CZ,cs;q=0.9',
			'cache-control: no-cache',
			'pragma: no-cache',
			'sec-fetch-mode: navigate',
			'sec-fetch-site: none',
			'sec-fetch-user: ?1',
			'upgrade-insecure-requests: 1',
			'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',
		);

		$ch = curl_init($url);
		if($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
//			curl_setopt( $ch, CURLOPT_POST, true );
//			curl_setopt( $ch, CURLOPT_REFERER, 'origin-when-cross-origin' );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt( $ch, CURLOPT_HEADER, false );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSLVERSION, 32);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
		}
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$data = curl_exec( $ch );
		return $data;

	}




}
