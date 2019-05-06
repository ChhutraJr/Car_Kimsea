<?php

namespace App\Http\Controllers;

use App\CustomerModel;
use App\InvoiceModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerReportController extends Controller
{
    public function index(){
        /*    //Permission Start
            if (!config('global.view_expense')){
                return view('errors.not_found');
            }
            //Permission End*/

        //set content global icon and name
        config(['global.icon_content_title' => config('global.report_icon')]);
        config(['global.text_content_title' => 'Customer Report']);

        //set index link
        config(['global.index_link' => 'customer_report.get_data']);


        $master=CustomerModel::orderBy('id','DESC')->get();

        $data=array(
            'master'=>$master,

        );
        return view('reports.customer_report',$data);
    }

    //    Server Side Master
    function get_data()
    {
        //get all master and relationship values
        $master=CustomerModel::orderBy('id','DESC')
            ->leftjoin('vehicle as v','v.cus_id','customer.id')
            ->orderBy('customer.id','DESC')
            ->select('customer.*','v.plate_no');

        //return $expense;
        return DataTables::of($master)
            ->addColumn('total_sale',function ($master){
                //check if has total sale or not
                $invoice=InvoiceModel::where('cus_id',$master->id)->sum('total_amount');

                return  '$'.number_format($invoice, 2);
            })
            ->addColumn('due',function ($master){
                //check if has total sale or not
                $invoice=InvoiceModel::where('cus_id',$master->id)->sum('total_remaining');

                return  '$'.number_format($invoice, 2);
            })
/*            ->addColumn('tel', function($master) {

                //declare a variable to store all tel
                $tel='';

                //check if has tel or not
                if(!$master->multi_tel->isEmpty()){

                    //sign divide tel
                    $divide='';
                    //count tel
                    $n=0;
                    //add multiple tel
                    foreach ($master->multi_tel as $mt){
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

            })*/
            ->editColumn('type', function($master) {


                /*   $twelve_month_ago=Carbon::now()->subMonth(12)->toDateString();
                   $now = Carbon::now()->toDateString();

                   //new type
                   //count all invoice if has no invoice or only one invoice return type new
                   $count_new=InvoiceModel::where('cus_id',$master->id)
                       ->whereBetween( DB::raw('date(date)'), [$twelve_month_ago, $now] )
                       ->count();
                   if ($count_new<2){

                       //check red type start
                       $count_all=InvoiceModel::where('cus_id',$master->id)->count();
                       //count all invoice if this year invoice is empty and this customer has one invoice before return red
                       if ($count_new==0&&$count_all>0){
                               return 'Red';
                       }
                       //check red type end

                       return 'New';
                   }

                   //gold type
                   $three_month_ago = Carbon::now()->subMonth(3)->toDateString(); // or ->format(..)
                   //count all invoice that has this customer in the last 3 months
                   $count_gold=InvoiceModel::where('cus_id',$master->id)
                       ->whereBetween( DB::raw('date(date)'), [$three_month_ago, $now] )
                       ->count();
                   if ($count_gold>0){
                       return 'Gold';
                   }

                   //silver type
                   $three_month_ago_minus_day=$fromDate = Carbon::now()->subMonth(3)->subDay()->toDateString(); // or ->format(..)
                   //count all invoice that has this customer in the last 12 months to the last 3 months
                   $count_silver=InvoiceModel::where('cus_id',$master->id)
                       ->whereBetween(DB::raw('date(date)'), [$twelve_month_ago, $three_month_ago_minus_day])
                       ->count();
                   if ($count_silver>0){
                       return 'Silver';

                   }

                   //red type
                   $twenty_four_month_ago=Carbon::now()->subMonth(24)->toDateString();
                   //count all invoice that has this customer in last year
                   $count_red=InvoiceModel::where('cus_id',$master->id)
                       ->whereBetween(DB::raw('date(date)'), [$twenty_four_month_ago, $twelve_month_ago])
                       ->count();
                   //plus last year and this year if this customer only has one invoice or no invoice return type red
                   $total_count_red=$count_red+$count_new;
                   if ($total_count_red<2){
                       return 'Red';
                   }

                   //check if has type or not
                   /*if(!empty($master->type)){
                       //convert to capitalize first letter
                       return ucfirst(trans($master->type));
                   }*/



                //check if has type or not
                if(!empty($master->type)){
                    //convert to capitalize first letter
                    return ucfirst(trans($master->type));
                }
                return '';
            })
            ->editColumn('id_number',function ($master){
                //format id atleast 6 digits
                return str_pad($master->id_number, 6, '0', STR_PAD_LEFT);
            })
            //Edit date format
/*            ->editColumn('created_at', function($master) {

                return Carbon::parse($master->created_at)->format('d M, Y');

            })
            ->addColumn('first_service', function ($master){
                if (!empty($master->invoice()->first()->date)){
                    $first_service=$master->invoice()->first()->date;
                    return Carbon::parse($first_service)->format('d M, Y');
                }

                return '';
            })

            ->addColumn('last_service', function ($master){
                if (!empty($master->invoice()->orderBy('id','DESC')->first()->date)){
                    $last_service=$master->invoice()->orderBy('id','DESC')->first()->date;
                    return Carbon::parse($last_service)->format('d M, Y');
                }

                return '';
            })*/
            ->make(true);
    }
}
