<?php

namespace App\Http\Controllers;

use App\ExpenseCategoryModel;
use App\ExpenseModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Liseng;

class ExpenseController extends Controller
{

    //    Server Side Master
    function get_data(Request $request)
    {
        $start=$request->data1;
        $end=$request->data2;

        //get all master and relationship values
        $master=ExpenseModel::orderBy('date','DESC')
            ->leftjoin('expense_category as ec','ec.id','expense.cat_id')
            ->select('expense.*','ec.name as ec_name')
            ->whereBetween( DB::raw('date(expense.date)'), [$start, $end] );

        //return $expense;
        return DataTables::of($master)
            /*->editColumn('cat', function($master){

                if (!empty($master->cat()->first()->name)){
                    return $master->cat()->first()->name;
                }else{
                    return '';
                }
               /* if ($master->cat_id==0){
                    return 'stock';
                }else{
                    return $master->cat()->first()->name;
                }*/

//            })*/
            ->editColumn('payment_status', function ($master){
                return ucfirst(trans($master->payment_status));
            })
            ->editColumn('total_amount', function ($master){
                //check if has total amount or not
                if (!empty($master->total_amount)){
                    return  '$'.number_format($master->total_amount, 2);
                }else{
                    return '$0.00';
                }
            })
            //Edit date format
            ->editColumn('date', function($master) {

                return Carbon::parse($master->date)->format('d M, Y');

            })
            ->make(true);
    }

    public function index(){
        //Permission Start
        if (!config('global.view_expense')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.expense_icon')]);
        config(['global.text_content_title' => 'Expenses']);

        //set index link
        config(['global.index_link' => 'expense.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Expenses Found']);
        config(['global.no_data_text' => 'You have not added any expense add first expense now']);
        config(['global.no_data_btn' => 'Add New Expense']);

        //set link add new
        config(['global.add_new_link' => '/expense/create']);
        //set link update
        config(['global.update_link' => '/expense/update']);

        //set delete
        config(['global.alert_delete_title' => 'This expense will be deleted.']);
        config(['global.delete_link' => 'master_delete.expense']);
        config(['global.after_delete_text' => 'Expense has been deleted.']);
//        config(['global.cant_delete_text' => 'The purchases related to this expense exist.']);


        $master=ExpenseModel::orderBy('id','DESC')->get();
        $master_pag='';

        if (!$master->isEmpty()){
            $master_pag=ExpenseModel::select('date')
                ->groupBy('date')
                ->orderBy('date','DESC')
                ->paginate(1);

            config(['current_page_date'=>$master_pag->items()[0]->date]);
        }
        $data=array(
            'master'=>$master,
            'master_pag' => $master_pag,
            'per_page' => 1
        );
        return view('expense.index',$data);
    }

    public function create(){
        //Permission Start
        if (!config('global.add_expense')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.expense_icon')]);
        config(['global.text_content_title' => 'Add Expense']);
        config(['global.parent_text_content_title' => 'Expenses']);

        //set submit route
        config(['global.submit_link' => 'store.expense']);
        //set index route
        config(['global.index_link' => '/expenses']);

        $cat=expense_category();
        $pro=expense_product();

        $data=array(
            'cat'=>$cat,
            'pro'=>$pro
        );
        return view('expense.create',$data);
    }


    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'payment_status' => 'required',
            'total_amount' => 'required|numeric|min:0|max:9999999999',
            'date' => 'required',
            'note' => 'max:500'
        ]);

/*        //check if category is stock
        if ($request->category==0){
            $validator = Validator::make($request->all(), [
                'category' => 'required',
                'payment_status' => 'required',
                'total_amount' => 'required|numeric|min:0|max:9999999999',
                'date' => 'required',
                'note' => 'max:500',
                'product' => 'required'
            ]);
        }*/

        if ($validator->passes()){

//            return $request->all();

            //set default cat id
            $cat_id=$request->category;

            //check if cat have add new value
            $check_cat=ExpenseCategoryModel::where('id',$request->category)->count();
            //if new value
            if ($check_cat==0&&!empty($request->category)){
                //add new cat
                $cat=new ExpenseCategoryModel();
                $cat->name=$request->category;
                $cat->save();

                //change cat id to new cat
                $cat_id=$cat->id;
            }


            //add master
            $master=new ExpenseModel();
            $master->cat_id=$cat_id;
            $master->payment_status=$request->payment_status;
            $master->total_amount=$request->total_amount;
//            $master->pro_id=$request->product;
            $master->date=$request->date;
            $master->note=$request->note;
            $master->save();

            //return message
            Session::flash('message', 'Expense have been added !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true',
                //  'pro_id'=>$master->id
            ]);
        }

        return ['errors' => $validator->errors(),'data'=>$request->all()];


    }

    // exp_validate_name
    public function total_amount_validate(Request $request){

        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric|min:0|max:9999999999',
        ]);
        return ['errors' => $validator->errors()];
    }

