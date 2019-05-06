<?php

namespace App\Http\Controllers;

use App\ProductUseForModel;
use App\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductUseForController extends Controller
{
    public function index(){
        //Permission Start
        if (!config('global.add_product')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Product Use For']);

        //set index link
        config(['global.index_link' => 'product_use_for.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Use For Found']);
        config(['global.no_data_text' => 'You have not added any use for add first use for now']);
        config(['global.no_data_btn' => 'Add New Use For']);

        //set link add new
        config(['global.add_new_link' => '/product-use-for/create']);
        //set link update
        config(['global.update_link' => '/product-use-for/update']);

        //set delete
        config(['global.alert_delete_title' => 'This product use for will be deleted.']);
        config(['global.delete_link' => 'master_delete.product_use_for']);
        config(['global.after_delete_text' => 'Product use for has been deleted.']);
        config(['global.cant_delete_text' => 'The product related to this use for exist.']);


        $master=ProductUseForModel::all();
        $data=array(
            'master'=>$master
        );
        return view('product.use_for.index',$data);

    }
    public function create(){
        //Permission Start
        if (!config('global.add_product')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Add Product Use For']);
        config(['global.parent_text_content_title' => 'Product Use For']);

        //set submit route
        config(['global.submit_link' => 'store.product_use_for']);
        //set index route
        config(['global.index_link' => '/product-use-for']);

        return view('product.use_for.create');
    }
    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:product_use_for,name'
            ]);

            if ($validator->passes()){
                $master=new ProductUseForModel();
                $master->name=$request->name;
                $master->save();

                Session::flash('message', 'Use for have been added !');
                Session::flash('alert-type', 'success');

                return response()->json(['verify'=>'true']);
            }

            return ['errors' => $validator->errors(),'data'=>$request->all()];

    }
    //use for name required
    public  function use_for_name_validate(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:product_use_for,name'
        ]);

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
        config(['global.text_content_title' => 'Edit Product Use For']);
        config(['global.parent_text_content_title' => 'Product Use For']);

        //set submit route
        config(['global.submit_link' => 'save_update.product_use_for']);
        //set index route
        config(['global.index_link' => '/product-use-for']);

        $master=ProductUseForModel::where('id',$id)->first();
        return view('product.use_for.update')->with('master',$master);
    }
    public function save_update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100'
        ]);

        if ($validator->passes()){
            $current_name=ProductUseForModel::where('id',$request->update_id)->first()->name;
            ProductUseForModel::where('id',$request->update_id)->update([
                'name'=>$request->name
            ]);

            Session::flash('message', 'Use for have been updated !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true']);
        }
        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }

    public function delete(Request $request){

        $pro=ProductModel::where('cat_id',$request->id)->count();
        //check if no related master
        if ($pro==0){
            //delete master
            ProductUseForModel::where('id',$request->id)->delete();

        }else{

            //if have related product
            return response()->json(['delete'=>'false']);
        }


    }

//    Server Side
    function get_data()
    {
        $master=ProductUseForModel::orderBy('id','DESC')->select();

        //return $products;
        return DataTables::of($master)->make(true);
    }
}
