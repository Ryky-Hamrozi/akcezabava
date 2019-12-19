<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use Illuminate\Http\Request;
use App\Model\Place;

class PlaceController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::paginate($this->itemsPerPage);
        return view('admin.place.list')->with(['places' => $places]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlaceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlaceRequest $request)
    {
        try{
            $name = $request->get('name');
            $districtId = $request->get('district');
            Place::create(['name' => $name, 'district_id' => $districtId]);
            flash('Místo  bylo úspěšně přidáno.')->success();
        }catch(\Exception $e){
            flash('Při ukládání došlo k chybě');
        }

        return response()->redirectToRoute('place.index');
    }

    public function update(UpdatePlaceRequest $request, Place $place){
        try{
            $name = $request->get('name');
            $districtId = $request->get('district');
            $place->update(['name' => $name, 'district_id' => $districtId]);
            flash('Místo  bylo úspěšně editováno.')->success();
        }catch(\Exception $e){
            flash('Při ukládání došlo k chybě');
        }

        return response()->redirectToRoute('place.index');
    }

}