//    Show update view master
    public function update($id){
        //Permission Start
        if (!config('global.update_expense')){
            return view('errors.not_found');
        }
        //Permission End

        //set product content global icon and name
        config(['global.icon_content_title' => config('global.pro_icon')]);
        config(['global.text_content_title' => 'Edit Expense']);
        config(['global.parent_text_content_title' => 'Expenses']);

        //set submit route
        config(['global.submit_link' => 'save_update.expense']);
        //set index route
        config(['global.index_link' => '/expenses']);

        $cat=expense_category();
        $pro=expense_product();

        $master=ExpenseModel::where('id',$id)->first();

        $data=array(
            'cat'=>$cat,
            'pro'=>$pro,
            'master'=>$master
        );


        return view('expense.update',$data);
    }
    public function save_update(Request $request){

        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'payment_status' => 'required',
            'total_amount' => 'required|numeric|min:0|max:9999999999',
            'date' => 'required',
            'note' => 'max:500'
        ]);

/*        //check if category is stock
        if ($request->category==0){
            $validator = Validator::make($request->all(), [
                'category' => 'required',
                'payment_status' => 'required',
                'total_amount' => 'required|numeric|min:0|max:9999999999',
                'date' => 'required',
                'note' => 'max:500',
                'product' => 'required'
            ]);
        }*/

        if ($validator->passes()){
            //set default cat id
            $cat_id=$request->category;

            //check if cat have add new value
            $check_cat=ExpenseCategoryModel::where('id',$request->category)->count();
            //if new value
            if ($check_cat==0&&!empty($request->category)){
                //add new cat
                $cat=new ExpenseCategoryModel();
                $cat->name=$request->category;
                $cat->save();

                //change cat id to new cat
                $cat_id=$cat->id;
            }

            //Update master
            ExpenseModel::where('id',$request->update_id)
                ->update([
                    'cat_id'=>$cat_id,
                    'payment_status'=>$request->payment_status,
                    'total_amount'=>$request->total_amount,
//                    'pro_id'=>$request->product,
                    'date'=>$request->date,
                    'note'=>$request->note

                ]);

            //return message
            Session::flash('message', 'Expense have been updated !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true',
            ]);

        }

        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }
    public function delete(Request $request){

        //delete master
        ExpenseModel::where('id',$request->id)->delete();

    }

    public function pagination($page){

        $master_pag=ExpenseModel::select('date')
            ->groupBy('date')
            ->orderBy('date','DESC')
            ->paginate(1,['*'],'page',$page);

        $total_amount=Liseng::total_amount_exp($master_pag->first()->date,$master_pag->first()->date);
        $total_paid=Liseng::total_paid_exp($master_pag->first()->date,$master_pag->first()->date);
        $total_credit=Liseng::total_credit_exp($master_pag->first()->date,$master_pag->first()->date);

        return response()->json(['next_page'=>$master_pag->nextPageUrl(),'has_more_pages'=>$master_pag->hasMorePages(),
            'previousPageUrl'=>$master_pag->previousPageUrl(),'total'=>$master_pag->total(),'per_page'=>1,'current_page'=>$master_pag->currentPage(),
            'master_pag'=>$master_pag,'total_amount'=>$total_amount,'total_paid'=>$total_paid,'total_credit'=>$total_credit,'date'=>$master_pag->first()->date
        ]);
    }

    public function get_data_by_date(Request $request){
        $total_amount=Liseng::total_amount_exp($request->start,$request->end);
        $total_paid=Liseng::total_paid_exp($request->start,$request->end);
        $total_credit=Liseng::total_credit_exp($request->start,$request->end);

        if (!empty($request->cat)){
            $total_amount=Liseng::total_amount_exp($request->start,$request->end,$request->cat);
            $total_paid=Liseng::total_paid_exp($request->start,$request->end,$request->cat);
            $total_credit=Liseng::total_credit_exp($request->start,$request->end,$request->cat);
        }

        return response()->json(['total_amount'=>$total_amount,
            'total_paid'=>$total_paid,
            'total_credit'=>$total_credit
        ]);
    }

}
