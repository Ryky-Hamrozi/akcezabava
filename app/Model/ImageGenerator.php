<?php

namespace App\Model;

class ImageGenerator {

	const
		TEMP_FOLDER_NAME = "/temp";

	const
		CONF_EVENT_HOMEPAGE_LIST = "homepage_event_list",
		CONF_EVENT_DETAIL = "event_detail",
		CONF_EVENT_HOMEPAGE_CAROUSEL = "homepage_event_carousel",

		CONF_BANNER_EVENT_DETAIL = "banner_event_detail",
		CONF_BANNER_HOMEPAGE_ACTION = "homepage_banner_action_list",
		CONF_BANNER_SIDE  = "front_banner_side",
		CONF_BANNER_TOP = "front_banner_top";

	const
		THUMBNAIL_PREFIX = "thumbnail",
		WIDTH = "width",
		HEIGHT = "height",
		METHOD = "method";

	const
		METHOD_FIT = "fit",
		METHOD_CROP = "crop",
		METHOD_TRIM = "trim";

	static $conf = [
		self::CONF_EVENT_HOMEPAGE_CAROUSEL => [
			self::THUMBNAIL_PREFIX => self::CONF_EVENT_HOMEPAGE_CAROUSEL,
			self::WIDTH => 720,
			self::HEIGHT => 420,
			self::METHOD => self::METHOD_FIT,
		],
		self::CONF_BANNER_HOMEPAGE_ACTION => [
			self::THUMBNAIL_PREFIX => self::CONF_BANNER_HOMEPAGE_ACTION,
			self::WIDTH => 330,
			self::HEIGHT => 400,
			self::METHOD => self::METHOD_FIT,
		],
		self::CONF_EVENT_HOMEPAGE_LIST => [
			self::THUMBNAIL_PREFIX => self::CONF_EVENT_HOMEPAGE_LIST,
			self::WIDTH => 460,
			self::HEIGHT => 180,
			self::METHOD => self::METHOD_FIT,
		],
		self::CONF_EVENT_DETAIL => [
			self::THUMBNAIL_PREFIX => self::CONF_EVENT_DETAIL,
			self::WIDTH => 680,
			self::HEIGHT => 244,
			self::METHOD => self::METHOD_FIT,
		],
		self::CONF_BANNER_SIDE => [
			self::THUMBNAIL_PREFIX => self::CONF_BANNER_SIDE,
			self::WIDTH => 439,
			self::HEIGHT => 980,
			self::METHOD => self::METHOD_FIT
		],
		self::CONF_BANNER_TOP => [
			self::THUMBNAIL_PREFIX => self::CONF_BANNER_TOP,
			self::WIDTH => 1110,
			self::HEIGHT => 200,
			self::METHOD => self::METHOD_FIT
		],
		self::CONF_BANNER_EVENT_DETAIL => [
			self::THUMBNAIL_PREFIX => self::CONF_BANNER_EVENT_DETAIL,
			self::WIDTH => 310,
			self::HEIGHT => 321,
			self::METHOD => self::METHOD_FIT
		]
	];


	/**
	 * @param $confIndex
	 * @param $id
	 * @param $path
	 * @return string
	 * Vygeneruje tempove obrazky zmenseniny obsluhuje Intervention image knihovnu
	 */
	public static function generateImageAndGetUrlPath($confIndex, $id, $path) {

		$ext = pathinfo($path, PATHINFO_EXTENSION);

		$newImagePath = public_path() . self::TEMP_FOLDER_NAME . "/" . $id . "_" . self::$conf[$confIndex][self::THUMBNAIL_PREFIX] . "." . $ext;
		$urlPath = self::TEMP_FOLDER_NAME . "/" . $id . "_" . self::$conf[$confIndex][self::THUMBNAIL_PREFIX] . "." . $ext;

		/// Pokud fotka existuje uz negeneruj
		if(file_exists($newImagePath)) {
			return $urlPath . "?v=" . filemtime($newImagePath) ;
		}

		$newImage = \Intervention\Image\Facades\Image::make($path);

		//// Ma zvolenou metodu vygenerovani obrazku?
		if(isset(self::$conf[$confIndex][self::METHOD])) {
			switch(self::$conf[$confIndex][self::METHOD]) {
				//// Metoda fit vygeneruje obrazek aby se rovnal prislusnemu rozliseni
				case self::METHOD_FIT : {
					$newImage->fit(
						self::$conf[$confIndex][self::WIDTH],
						self::$conf[$confIndex][self::HEIGHT]
					);
					break;
				}
				/// Crop oreze vse co presahuje rozliseni temp obrazku
				case self::METHOD_CROP : {
					$newImage->crop(
						self::$conf[$confIndex][self::WIDTH],
						self::$conf[$confIndex][self::HEIGHT]
					);
					break;
				}
				///
				case self::METHOD_TRIM : {

				}
			}
		} else {
			$newImage->resize(
				self::$conf[$confIndex][self::WIDTH],
				self::$conf[$confIndex][self::HEIGHT]
			);
		}
		$newImage->save($newImagePath);

		return $urlPath . "?v=" . filemtime($newImagePath);
	}

	/**
	 * @param $confIndex
	 * @param $id
	 * @param $multipleImages - kdyz je obrazku k jednomu produktu vice...
	 * Smaze generovany temp image podle confIndexu
	 */
	public static function deleteGeneratedImage($confIndex, $id, $multipleImages = false) {
		$pathTempImagesRegex = public_path() . self::TEMP_FOLDER_NAME . "/" . $id . "_" . self::$conf[$confIndex][self::THUMBNAIL_PREFIX].".*";

		if($multipleImages) {
			$pathTempImagesRegex = public_path() . self::TEMP_FOLDER_NAME . "/" . $id . "-*_" . self::$conf[$confIndex][self::THUMBNAIL_PREFIX].".*";
		}

		foreach(glob($pathTempImagesRegex) as $file) {
			unlink($file);
		}
	}
}