<?php

namespace App\Http\Controllers;



use App\VehicleColorModel;
use App\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VehicleColorController extends Controller
{
    public function index(){
        //Permission Start
        if (!config('global.add_customer')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Vehicle Colors']);

        //set index link
        config(['global.index_link' => 'vehicle_color.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Colors Found']);
        config(['global.no_data_text' => 'You have not added any color add first color now']);
        config(['global.no_data_btn' => 'Add New Color']);

        //set link add new
        config(['global.add_new_link' => '/vehicle-color/create']);
        //set link update
        config(['global.update_link' => '/vehicle-color/update']);

        //set delete
        config(['global.alert_delete_title' => 'This vehicle color will be deleted.']);
        config(['global.delete_link' => 'master_delete.vehicle_color']);
        config(['global.after_delete_text' => 'Vehicle color has been deleted.']);
        config(['global.cant_delete_text' => 'The vehicle related to this color exist.']);


            $master=VehicleColorModel::all();
            $data=array(
                'master'=>$master
            );
            return view('vehicle.color.index',$data);

    }
    public function create(){
        //Permission Start
        if (!config('global.add_customer')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Add Vehicle Color']);
        config(['global.parent_text_content_title' => 'Vehicle Colors']);

        //set submit route
        config(['global.submit_link' => 'store.vehicle_color']);
        //set index route
        config(['global.index_link' => '/vehicle-colors']);

        return view('vehicle.color.create');
    }
    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:vehicle_color,name'
            ]);

            if ($validator->passes()){
                $master=new VehicleColorModel();
                $master->name=$request->name;
                $master->save();

                Session::flash('message', 'Color have been added !');
                Session::flash('alert-type', 'success');

                return response()->json(['verify'=>'true']);
            }

            return ['errors' => $validator->errors(),'data'=>$request->all()];

    }

    public function color_name_validate(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:vehicle_color,name'
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
        config(['global.text_content_title' => 'Edit Vehicle Color']);
        config(['global.parent_text_content_title' => 'Vehicle Colors']);

        //set submit route
        config(['global.submit_link' => 'save_update.vehicle_color']);
        //set index route
        config(['global.index_link' => '/vehicle-colors']);

        $master=VehicleColorModel::where('id',$id)->first();
        return view('vehicle.color.update')->with('master',$master);
    }
    public function save_update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100'
        ]);

        if ($validator->passes()){
            $current_name=VehicleColorModel::where('id',$request->update_id)->first()->name;
            VehicleColorModel::where('id',$request->update_id)->update([
                'name'=>$request->name
            ]);

            Session::flash('message', 'Color have been updated !');
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
            VehicleColorModel::where('id',$request->id)->delete();

        }else{

            //if have related master
            return response()->json(['delete'=>'false']);
        }


    }

//    Server Side
    function get_data()
    {
        $master=VehicleColorModel::orderBy('id','DESC')->select();

        //return $products;
        return DataTables::of($master)->make(true);
    }
}
