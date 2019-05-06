<?php

namespace App\Http\Controllers;

use App\InvoiceDetailModel;
use App\InvoiceModel;
use App\ProductModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use PHPExcel_Worksheet_Drawing;

class OutStockReportController extends Controller
{
    public function index(){
        config(['global.icon_content_title' => config('global.report_icon')]);
        config(['global.text_content_title' => 'Out Stock Report']);
        //set index link
        config(['global.index_link' => 'out_stock_report.get_data']);

        $master=InvoiceDetailModel::orderBy('id','DESC')->get();

        //for filter date
        if (!$master->isEmpty()){
            //get first master date
            $first_master=InvoiceModel::orderBy('date','ASC')->first();
            config(['global.start_date'=>$first_master->date]);
        }

        $data=array(
            'master'=>$master,
        );
       return view('reports.out_stock_report',$data);
    }
    //    Server Side Master
     function get_data(){
         //get all master and relationship values
         $master=InvoiceDetailModel::orderBy('id','DESC')
             ->leftjoin('product as p','p.id','invoice_detail.pro_id')
             ->leftjoin('product_model as m','m.id','p.model_id')
             ->leftjoin('product_use_for as c','c.id','p.cat_id')
             ->leftjoin('invoice as inv','inv.id','invoice_detail.invoice_id')
             ->select('invoice_detail.*','p.name','p.code_part','m.name as m_name','c.name as c_name','inv.invoice_no')
            ->where('invoice_detail.type','product')
             ->orderby('inv.date','DESC')
             ->orderby('invoice_detail.created_at','DESC');
         //return $expense;
         return DataTables::of($master)

             ->make(true);
     }

    //Server Side Master Filter Date
    function get_data_filter_date(Request $request)
    {
        $start = $request->data1;
        $end   = $request->data2;

        //get all master and relationship values
        $master = InvoiceDetailModel::orderBy('id','DESC')
            ->leftjoin('product as p','p.id','invoice_detail.pro_id')
            ->leftjoin('product_model as m','m.id','p.model_id')
            ->leftjoin('product_use_for as c','c.id','p.cat_id')
            ->leftjoin('invoice as inv','inv.id','invoice_detail.invoice_id')
            ->select('invoice_detail.*','p.name','p.code_part','m.name as m_name','c.name as c_name','inv.invoice_no')
            ->where('invoice_detail.type','product')
            ->orderby('inv.date','DESC')
            ->orderby('invoice_detail.created_at','DESC')
            ->whereBetween( DB::raw('date(inv.date)'), [$start, $end] );
        return DataTables:: of($master)
//            ->editColumn('inv.date', function($master) {
//                return Carbon:: parse($master->date)->format('d M, Y');
//            })
            ->make(true);
   }


    public function export_out_stock_report(){
       $data  =array();
        $detail= InvoiceDetailModel::orderBy('id','DESC')
            ->leftjoin('product as p','p.id','invoice_detail.pro_id')
            ->leftjoin('product_model as m','m.id','p.model_id')
            ->leftjoin('product_use_for as c','c.id','p.cat_id')
            ->join('invoice as inv','inv.id','invoice_detail.invoice_id')
            ->select('invoice_detail.*','p.name as name','p.code_part','m.name as m_name','c.name as c_name',
                'inv.invoice_no')
            ->where('invoice_detail.type','product')
            ->orderby('inv.date','DESC')
            ->get()->toArray();
        $data['details']=$detail;
            return \Excel::create('Out & Stock -'.Carbon::now(), function($excel) use ($data) {

                $excel->sheet('Detail', function($sheet) use ($data) {


                    $sheet->cells('A2:F100', function($cells) {


                        $cells->setAlignment('center');


                    });
                    $sheet->loadView('reports.export.out_stock')->with('data',$data);
                });
                ob_end_clean();
            })->download('xlsx');
    }
}
