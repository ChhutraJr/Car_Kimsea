<?php

namespace App\Http\Controllers;

use App\InvoiceModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InvoiceReportController extends Controller
{
    //Server Side
    function get_data(Request $request)
    {
/*        $master=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
            ->orderBy('date','DESC')
            ->leftJoin('customer as c','c.id','invoice.cus_id')
            ->select('invoice.id','invoice.date','invoice.invoice_no','invoice.payment_status','invoice.total_amount',
                'invoice.total_paid','invoice.total_remaining','invoice.note','invoice.amount','invoice.dis_type','invoice.dis_amount',
                'invoice.dis_total_amount','c.name as cus'
            )
            ->distinct();*/
        //get start and end date
        $start=$request->data1;
        $end=$request->data2;

        if ($request->data3!='all_users'||$request->data4!='all_sellers'){
            if ($request->data4=='all_sellers'){
                //if only have user sort
                $master=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->leftJoin('customer as c','c.id','invoice.cus_id')
                    ->select('invoice.*','c.name as cus')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('invoice.user_id',$request->data3)
                    ->distinct();

            }elseif($request->data3=='all_users'){
                //if only have seller sort
                $master=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->leftJoin('customer as c','c.id','invoice.cus_id')
                    ->select('invoice.*','c.name as cus')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$request->data4)
                    ->distinct();
            }else{
                //if sort both
                $master=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->leftJoin('customer as c','c.id','invoice.cus_id')
                    ->select('invoice.*','c.name as cus')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$request->data4)
                    ->where('invoice.user_id',$request->data3)
                    ->distinct();
            }

        }else{
            $master=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                ->orderBy('date','DESC')
                ->leftJoin('customer as c','c.id','invoice.cus_id')
                ->select('invoice.*','c.name as cus')
                ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->distinct();
        }

        /*$master=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
            ->orderBy('date','DESC')
            ->leftJoin('customer as c','c.id','invoice.cus_id')
            ->select('invoice.id')
            ->groupBy('invoice.id');*/

        //return $products;
        return DataTables::of($master)
            ->editColumn('total_amount', function ($master){
                //check if has total amount or not
                if (!empty($master->total_amount)){
                    return  '$'.number_format($master->total_amount, 2);
                }else{
                    return '$0.00';
                }
            })
            ->editColumn('total_paid', function ($master){
                //check if has total amount or not
                if (!empty($master->total_paid)){
                    return  '$'.number_format($master->total_paid, 2);
                }else{
                    return '$0.00';
                }
            })
            ->editColumn('total_remaining', function ($master){
                //check if has total amount or not
                if (!empty($master->total_remaining)){
                    return  '$'.number_format($master->total_remaining, 2);
                }else{
                    return '$0.00';
                }
            })
            ->editColumn('payment_status', function ($master){
                if (!empty($master->payment_status)){
                    return ucfirst(trans($master->payment_status));
                }

                return '';
            })
            ->editColumn('date', function($master) {
                return Carbon::parse($master->date)->format('d M, Y');

            })
            ->editColumn('invoice_no', function ($master){
                return str_pad($master->invoice_no, 6, '0', STR_PAD_LEFT);
            })
            ->addColumn('sa', function ($master){
                $multi_sa='';
                $count=0;
                if (!empty($master->multi_sa)){
                    foreach ($master->multi_sa as $sa){
                        $count++;
                        //if count bigger than one mean it has multiple sa then we add ,
                        if ($count>1){
                            $multi_sa.=' , '.$sa->user()->first()->first_name.' '.$sa->user()->first()->last_name;
                        }else{
                            //first sa
                            $multi_sa.=$sa->user()->first()->first_name.' '.$sa->user()->first()->last_name;
                        }

                    }
                }

                return $multi_sa;

            })
            ->addColumn('mechanic', function ($master){
                $multi_mechanic='';
                $count=0;
                if (!empty($master->multi_mechanic)){
                    foreach ($master->multi_mechanic as $mechanic){
                        $count++;
                        //if count bigger than one mean it has multiple mechanic then we add ,
                        if ($count>1){
                            $multi_mechanic.=' , '.$mechanic->user()->first()->first_name.' '.$mechanic->user()->first()->last_name;
                        }else{
                            //first mechanic
                            $multi_mechanic.=$mechanic->user()->first()->first_name.' '.$mechanic->user()->first()->last_name;
                        }

                    }
                }

                return $multi_mechanic;

            })
            ->addColumn('seller', function ($master){
                $multi_seller='';
                $count=0;
                if (!empty($master->multi_seller)){
                    foreach ($master->multi_seller as $seller){
                        $count++;
                        //if count bigger than one mean it has multiple seller then we add ,
                        if ($count>1){
                            $multi_seller.=' , '.$seller->user()->first()->first_name.' '.$seller->user()->first()->last_name;
                        }else{
                            //first seller
                            $multi_seller.=$seller->user()->first()->first_name.' '.$seller->user()->first()->last_name;
                        }

                    }
                }

                return $multi_seller;

            })
            ->addColumn('cus_id_number',function ($master){
                //format id at least 6 digits
                return str_pad($master->cus()->first()->id_number, 6, '0', STR_PAD_LEFT);
            })
            ->editColumn('amount', function ($master){
                //check if has total amount or not
                if (!empty($master->amount)){
                    return  '$'.number_format($master->amount, 2);
                }else{
                    return '$0.00';
                }
            })
            ->addColumn('in_stock_cost', function ($master){

                $total_cost=0;

                if (!empty($master->detail())){
                    $total_cost=$master->detail()->where('type','product')->sum('total_cost');

                    return  '$'.number_format($total_cost, 2);
                }

                return '$0.00';

            })
            ->addColumn('out_stock_cost', function ($master){

                $total_cost=0;

                if (!empty($master->detail())){
                    $total_cost=$master->detail()->where('type','other')->sum('total_cost');

                    return  '$'.number_format($total_cost, 2);
                }

                return '$0.00';

            })
            ->addColumn('tel', function($master) {

                //declare a variable to store all tel
                $tel='';

                //check if has tel or not
                if(!$master->cus()->first()->multi_tel->isEmpty()){

                    //sign divide tel
                    $divide='';
                    //count tel
                    $n=0;
                    //add multiple tel
                    foreach ($master->cus()->first()->multi_tel as $mt){
                        //add , when more than one tel
                        if ($n>0){
                            $divide=' / ';
                        }
                        $n++;
                        //format tel
                        $trim=trim($mt->name,"(");
                        $str1=str_replace(')',' ',$trim);
                        $str2=str_replace('-',' ',$str1);

                        $tel.=$divide.$str2;
                    }
                }

                //send all tel
                return $tel;

            })
            ->addColumn('plate_no',function ($master){
                if (!empty($master->cus()->first()->vehicle()->first()->plate_no)){
                    return $master->cus()->first()->vehicle()->first()->plate_no;
                }

                return '';
            })
            ->make(true);
    }

    public function index(){

/*        $master=InvoiceModel::orderBy('id','DESC')
            ->leftJoin('customer as c','c.id','invoice.cus_id')
            ->select(array(
                DB::raw('(SELECT sum(total_amount) FROM invoice) as grand_total_amount'),
                    'invoice.*','c.name as cus'
                )
            )
//                ->select('invoice.*','c.name as cus')
            ->get();*/
//        dd($master);
        /*    //Permission Start
            if (!config('global.view_expense')){
                return view('errors.not_found');
            }
            //Permission End*/

        //set content global icon and name
        config(['global.icon_content_title' => config('global.report_icon')]);
        config(['global.text_content_title' => 'Invoices Report']);

        //set index link
        config(['global.index_link' => 'invoice_rep_report.get_data']);

        $master=InvoiceModel::all();
        $users=invoice_user();
        $sellers=invoice_seller();

        //for filter date
        if (!$master->isEmpty()){
            //get first master date
            $first_master=InvoiceModel::orderBy('date','DESC')->first();
            config(['current_page_date'=>$first_master->date]);
        }

        $data=array(
            'master'=>$master,
            'users'=>$users,
            'sellers'=>$sellers
        );

        return view('reports.invoice_report',$data);
    }


}
