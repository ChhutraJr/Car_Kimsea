<?php

namespace App\Http\Controllers;

use App\InvoiceModel;
use App\ProductDetailModel;
use App\ProductModel;
use App\PurchaseDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Liseng;

class StockReportController extends Controller
{
    public function index(){
    /*    //Permission Start
        if (!config('global.view_expense')){
            return view('errors.not_found');
        }
        //Permission End*/

        //set content global icon and name
        config(['global.icon_content_title' => config('global.report_icon')]);
        config(['global.text_content_title' => 'Stock Report']);

        //set index link
        config(['global.index_link' => 'stock_report.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Products Found']);
        config(['global.no_data_text' => 'You have not added any product add first product now']);
        config(['global.no_data_btn' => 'Add New Product']);

        //set link add new
        config(['global.add_new_link' => '/product/create']);

        $master=ProductModel::orderBy('id','DESC')->get();

        $data=array(
            'master'=>$master,

        );
        return view('reports.stock_report',$data);
    }

    //    Server Side Master
    function get_data()
    {
        //get all master and relationship values
        $master=ProductModel::orderBy('id','DESC')
            ->select('product.*');
        //return $expense;
        return DataTables::of($master)
            ->addColumn('model', function ($master){

                if (!empty($master->model()->first()->name)){
                    return $master->model()->first()->name;
                }else{
                    return '';
                }
            })
            ->addColumn('use_for', function ($master){

                if (!empty($master->cat()->first()->name)){
                    return $master->cat()->first()->name;
                }else{
                    return '';
                }
            })
            ->addColumn('stock_out', function ($master){
                return Liseng::get_stock_out($master->id);
            })
            ->editColumn('total_qty',function ($master){
                if (!empty($master->total_qty)){
                    return $master->total_qty;
                }else{
                    return 0;
                }
            })
            ->editColumn('current_qty',function ($master){
                if (!empty($master->current_qty)){
                    return $master->current_qty;
                }else{
                    return 0;
                }
            })
            ->addColumn('cost_price',function ($master){
                $cost_price=Liseng::get_latest_cost_price($master->id);

                return  '$'.number_format($cost_price, 2);
            })
            ->addColumn('sell_price',function ($master){

                $sell_price=Liseng::get_latest_sell_price($master->id);

                return  '$'.number_format($sell_price, 2);
            })
            ->make(true);
    }

    //print
    public function get_print(){
        $master=ProductModel::orderBy('id','DESC')
            ->select('product.*')
            ->get();

        return view('reports.print.stock_report_print')->with('master',$master);
    }
}
