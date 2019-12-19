<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Model\Category;
use App\Model\District;
use App\Model\Event;
use Illuminate\Http\Request;

class AdminController extends AdminBaseController
{
    protected $groupActions;

    public function __construct(){
        parent::__construct();
        $this->groupActions  = [
            'delete' => [$this,'groupDelete'],
        ];
    }

    public function dashboard(){
        $topDistricts = District::getTopDistricts(5);
        $topCategories = Category::getTopCategories(5);
        $event = new Event();
        return view('admin.dashboard',['topDistricts' => $topDistricts, 'topCategories' => $topCategories, 'event' => $event]);
    }


    public function proceedGroupAction(Request $request){
       $method = $request->get('action');

       $modelClass = $request->get('model');
       $ids = $request->get('ids');

       if(isset($this->groupActions[$method])){
            call_user_func_array($this->groupActions[$method],[$modelClass,$ids]);
       }
       return redirect()->back();
    }

    public function groupDelete($modelClass,$ids){
        $model = new $modelClass();
        $items = $model->find($ids);
        if($items){
            foreach($items as $item){
                $item->delete();
            }
        }
    }

}
