<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Model\ImageGenerator;
use Illuminate\Http\Request;
use App\Model\Banner;
use App\Model\Image;

class BannerController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::paginate($this->itemsPerPage);
        return view('admin.banner.list')->with(['banners' => $banners]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBannerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerRequest $request)
    {
        $data = $this->getSaveData($request);
        $banner = Banner::create($data);
        if($request->has('image')){
            $image = new Image();
            $image->uploadImage($request->file('image'),$banner);
            ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_EVENT_HOMEPAGE_CAROUSEL, $banner->id);
            ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_BANNER_HOMEPAGE_ACTION, $banner->id);
            ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_BANNER_SIDE, $banner->id);
            ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_BANNER_TOP, $banner->id);
        }
        return response()->redirectToRoute('banner.index');
    }

    public function update(UpdateBannerRequest $request, Banner $banner){
        $data = $this->getSaveData($request);
        $banner->update($data);
        if($request->has('image')){
            $banner->image->delete();
            $image = new Image();
            $image->uploadImage($request->file('image'),$banner);
            ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_EVENT_HOMEPAGE_CAROUSEL, $banner->id);
            ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_BANNER_HOMEPAGE_ACTION, $banner->id);
            ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_BANNER_SIDE, $banner->id);
            ImageGenerator::deleteGeneratedImage(ImageGenerator::CONF_BANNER_TOP, $banner->id);
        }
        return response()->redirectToRoute('banner.index');
    }

    private function getSaveData(Request $request)
    {
        $data = [];
        $data['name'] = $request->get('name');
        $data['location'] = $request->get('location');
        $data['event_id'] = $request->get('event') != 0 ? $request->get('event') : null;
        $data['url'] = $request->get('url');

        return $data;
    }

}
