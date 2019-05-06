<?php

namespace App\Http\Controllers;

use App\ExpenseModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExpenseReportController extends Controller
{
    public function index(){
        /*    //Permission Start
            if (!config('global.view_expense')){
                return view('errors.not_found');
            }
            //Permission End*/

        //set content global icon and name
        config(['global.icon_content_title' => config('global.report_icon')]);
        config(['global.text_content_title' => 'Expense Report']);

        //set index link
        config(['global.index_link' => 'expense_report.get_data']);


        $master=ExpenseModel::orderBy('id','DESC')->get();
        $categories=expense_category();

        //for filter date
        if (!$master->isEmpty()){
            //get first master date
            $first_master=ExpenseModel::orderBy('date','DESC')->first();
            config(['current_page_date'=>$first_master->date]);
        }

        $data=array(
            'master'=>$master,
            'categories'=>$categories
        );

        return view('reports.expense_report',$data);
    }

    //    Server Side Master
    function get_data(Request $request)
    {
        //get start and end date
        $start=$request->data1;
        $end=$request->data2;

        //if the select box is all type
        if (empty($request->data3)||$request->data3=='all_cats'){
            //get all master and relationship values
            $master=ExpenseModel::orderBy('date','DESC')
                ->leftjoin('expense_category as ec','ec.id','expense.cat_id')
                ->select('expense.*','ec.name as ec_name')
                ->whereBetween( DB::raw('date(expense.date)'), [$start, $end] );

        }else{
            //filter by type and date
            $master=ExpenseModel::orderBy('date','DESC')
                ->leftjoin('expense_category as ec','ec.id','expense.cat_id')
                ->select('expense.*','ec.name as ec_name')
                ->whereBetween( DB::raw('date(expense.date)'), [$start, $end] )
                ->where('expense.cat_id',$request->data3);
        }

        //return $expense;
        return DataTables::of($master)
            ->editColumn('date',function ($master){
                return Carbon::parse($master->date)->format('d M, Y');
            })
            ->editColumn('total_amount',function ($master){
                //check if has total amount or not
                if (!empty($master->total_amount)){
                    return  '$'.number_format($master->total_amount, 2);
                }else{
                    return '$0.00';
                }
            })
            ->editColumn('cat', function($master){

                if (!empty($master->cat()->first()->name)){
                    return $master->cat()->first()->name;
                }else{
                    return '';
                }

            })
            ->editColumn('payment_status', function ($master){
                return ucfirst(trans($master->payment_status));
            })

            ->make(true);
    }
}
