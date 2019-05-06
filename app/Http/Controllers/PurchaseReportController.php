<?php

namespace App\Http\Controllers;

use App\PurchaseModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PurchaseReportController extends Controller
{
    public function index(){

        //set content global icon and name
        config(['global.icon_content_title' => config('global.report_icon')]);
        config(['global.text_content_title' => 'Purchase Report']);

        //set index link
        config(['global.index_link' => 'purchase_report.get_data']);

        $master=PurchaseModel::all();
       // $users=invoice_user();

        //for filter date
        if (!$master->isEmpty()){
            //get first master date
            $first_master=PurchaseModel::orderBy('date','ASC')->first();
            config(['global.start_date'=>$first_master->date]);
        }

        $data=array(
            'master'=>$master,
        //    'users'=>$users
        );
        return view('reports.purchase_report',$data);
    }

//    //Server Side
    function get_data()
    {
        //get all master and relationship values
        $master = PurchaseModel::orderBy('id','DESC')
            ->join('supplier', 'purchase.supplier_id', '=', 'supplier.id')
            ->select('purchase.*','supplier.name as sup_name')
            ->get();

        return DataTables:: of($master)
            ->editColumn('date', function($master) {
                return Carbon:: parse($master->date)->format('d M, Y');
            })
            ->editColumn('ref_no', function ($master){
                return str_pad($master->ref_no, 6, '0', STR_PAD_LEFT);
            })
            ->editColumn('payment_status', function ($master){
                if (!empty($master->payment_status)){
                    return ucfirst(trans($master->payment_status));
                }
                return '';
            })
            ->editColumn('total_amount', function ($master){
                //check if has total amount or not
                if (!empty($master->total_amount)){
                    return  '$'.number_format($master->total_amount, 2);
                }else{
                    return '$0.00';
                }
            })
            ->addColumn('payment_due', function ($master){
                if (!empty($master->total_amount)){
                    return '$'.number_format($master->total_amount-$master->total_paid, 2);
                }else{
                    return '$0.00';
                }
            })
            ->make(true);
    }

    //Server Side Detail
    function get_data_detail(Request $request)
    {
        //get all detail values by product id
        $detail = Liseng::getPurchaseDetail($request->data1);

        return DataTables:: of($detail)
            //Edit created date format
            ->editColumn('created_at', function($detail) {
                //if have no sub products
                return Carbon:: parse($detail->created_at)->format('d M, Y');
            })
            //Edit cost price format
            ->editColumn('cost_price', function($detail) {
                //check if has total cost or not
                if (!empty($detail->cost_price)){
                    return  '$'.number_format($detail->cost_price, 2);
                }else{
                    return '$0.00';
                }
            })
            //Edit sell price format
            ->editColumn('sell_price', function($detail) {
                //check if has total cost or not
                if (!empty($detail->sell_price)){
                    return  '$'.number_format($detail->sell_price, 2);
                }else{
                    return '$0.00';
                }
            })
            //Edit total price format
            ->editColumn('total_cost', function($detail) {
                //check if has total cost or not
                if (!empty($detail->total_cost)){
                    return  '$'.number_format($detail->total_cost, 2);
                }else{
                    return '$0.00';
                }
            })
            //Edit profit format
            ->editColumn('profit', function($detail) {

                //check if has total cost or not
                if (!empty($detail->profit)){
                    return  '$'.number_format($detail->profit, 2);
                }else{
                    return '$0.00';
                }

            })
            ->editColumn('pro', function ($detail){
                //if product or new product
                if (!empty($detail->pro()->first()->name)){
                    $des = $detail->pro()->first()->name;
                    return $des;
                }

                return '';
            })
            ->addColumn('code_part', function ($detail){
                if (!empty($detail->pro()->first()->code_part)){
                    return $detail->pro()->first()->code_part;
                }else{
                    return '';
                }
            })
            ->make(true);
    }

    //Server Side Payment
    function get_data_payment(Request $request)
    {
        //get all master and relationship values
        $pa = Liseng::getPurchasePayment($request->data1);

        return DataTables:: of($pa)
            //Edit date format
            ->editColumn('date', function($pa) {
                return Carbon:: parse($pa->date)->format('d M, Y');
            })
            ->editColumn('amount', function ($pa){
                //check if has total amount or not
                if (!empty($pa->amount)){
                    return  '$'.number_format($pa->amount, 2);
                }else{
                    return '$0.00';
                }
            })
            ->make(true);
    }

    //Server Side Master Filter Date
    function get_data_filter_date(Request $request)
    {
        //get start and end date
        $start = $request->data1;
        $end   = $request->data2;

        //get all master and relationship values
        $master = PurchaseModel::orderBy('id','DESC')
            ->leftJoin('supplier', 'purchase.supplier_id', '=', 'supplier.id')
            ->select('purchase.*','supplier.name as sup_name')
            ->whereBetween( DB::raw('date(purchase.created_at)'), [$start, $end] )
            ->get();

        return DataTables:: of($master)
            ->editColumn('purchase_status', function ($master){
                if (!empty($master->purchase_status)){
                    return ucfirst(trans($master->purchase_status));
                }
                return '';
            })
            ->editColumn('date', function($master) {
                return Carbon:: parse($master->created_at)->format('d M, Y');
            })
            ->editColumn('ref_no', function ($master){
                return str_pad($master->ref_no, 6, '0', STR_PAD_LEFT);
            })
            ->editColumn('payment_status', function ($master){
                if (!empty($master->payment_status)){
                    return ucfirst(trans($master->payment_status));
                }
                return '';
            })
            ->editColumn('total_amount', function ($master){
                //check if has total amount or not
                if (!empty($master->total_amount)){
                    return  '$'.number_format($master->total_amount, 2);
                }else{
                    return '$0.00';
                }
            })
            ->addColumn('payment_due', function ($master){
                if (!empty($master->total_amount) && !empty($master->total_paid)){
                    return $master->total_amount-$master->total_paid;
                }
                return '';
            })
            ->make(true);
    }
}
