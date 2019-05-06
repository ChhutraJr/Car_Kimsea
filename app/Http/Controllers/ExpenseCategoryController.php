<?php

namespace App\Http\Controllers;

use App\ExpenseCategoryModel;
use App\ExpenseModel;
use App\ProductUseForModel;
use App\InvoiceModel;
use App\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ExpenseCategoryController extends Controller
{
    public function index(){
        //Permission Start
        if (!config('global.add_expense')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Expense Categories']);

        //set index link
        config(['global.index_link' => 'expense_category.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Categories Found']);
        config(['global.no_data_text' => 'You have not added any category add first category now']);
        config(['global.no_data_btn' => 'Add New Category']);

        //set link add new
        config(['global.add_new_link' => '/expense-category/create']);
        //set link update
        config(['global.update_link' => '/expense-category/update']);

        //set delete
        config(['global.alert_delete_title' => 'This expense category will be deleted.']);
        config(['global.delete_link' => 'master_delete.expense_category']);
        config(['global.after_delete_text' => 'Expense category has been deleted.']);
        config(['global.cant_delete_text' => 'The expense related to this category exist.']);


        $master=ExpenseCategoryModel::all();
        $data=array(
            'master'=>$master
        );
        return view('expense.category.index',$data);

    }
    public function create(){
        //Permission Start
        if (!config('global.add_expense')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Add new category']);
        config(['global.parent_text_content_title' => 'Expense Categories']);

        //set submit route
        config(['global.submit_link' => 'store.expense_category']);
        //set index route
        config(['global.index_link' => '/expense-categories']);

        return view('expense.category.create');
    }
    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:expense_category,name'
            ]);

            if ($validator->passes()){
                $master=new ExpenseCategoryModel();
                $master->name=$request->name;
                $master->save();

                Session::flash('message', 'Category have been added !');
                Session::flash('alert-type', 'success');

                return response()->json(['verify'=>'true']);
            }

            return ['errors' => $validator->errors(),'data'=>$request->all()];

    }
    public  function expense_cat_name_validate(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:expense_category,name'
        ]);
        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }
    public function update($id){
        //Permission Start
        if (!config('global.add_expense')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => 'icon-bookmark']);
        config(['global.text_content_title' => 'Edit Category']);
        config(['global.parent_text_content_title' => 'Expense Categories']);

        //set submit route
        config(['global.submit_link' => 'save_update.expense_category']);
        //set index route
        config(['global.index_link' => '/expense-categories']);

        $master=ExpenseCategoryModel::where('id',$id)->first();
        return view('expense.category.update')->with('master',$master);
    }
    public function save_update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100'
        ]);

        if ($validator->passes()){
            $current_name=ExpenseCategoryModel::where('id',$request->update_id)->first()->name;
            ExpenseCategoryModel::where('id',$request->update_id)->update([
                'name'=>$request->name
            ]);

            Session::flash('message', 'Category have been updated !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true']);
        }
        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }

    public function delete(Request $request){

        $exp=ExpenseModel::where('cat_id',$request->id)->count();
        //check if no related master
        if ($exp==0){
            //delete master
            ExpenseCategoryModel::where('id',$request->id)->delete();

        }else{

            //if have related product
            return response()->json(['delete'=>'false']);
        }


    }

//    Server Side
    function get_data()
    {
        $master=ExpenseCategoryModel::orderBy('id','DESC')->select();

        //return $products;
        return DataTables::of($master)->make(true);
    }
}
