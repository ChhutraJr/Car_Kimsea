<?php

namespace App\Http\Controllers;

use App\VehicleModel;
use App\VehicleModelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VehicleModelController extends Controller
{

    public function index(){
        //Permission Start
        if (!config('global.add_customer')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Vehicle Models']);

        //set index link
        config(['global.index_link' => 'vehicle_model.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Models Found']);
        config(['global.no_data_text' => 'You have not added any model add first model now']);
        config(['global.no_data_btn' => 'Add New Model']);

        //set link add new
        config(['global.add_new_link' => '/vehicle-model/create']);
        //set link update
        config(['global.update_link' => '/vehicle-model/update']);

        //set delete
        config(['global.alert_delete_title' => 'This vehicle model will be deleted.']);
        config(['global.delete_link' => 'master_delete.vehicle_model']);
        config(['global.after_delete_text' => 'Vehicle model has been deleted.']);
        config(['global.cant_delete_text' => 'The vehicle related to this model exist.']);


        $master=VehicleModelModel::all();
        $data=array(
            'master'=>$master
        );
        return view('vehicle.model.index',$data);

    }
    public function create(){
        //Permission Start
        if (!config('global.add_customer')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Add Vehicle Model']);
        config(['global.parent_text_content_title' => 'Vehicle Models']);

        //set submit route
        config(['global.submit_link' => 'store.vehicle_model']);
        //set index route
        config(['global.index_link' => '/vehicle-models']);

        return view('vehicle.model.create');
    }
    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:vehicle_model,name'
            ]);

            if ($validator->passes()){
                $master=new VehicleModelModel();
                $master->name=$request->name;
                $master->save();

                Session::flash('message', 'Model have been added !');
                Session::flash('alert-type', 'success');

                return response()->json(['verify'=>'true']);
            }

            return ['errors' => $validator->errors(),'data'=>$request->all()];

    }


    public function model_name_validate(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:vehicle_model,name'
        ]);
        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }


    public function update($id){

        //Permission Start
        if (!config('global.add_customer')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Edit Vehicle Model']);
        config(['global.parent_text_content_title' => 'Vehicle Models']);

        //set submit route
        config(['global.submit_link' => 'save_update.vehicle_model']);
        //set index route
        config(['global.index_link' => '/vehicle-models']);

        $master=VehicleModelModel::where('id',$id)->first();
        return view('vehicle.model.update')->with('master',$master);
    }
    public function save_update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100'
        ]);

        if ($validator->passes()){
            $current_name=VehicleModelModel::where('id',$request->update_id)->first()->name;
            VehicleModelModel::where('id',$request->update_id)->update([
                'name'=>$request->name
            ]);

            Session::flash('message', 'Model have been updated !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true']);
        }
        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }
    public function delete(Request $request){

        $master=VehicleModel::where('model_id',$request->id)->count();
        //check if no related master
        if ($master==0){
            //delete master
            VehicleModelModel::where('id',$request->id)->delete();
        }else{
            //if have related master
            return response()->json(['delete'=>'false']);
        }

    }
//    Server Side
    function get_data()
    {
        $master=VehicleModelModel::orderBy('id','DESC')->select();

        //return $products;
        return DataTables::of($master)->make(true);
    }
}
