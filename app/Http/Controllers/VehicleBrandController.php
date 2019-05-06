<?php

namespace App\Http\Controllers;

use App\VehicleBrandModel;
use App\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VehicleBrandController extends Controller
{
    public function index(){
        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Vehicle Brands']);

        //set index link
        config(['global.index_link' => 'vehicle_brand.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Brands Found']);
        config(['global.no_data_text' => 'You have not added any brand add first brand now']);
        config(['global.no_data_btn' => 'Add New Brand']);

        //set link add new
        config(['global.add_new_link' => '/vehicle-brand/create']);
        //set link update
        config(['global.update_link' => '/vehicle-brand/update']);

        //set delete
        config(['global.alert_delete_title' => 'This vehicle brand will be deleted.']);
        config(['global.delete_link' => 'master_delete.vehicle_brand']);
        config(['global.after_delete_text' => 'Vehicle brand has been deleted.']);
        config(['global.cant_delete_text' => 'The vehicle related to this brand exist.']);


            $master=VehicleBrandModel::all();
            $data=array(
                'master'=>$master
            );
            return view('vehicle.brand.index',$data);

    }
    public function create(){
        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Add new brand']);

        //set submit route
        config(['global.submit_link' => 'store.vehicle_brand']);
        //set index route
        config(['global.index_link' => '/vehicle-brands']);

        return view('vehicle.brand.create');
    }
    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:vehicle_brand,name'
            ]);

            if ($validator->passes()){
                $master=new VehicleBrandModel();
                $master->name=$request->name;
                $master->save();

                Session::flash('message', 'Brand have been added !');
                Session::flash('alert-type', 'success');

                return response()->json(['verify'=>'true']);
            }

            return ['errors' => $validator->errors(),'data'=>$request->all()];

    }
    public function update($id){
        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Edit Brand']);

        //set submit route
        config(['global.submit_link' => 'save_update.vehicle_brand']);
        //set index route
        config(['global.index_link' => '/vehicle-brands']);

        $master=VehicleBrandModel::where('id',$id)->first();
        return view('vehicle.brand.update')->with('master',$master);
    }
    public function save_update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100'
        ]);

        if ($validator->passes()){
            $current_name=VehicleBrandModel::where('id',$request->update_id)->first()->name;
            VehicleBrandModel::where('id',$request->update_id)->update([
                'name'=>$request->name
            ]);

            Session::flash('message', 'Brand have been updated !');
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
            VehicleBrandModel::where('id',$request->id)->delete();

        }else{

            //if have related master
            return response()->json(['delete'=>'false']);
        }


    }

//    Server Side
    function get_data()
    {
        $master=VehicleBrandModel::orderBy('id','DESC')->select();

        //return $products;
        return DataTables::of($master)->make(true);
    }
}
