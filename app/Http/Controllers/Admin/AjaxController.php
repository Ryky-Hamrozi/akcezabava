<?php

namespace App\Http\Controllers\Admin;

class AjaxController extends AdminController
{

    public function getModalContent(){
        $data = request()->except('_token');
        $viewFolder = strtolower(explode('\\',$data['model'])[2]);
        $model = $data['model']::find($data['id']);
        return response()->json(['modal' => view('admin.'.$viewFolder.'.addModal',['item' => $model])->render()]);

    }

    public function removeModel(){
        $data = request()->except('_token');
        $model = $data['model']::find($data['id']);
        $success = $model->delete();
        if($success){
            return response('OK',200);
        }
        else{
            return response('Error',404);
        }
    }

    public function changePieChart(){
        $modelClass = request()->get('model');
        $id = request()->get('id');
        $model = $modelClass::find($id);
        $upcomingCount = $model->getUpcomingEventsCount();
        $forApprovalCount = $model->getForApprovalEventsCount();
        $finishedCount = $model->getFinishedEventsCount();
        return response()->json(['upcomingCount' => $upcomingCount,'forApprovalCount' => $forApprovalCount, 'finishedCount' => $finishedCount]);
    }

}
