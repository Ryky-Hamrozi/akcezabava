<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use Illuminate\Http\Request;
use App\Model\District;
use Illuminate\Support\Facades\DB;

class DistrictController extends AdminBaseController
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
        $priority = $request->get('priority');
        if($priority) {
            DB::table('districts')->update([
                'priority' => 0
            ]);
        }
        District::create(['name' => $name, 'priority' => $priority]);
        return response()->redirectToRoute('district.index');
    }

    public function update(UpdateDistrictRequest $request, District $district){
        $name = $request->get('name');
        $priority = $request->get('priority');
        if($priority) {
            DB::table('districts')->update([
                'priority' => 0
            ]);
        }
        $district->update(['name' => $name, 'priority' => $priority]);
        return response()->redirectToRoute('district.index');
    }

    public function getDistrictPlaces(Request $request){
        $districtId = $request->get('modelId');
        $district = District::findOrFail($districtId);
        $places = $district->places->pluck('name','id');
        return response()->json($places);
    }

}
