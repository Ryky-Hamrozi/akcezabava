<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use Illuminate\Http\Request;
use App\Model\District;

class DistrictController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::paginate($this->itemsPerPage);
        $topDistricts = District::getTopDistricts(5);
       return view('admin.district.list')->with(['districts' => $districts, 'topDistricts' => $topDistricts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDistrictRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDistrictRequest $request)
    {
        $name = $request->get('name');
        District::create(['name' => $name]);
        return response()->redirectToRoute('district.index');
    }

    public function update(UpdateDistrictRequest $request, District $district){
        $name = $request->get('name');
        $district->update(['name' => $name]);
        return response()->redirectToRoute('district.index');
    }

    public function getDistrictPlaces(Request $request){
        $districtId = $request->get('modelId');
        $district = District::findOrFail($districtId);
        $places = $district->places->pluck('name','id');
        return response()->json($places);
    }

}
