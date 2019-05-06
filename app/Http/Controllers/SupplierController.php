<?php

namespace App\Http\Controllers;

use App\ProductModel;
use App\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index(){
        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Suppliers']);

        //set index link
        config(['global.index_link' => 'supplier.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Suppliers Found']);
        config(['global.no_data_text' => 'You have not added any supplier add first supplier now']);
        config(['global.no_data_btn' => 'Add New Supplier']);

        //set link add new
        config(['global.add_new_link' => '/supplier/create']);
        //set link update
        config(['global.update_link' => '/supplier/update']);

        //set delete
        config(['global.alert_delete_title' => 'This supplier will be deleted.']);
        config(['global.delete_link' => 'master_delete.supplier']);
        config(['global.after_delete_text' => 'Supplier has been deleted.']);
        config(['global.cant_delete_text' => 'The related to this supplier exist.']);


            $master=SupplierModel::all();
            $data=array(
                'master'=>$master
            );

            return view('supplier.index',$data);

    }
    public function create(){
        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Add Supplier']);
        config(['global.parent_text_content_title' => 'Suppliers']);

        //set submit route
        config(['global.submit_link' => 'store.supplier']);
        //set index route
        config(['global.index_link' => '/suppliers']);

        return view('supplier.create');
    }
    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:supplier,name'
            ]);

            if ($validator->passes()){
                $master=new SupplierModel();
                $master->name=$request->name;
                $master->save();

                Session::flash('message', 'Supplier have been added !');
                Session::flash('alert-type', 'success');

                return response()->json(['verify'=>'true']);
            }

            return ['errors' => $validator->errors(),'data'=>$request->all()];

    }

//supplier_name_validate

    public function supplier_name_validate(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:supplier,name'
        ]);
        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }

    public function update($id){
        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Edit Supplier']);
        config(['global.parent_text_content_title' => 'Suppliers']);

        //set submit route
        config(['global.submit_link' => 'save_update.supplier']);
        //set index route
        config(['global.index_link' => '/suppliers']);

        $master=SupplierModel::where('id',$id)->first();
        return view('supplier.update')->with('master',$master);
    }
    public function save_update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100'
        ]);

        if ($validator->passes()){
            $current_name=SupplierModel::where('id',$request->update_id)->first()->name;
            SupplierModel::where('id',$request->update_id)->update([
                'name'=>$request->name
            ]);

            Session::flash('message', 'Supplier have been updated !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true']);
        }
        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }
    public function delete(Request $request){

        $pro=ProductModel::where('supplier_id',$request->id)->count();
        //check if no related master
        if ($pro==0){
            //delete master
            SupplierModel::where('id',$request->id)->delete();

        }else{

            //if have related product
            return response()->json(['delete'=>'false']);
        }



    }

//    Server Side
    function get_data()
    {
        $master=SupplierModel::orderBy('id','DESC')->select();

        //return $products;
        return DataTables::of($master)->make(true);
    }
}
