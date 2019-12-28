<?php

namespace App\Http\Controllers;

use App\Model\Banner;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class FrontBaseController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $itemsPerPage;

	public function __construct(){
		$this->itemsPerPage = 10;

		$leftBanner = Banner::where('location', '=', Banner::POSITION_LEFT)->first();
		$rightBanner = Banner::where('location', '=', Banner::POSITION_RIGHT)->first();
		$topBanner = Banner::where('location', '=', Banner::POSITION_UP)->first();


		$tempBannerLeftPath = "";
		$tempBannerRightPath = "";
		$tempBannerTopPath = "";

		if($leftBanner) {
			if($leftBanner->getImagePath()) {
				$tempBannerLeftPath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
					\App\Model\ImageGenerator::CONF_BANNER_SIDE,
					$leftBanner->id,
					$leftBanner->getImagePath()
				);
			}
		}
		if($rightBanner) {
			if ($rightBanner->getImagePath()) {
				$tempBannerRightPath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
					\App\Model\ImageGenerator::CONF_BANNER_SIDE,
					$rightBanner->id,
					$rightBanner->getImagePath()
				);
			}
		}
		if($topBanner) {
			if ($topBanner->getImagePath()) {
				$tempBannerTopPath = \App\Model\ImageGenerator::generateImageAndGetUrlPath(
					\App\Model\ImageGenerator::CONF_BANNER_TOP,
					$topBanner->id,
					$topBanner->getImagePath()
				);
			}
		}

		View::share([
			'leftBannerPath' => $tempBannerLeftPath,
			'leftBanner' => $leftBanner,
			'rightBannerPath' => $tempBannerRightPath,
			'rightBanner' => $rightBanner,
			'topBannerPath' => $tempBannerTopPath,
			'topBanner' => $topBanner
		]);
	}

}
