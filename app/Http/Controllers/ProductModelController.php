<?php

namespace App\Http\Controllers;

use App\ProductModel;
use App\ProductModelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductModelController extends Controller
{
    public function index(){
        //Permission Start
        if (!config('global.add_product')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Product Models']);

        //set index link
        config(['global.index_link' => 'product_model.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Models Found']);
        config(['global.no_data_text' => 'You have not added any model add first model now']);
        config(['global.no_data_btn' => 'Add New Model']);

        //set link add new
        config(['global.add_new_link' => '/product-model/create']);
        //set link update
        config(['global.update_link' => '/product-model/update']);

        //set delete
        config(['global.alert_delete_title' => 'This product model will be deleted.']);
        config(['global.delete_link' => 'master_delete.product_model']);
        config(['global.after_delete_text' => 'Product model has been deleted.']);
        config(['global.cant_delete_text' => 'The product related to this model exist.']);


            $master=ProductModelModel::all();
            $data=array(
                'master'=>$master
            );
            return view('product.model.index',$data);

    }
    public function create(){
        //Permission Start
        if (!config('global.add_product')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Add Product Model']);
        config(['global.parent_text_content_title' => 'Product Models']);

        //set submit route
        config(['global.submit_link' => 'store.product_model']);
        //set index route
        config(['global.index_link' => '/product-models']);

        return view('product.model.create');
    }
    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:product_model,name'
            ]);

            if ($validator->passes()){
                $master=new ProductModelModel();
                $master->name=$request->name;
                $master->save();

                Session::flash('message', 'Model have been added !');
                Session::flash('alert-type', 'success');

                return response()->json(['verify'=>'true']);
            }

            return ['errors' => $validator->errors(),'data'=>$request->all()];

    }
    public function update($id){
        //Permission Start
        if (!config('global.add_product')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Edit Product Model']);
        config(['global.parent_text_content_title' => 'Product Models']);

        //set submit route
        config(['global.submit_link' => 'save_update.product_model']);
        //set index route
        config(['global.index_link' => '/product-models']);

        $master=ProductModelModel::where('id',$id)->first();
        return view('product.model.update')->with('master',$master);
    }
    public function save_update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100'
        ]);

        if ($validator->passes()){
            $current_name=ProductModelModel::where('id',$request->update_id)->first()->name;
            ProductModelModel::where('id',$request->update_id)->update([
                'name'=>$request->name
            ]);

            Session::flash('message', 'Model have been updated !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true']);
        }
        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }
    public function delete(Request $request){

        $pro=ProductModel::where('model_id',$request->id)->count();
        //check if no related master
        if ($pro==0){
            //delete master
            ProductModelModel::where('id',$request->id)->delete();

        }else{

            //if have related master
            return response()->json(['delete'=>'false']);
        }


    }

//    Server Side
    function get_data()
    {
        $master=ProductModelModel::orderBy('id','DESC')->select();

        //return $products;
        return DataTables::of($master)->make(true);
    }
}
