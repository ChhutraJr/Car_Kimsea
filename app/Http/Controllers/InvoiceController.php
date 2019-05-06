<?php

namespace App\Http\Controllers;

use App\CustomerModel;
use App\InvoiceDetailModel;
use App\InvoiceMultiMechanicModel;
use App\InvoiceMultiSAModel;
use App\InvoiceModel;
use App\InvoiceMultiSellerModel;
use App\InvoicePaymentModel;
use App\Notifications\NotifyLowStock;
use App\ProductDetailModel;
use App\ProductModel;
use App\PurchaseDetailModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Liseng;
use PHPExcel_Worksheet_Drawing;

class InvoiceController extends Controller
{
    //Server Side
    function get_data(Request $request)
    {
        $start=$request->data1;
        $end=$request->data2;

        //get all master and relationship values
        $master=InvoiceModel::orderBy('date','DESC')
            ->orderBy('invoice_no','DESC')
            ->leftJoin('customer as c','c.id','invoice.cus_id')
            ->select('invoice.*','c.name as cus')
            ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] );
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
            ->editColumn('amount', function ($master){
                //check if has total amount or not
                if (!empty($master->amount)){
                    return  '$'.number_format($master->amount, 2);
                }else{
                    return '$0.00';
                }
            })
            ->addColumn('cus_id_number',function ($master){
                //format id at least 6 digits
                return str_pad($master->cus()->first()->id_number, 6, '0', STR_PAD_LEFT);
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
    //Server Side Detail
    function get_data_detail(Request $request)
    {
        //get all detail values by product id
        $detail=InvoiceDetailModel::orderBy('id','ASC')->where('invoice_id',$request->data1)
            ->select('invoice_detail.*');

        //return $products;
        return DataTables::of($detail)
            //Edit created date format
            ->editColumn('created_at', function($detail) {

                //if have no sub products
                return Carbon::parse($detail->created_at)->format('d M, Y');

            })
            //Edit sell price format
            ->editColumn('price', function($detail) {

                //check if has total cost or not
                if (!empty($detail->price)){
                    return  '$'.number_format($detail->price, 2);
                }else{
                    return '$0.00';
                }

            })
            ->editColumn('cost_price', function($detail) {

                //check if has total cost or not
                if (!empty($detail->cost_price)){
                    return  '$'.number_format($detail->cost_price, 2);
                }else{
                    return '$0.00';
                }

            })
            //Edit total price format
            ->editColumn('total', function($detail) {

                //check if has total cost or not
                if (!empty($detail->total)){
                    return  '$'.number_format($detail->total, 2);
                }else{
                    return '$0.00';
                }

            })
            ->editColumn('des', function ($detail){

                //if product or new product
                if ($detail->type=='product'||$detail->type=='new_product'){
                    $des=$detail->pro()->first()->name;
                }else{
                    //if other
                    $des=$detail->des;
                }

                return $des;
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
        $pa=InvoicePaymentModel::where('invoice_id',$request->data1)->orderBy('id','ASC');
        return DataTables::of($pa)
            //Edit date format
            ->editColumn('date', function($pa) {

                return Carbon::parse($pa->date)->format('d M, Y');

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

    public function index($value1='',$value2='',$value3=''){


        if($value1=='print'){
            return view('invoice.print')->with('id',$value2);
        }
        else if($value1=='print-management'){
            return view('invoice.print-management')->with('id',$value2);
        }

        //Permission Start
        if (!config('global.view_sell')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.sell_icon')]);
        config(['global.text_content_title' => 'Invoices']);

        //set index link
        config(['global.index_link' => 'invoice.get_data']);
        //set no data content
        config(['global.no_data_title' => 'No Invoices Found']);
        config(['global.no_data_text' => 'You have not added any invoice add first invoice now']);
        config(['global.no_data_btn' => 'Add New Invoice']);

        //set link add new
        config(['global.add_new_link' => '/invoice/create']);
        //set link update
        config(['global.update_link' => '/invoice/update']);

        //set delete
        config(['global.alert_delete_title' => 'This invoice and all sub invoices will be deleted.']);
        config(['global.delete_link' => 'master_delete.invoice']);
        config(['global.after_delete_text' => 'Invoice and all sub invoices have been deleted.']);
        //config(['global.cant_delete_text' => 'The purchases related to this invoices exist.']);

        $master=InvoiceModel::all();
        $master_pag='';

/*        foreach ($master as $item){
            foreach ($item->detail()->get() as $value){
                InvoiceDetailModel::where('id',$value->id)->update([
                    'total_cost'=>($value->qty*$value->cost_price)
                ]);
            }
        }*/

/*        InvoiceModel::where('payment_status','due')
            ->update(['payment_status'=>'credit']);*/

        //for filter date
        if (!$master->isEmpty()){
            $master_pag=InvoiceModel::select('date')
                ->groupBy('date')
                ->orderBy('date','DESC')
                ->paginate(1);

//            dd($master_pag);

            //get first master date
            $first_master=InvoiceModel::orderBy('date','ASC')->first();
            config(['global.first_invoice_date'=>$first_master->first()->date]);
            $last_master=InvoiceModel::orderBy('date','DESC')->first();
            config(['global.last_invoice_date'=>$last_master->first()->date]);

            //dd($pros);

            config(['current_page_date'=>$master_pag->items()[0]->date]);
        }

        $data=array(
            'master' => $master,
            'master_pag' => $master_pag,
            'per_page' => 1
        );

        return view('invoice.index',$data);
    }

    public function create($cus_id=null){
        //create invoice with customer start
        config(['global.cus_id'=>$cus_id]);

        //if invoice customer is already exist
        if (!empty($cus_id)){
            $invoice=InvoiceModel::where('cus_id',$cus_id)->orderBy('id','DESC')->first();

            if (!empty($invoice)){
                Liseng::$sa=$invoice->multi_sa;
                Liseng::$mechanic=$invoice->multi_mechanic;
                Liseng::$seller=$invoice->multi_seller;
            }

//            dd($sa);
        }
        //create invoice with customer end

        //Permission Start
        if (!config('global.add_sell')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.sell_icon')]);
        config(['global.text_content_title' => 'Add new invoice']);
        config(['global.parent_text_content_title' => 'Invoices']);

        //set submit route
        config(['global.submit_link' => 'store.invoice']);
        //set index route
        config(['global.index_link' => '/invoices']);
        //set link add new
        config(['global.add_new_link' => '/invoice/create']);

        $cus=invoice_customer();
        $sa=invoice_multi_sa();
        $mechanic=invoice_multi_machanic();
        $seller=invoice_multi_seller();

        $data=array(
            'cus'=>$cus,
            'sa'=>$sa,
            'mechanic'=>$mechanic,
            'seller'=>$seller
        );
        return view('invoice.create',$data);
    }
    public function store(Request $request){
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            'date' => 'required',
            'km' => 'max:50',
            'ro' => 'max:50',
            'note' => 'max:500'
        ]);

        if ($validator->passes()){
            // return $request->all();

            //set default cat id
            $cus_id=$request->customer;

            //check if customer have add new value
            $check_cus=CustomerModel::where('id',$request->customer)->count();
            //if new value
            if ($check_cus==0&&!empty($request->customer)){
                //get last customer
                $count_master=CustomerModel::count();
                //if no customer default id to 1
                $id_number=1;
                if ($count_master!=0){
                    //when customer more than one plus id number +1
                    $cus=CustomerModel::orderBy('id','DESC')->first();
                    $id_number=$cus->id_number+1;
                }
                //add new cus
                $cus=new CustomerModel();
                $cus->id_number=$id_number;
                $cus->name=$request->customer;
                $cus->type='new';
                $cus->save();

                //change cus id to new cus
                $cus_id=$cus->id;
            }

            //check if has invoice or not
            $invoice_count=InvoiceModel::count();
            if ($invoice_count==0){
                $no=1;
            }else{
                $last_invoice=InvoiceModel::orderBy('id','DESC')->first();
                $no=$last_invoice->invoice_no+1;
            }

            $master = new InvoiceModel();
            $master->invoice_no=$no;
            $master->date=$request->date;
            $master->cus_id=$cus_id;
            $master->km=$request->km;
            $master->ro=$request->ro;
            $master->note=$request->note;
            $master->payment_status='credit';
            $master->user_id=Auth::user()->id;
            $master->amount=str_replace(',', '', $request->amount);
            $master->dis_type=$request->dis_type;
            $master->dis_amount=str_replace(',', '', $request->dis_amount);
            $master->dis_total_amount=str_replace(',', '', $request->dis_total_amount);
            $master->total_amount=str_replace(',', '', $request->total_amount);
            $master->total_remaining=str_replace(',', '', $request->total_amount);
            $master->save();

            //add SA
            if(!empty($request->sa)) {
                foreach ($request->sa as $sa) {

                    $multi_sa = new InvoiceMultiSAModel();
                    $multi_sa->invoice_id = $master->id;
                    $multi_sa->user_id = $sa;
                    $multi_sa->save();
                }
            }

            //add Mechanic
            if(!empty($request->mechanic)) {
                foreach ($request->mechanic as $mechanic) {
                    $multi_mechanic = new InvoiceMultiMechanicModel();
                    $multi_mechanic->invoice_id = $master->id;
                    $multi_mechanic->user_id = $mechanic;
                    $multi_mechanic->save();
                }
            }

            //add Seller
            if(!empty($request->seller)) {
                foreach ($request->seller as $seller) {
                    $multi_seller = new InvoiceMultiSellerModel();
                    $multi_seller->invoice_id = $master->id;
                    $multi_seller->user_id = $seller;
                    $multi_seller->save();
                }
            }

            //Update total amount
            /*InvoiceModel::where('id',$master->id)
                ->update([
                    'total_amount'=>str_replace(',', '', $request->total_amount),
                    'total_remaining'=>str_replace(',', '', $request->total_amount)
                ]);*/

            //return message
            /*          Session::flash('message', $request->product_name.' have been added !');
                      Session::flash('title', 'Product');
                      Session::flash('alert-type', 'success');*/


            return response()->json(['verify'=>'true',
                'invoice_id'=>$master->id
            ]);
        }

        return ['errors' => $validator->errors(),'data'=>$request->all()];

        /*    $validator = Validator::make($request->all(), [
                'product_name' => 'required|max:100',
                'category' => 'required',
                ''
            ]);

            if ($validator->passes()){
                $pro=ProductModel::where('id',$request->updateid)->first();
                $path=$pro->image;
                if ($request->image!=null){

                    if ($pro->image!='product\empty.png'){
                        Storage::delete($path);
                    }

                    $path=$request->file('image')->store('product');
                }

                ProductModel::where('id',$request->updateid)->update([
                    'code' => $request->pro_code,
                    'name' => $request->product_name,
                    'size' => $request->pro_size,
                    'type_case_name'=> $request->pro_type_case,
                    'type_unit'=> $request->pro_type_unit,
                    'unit_price'=> $request->pro_unit_price,
                    'cost_unit'=> $request->pro_cost_unit,
                    'cat_id'=> $request->category,
                    'image' => $path,
                    'des' => $request->description
                ]);

                Session::flash('message', $request->product_name.' have been updated !');
                Session::flash('title', 'Product');
                Session::flash('alert-type', 'success');

                return response()->json(['verify'=>'true']);
            }

            return ['errors' => $validator->errors(),'data'=>$request->all()];
        */
    }

    public function store_detail(Request $request){

        //set default
        $cost_price=$request->cost_price;
        if ($cost_price=='NaN'){
            $cost_price=0;
        }

        $price=0;
        $total=0;
        $pro_id=0;
        $des='';

        //check if price is not free
        if ($request->total>0){
            $price=$request->price;
            $total=$request->total;
        }

        //check description
        if ($request->des_type=='product'){
            //if description is product
            $pro_id=$request->code_part;
        }/*elseif ($request->des_type=='new_product'){
            //if description is new product
            //add new product automatically
            $pro=new ProductModel();
            $pro->name=$request->des;
            $pro->total_qty=$request->qty;
            $pro->current_qty=$request->qty;
            $pro->user_id=Auth::user()->id;
            $pro->save();

            //add new product detail
            $pro_detail=new ProductDetailModel();
            $pro_detail->sell_price=$price;
            $pro_detail->qty=$request->qty;
            $pro_detail->pro_id=$pro->id;
            $pro_detail->save();

            $pro_id=$pro->id;

        }*/else{
            //if description is other
            $des=$request->des;
        }

        //only check if product
        if ($request->des_type=='product'||$request->des_type=='new_product'){

            //Check Cost Price Start
            //$cost_price=Liseng::get_latest_cost_price($pro_id);

            /*$product_detail=ProductDetailModel::orderBy('created_at','DESC')
                ->where('pro_id',$pro_id)
                ->first();
            $purchase_detail=PurchaseDetailModel::orderBy('created_at','DESC')
                ->where('pro_id',$pro_id)
                ->first();

            if (!empty($product_detail)||!empty($purchase_detail)){
                //if product detail is empty
                if (empty($product_detail)){
                    $cost_price=$purchase_detail->cost_price;
                }elseif (empty($purchase_detail)){
                    //if product purchase is empty
                    $cost_price=$product_detail->cost_price;
                }else{
                    //if product detail and product purchase is not empty
                    if ($product_detail->created_at>$purchase_detail->created_at){
                        $cost_price=$product_detail->cost_price;
                    }else{
                        $cost_price=$purchase_detail->cost_price;
                    }
                }

            }*/
            //Check Cost Price End


            //Stock Start
            //get current qty before cut stock
            $current_qty_pre=ProductModel::where('id',$pro_id)->first()->current_qty;
            //update product current qty
            ProductModel::where('id',$pro_id)->
                update(['current_qty'=>$current_qty_pre-$request->qty]);

            //Stock End

            //Alert notification if current qty product = 3
            //get current qty after cut stock

/*            $current_qty=ProductModel::where('id',$pro_id)->first()->current_qty;
            if ($current_qty<=3&&$current_qty>0){
                //Permission Start
                $pro=ProductModel::find($pro_id);
                $user=User::where('status',1)->get();
                foreach ($user as $u){

                    //Custom get permission role
                    $pri=get_per_by_role('notification','allow_notification',$u->role_id);

                    //Send notification only user who has permission
                    if ($pri){
                        $u->notify(new NotifyLowStock($pro));
                    }

                }
                //Permission End
            }*/


        }

        //add invoice detail
        $detail=new InvoiceDetailModel();
        $detail->qty=$request->qty;
        $detail->cost_price=$cost_price;
        $detail->price=$price;
        $detail->total=$total;
        $detail->total_cost=$request->qty*$cost_price;
        $detail->type=$request->des_type;
        $detail->des=$des;
        $detail->pro_id=$pro_id;
        $detail->invoice_id=$request->invoice_id;
        $detail->note=$request->note;
        $detail->save();

/*        //get master
        $invoice=InvoiceModel::find($request->invoice_id);
        //update master
        $total_amount=$request->total;
        $total_remain=$request->total;
        InvoiceModel::where('id',$request->invoice_id)
            ->update([
                'total_amount'=>$invoice->total_amount+=$total_amount,
                'total_remaining'=>$invoice->total_remaining+=$total_remain
            ]);*/

        return response()->json(['last'=>$request->last]);
    }

    // Show update view master
    public function update($id){
        //Permission Start
        if (!config('global.update_sell')){
            return view('errors.not_found');
        }
        //Permission End

        //set product content global icon and name
        config(['global.icon_content_title' => config('global.sell_icon')]);
        config(['global.text_content_title' => 'Edit Invoice']);
        config(['global.parent_text_content_title' => 'Invoices']);

        //set submit route
        config(['global.submit_link' => 'save_update.invoice']);
        //set index route
        config(['global.index_link' => '/invoices']);

        $cus=invoice_customer();
        $sa=invoice_multi_sa();
        $mechanic=invoice_multi_machanic();
        $seller=invoice_multi_seller();

        $master=InvoiceModel::where('id',$id)->first();

        $data=array(
            'cus'=>$cus,
            'sa'=>$sa,
            'mechanic'=>$mechanic,
            'seller'=>$seller,
            'master'=>$master
        );

        return view('invoice.update',$data);
    }

    //Get detail data to view
    public function update_detail($id){

        $detail=InvoiceDetailModel::leftjoin('product','product.id','invoice_detail.pro_id')
            ->orderBy('invoice_detail.id','ASC')
            ->where('invoice_detail.invoice_id',$id)
            ->select('invoice_detail.*','product.name as pro_name','product.id as pro_id','product.code_part as code_part')
            ->get();
        $data=array(
            'detail'=>$detail,
            'grand_total'=>InvoiceModel::where('id',$id)->first()->total_amount,
            'invoice_product'=>invoice_product()
        );

        return $data;
    }

    public function store_payment(Request $request){

        $payment=new InvoicePaymentModel();
        $payment->date=date('Y-m-d');
        $payment->amount=$request->amount;
        $payment->note=$request->note;
        $payment->invoice_id=$request->invoice_id;
        $payment->save();

        //update invoice
        $invoice=InvoiceModel::where('id',$request->invoice_id)->first();
        $total_remain=$invoice->total_amount-$request->amount;
        //check if payment is paid equal to total or bigger
        if ($request->amount>=$invoice->total_amount){
            InvoiceModel::where('id',$request->invoice_id)
                ->update(['payment_status'=>'paid',
                    'total_paid'=>$request->amount,
                    'total_remaining'=>$total_remain
                ]);
        }elseif ($request->amount>0){
            //if payment is paid but not enough
            InvoiceModel::where('id',$request->invoice_id)
                ->update(['payment_status'=>'partial',
                    'total_paid'=>$request->amount,
                    'total_remaining'=>$total_remain
                ]);
        }

        return response()->json(['verify'=>'true',
        ]);
    }

    //Get data payment to view
    public function update_payment($id){

        $data=array(
            'payment'=>InvoicePaymentModel::orderBy('id','ASC')->where('invoice_id',$id)->get(),
        );

        return $data;
    }

    // Add invoice payment multiple
    public function store_payment_multi(Request $request){


        //if payment date is empty
        if ($request->date=='NaN-NaN-NaN'){
            $request->date=null;
        }

        //only add to database if one have value
        if (!empty($request->date)||!empty($request->amount)||!empty($request->note)){
            $pa=new InvoicePaymentModel();
            $pa->date=$request->date;
            $pa->amount=$request->amount;
            $pa->note=$request->note;
            $pa->invoice_id=$request->invoice_id;
            $pa->save();
        }

        //update invoice
        $invoice=InvoiceModel::where('id',$request->invoice_id)->first();
        $total_paid=$invoice->total_paid+$request->amount*1;
        $total_remain=($invoice->total_amount-$total_paid)*1;

        //check if payment is paid equal to total or bigger
        if ($total_paid>=$invoice->total_amount){
            InvoiceModel::where('id',$request->invoice_id)
                ->update(['payment_status'=>'paid',
                    'total_paid'=>$total_paid,
                    'total_remaining'=>$total_remain
                ]);
        }elseif ($total_paid>0){
            //if payment is paid but not enough
            InvoiceModel::where('id',$request->invoice_id)
                ->update(['payment_status'=>'partial',
                    'total_paid'=>$total_paid,
                    'total_remaining'=>$total_remain
                ]);
        }else{
            InvoiceModel::where('id',$request->invoice_id)
                ->update(['payment_status'=>'credit',
                    'total_paid'=>$total_paid,
                    'total_remaining'=>$total_remain
                ]);
        }

        return response()->json(['verify'=>'true']);

    }

    // Delete invoice payment
    public function delete_payment(Request $request){
        //delete all invoice payment
        InvoicePaymentModel::where('invoice_id',$request->invoice_id)->delete();

        //update invoice
        InvoiceModel::where('id',$request->invoice_id)
            ->update(['total_paid'=>0,
                'total_remaining'=>0
                ]);

    }


    public function delete(Request $request){

        //delete master
        InvoiceModel::where('id',$request->id)->delete();

        //Stock Start
        $invoice_detail=InvoiceDetailModel::where('invoice_id',$request->id)->get();
        foreach ($invoice_detail as $inv){
            if ($inv->type=='product'||$inv->type=='new_product'){
                //get current qty before cut stock
                $current_qty_pre=ProductModel::where('id',$inv->pro_id)->first()->current_qty;
                //update product current qty
                ProductModel::where('id',$inv->pro_id)->
                update(['current_qty'=>$current_qty_pre+$inv->qty]);
            }
        }

        //Stock End

        //delete all sub master
        InvoiceMultiMechanicModel::where('invoice_id',$request->id)->delete();
        InvoiceMultiSAModel::where('invoice_id',$request->id)->delete();
        InvoicePaymentModel::where('invoice_id',$request->id)->delete();
        InvoiceDetailModel::where('invoice_id',$request->id)->delete();


    }

    //list product for description
    public function invoice_products(){
//        return invoice_product();
        return ProductModel::select('product.name as name')
            ->groupBy('name')
            ->get();
    }

    //check product qty
    public function check_product_qty(Request $request){

        //check if product or not
        $pro=ProductModel::where('id',$request->code_part)->first();
        if (!empty($pro)){
            //check if product qty smaller than input new qty
            //check if qty is update or create
            if (!empty($request->invoice_id)){
                //update
                //get invoice detail qty
                $invoice_detail=InvoiceDetailModel::where('invoice_id',$request->invoice_id)
                    ->where('pro_id',$request->code_part)
                    ->first();

                //check if invoice is empty or not
                if (!empty($invoice_detail)){
                    $current_qty=$pro->current_qty+$invoice_detail->qty;

                    if ($request->qty>$current_qty){
                        return response()->json(['check_qty'=>'false',
                            'id'=>$request->id,
                            'pro_qty'=>$current_qty
                        ]);
                    }

                }else{
                    //if invoice detail have add new product check like create
                    //create
                    if ($request->qty>$pro->current_qty){
                        return response()->json(['check_qty'=>'false',
                            'id'=>$request->id,
                            'pro_qty'=>$pro->current_qty
                        ]);
                    }
                }


            }else{
                //create
                if ($request->qty>$pro->current_qty){
                    return response()->json(['check_qty'=>'false',
                        'id'=>$request->id,
                        'pro_qty'=>$pro->current_qty
                    ]);
                }
            }


        }

        return response()->json(['check_qty'=>'true',
            'id'=>$request->id,
            'qty'=>$request->qty,
        ]);
    }

    //check description
    public function check_des(Request $request){

        //check if product or not
        $check_des=ProductModel::where('name',$request->des)->first();
        $code_part=ProductModel::where('name',$request->des)->orderBy('id','DESC')
            ->select('product.code_part as code_part','product.id as id')
            ->get();
        if (!empty($check_des)){
            return response()->json(['des'=>'false',
                'id'=>$request->id,
                'pro_id'=>$request->des,
                'code_part'=>$code_part
            ]);
        }else{
            return response()->json(['des'=>'true',
                'id'=>$request->id,
            ]);
        }


    }

    public function save_update(Request $request){
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            'date' => 'required',
            'km' => 'max:50',
            'ro' => 'max:50',
            'note' => 'max:500'
        ]);

        if ($validator->passes()){
        //            return $request->all();

            //set default cat id
            $cus_id=$request->customer;

            //check if customer have add new value
            $check_cus=CustomerModel::where('id',$request->customer)->count();
            //if new value
            if ($check_cus==0&&!empty($request->customer)){
                //get last customer
                $count_master=CustomerModel::count();
                //if no customer default id to 1
                $id_number=1;
                if ($count_master!=0){
                    //when customer more than one plus id number +1
                    $cus=CustomerModel::orderBy('id','DESC')->first();
                    $id_number=$cus->id_number+1;
                }
                //add new cus
                $cus=new CustomerModel();
                $cus->id_number=$id_number;
                $cus->name=$request->customer;
                $cus->type='new';
                $cus->save();

                //change cus id to new cus
                $cus_id=$cus->id;
            }

            //Update master
            InvoiceModel::where('id',$request->update_id)
                ->update([
                    'date'=>$request->date,
                    'cus_id'=>$cus_id,
                    'km'=>$request->km,
                    'ro'=>$request->ro,
                    'note'=>$request->note,
                    'total_amount'=>0,
                    'total_paid'=>0,
                    'total_remaining'=>0
                ]);

            //remove old SA
            InvoiceMultiSAModel::where('invoice_id',$request->update_id)->delete();
            //add new SA
            if(!empty($request->sa)) {
                foreach ($request->sa as $sa) {

                    $multi_sa = new InvoiceMultiSAModel();
                    $multi_sa->invoice_id = $request->update_id;
                    $multi_sa->user_id = $sa;
                    $multi_sa->save();
                }
            }

            //remove old Mechanic
            InvoiceMultiMechanicModel::where('invoice_id',$request->update_id)->delete();
            //add new Mechanic
            if(!empty($request->mechanic)) {
                foreach ($request->mechanic as $mechanic) {
                    $multi_mechanic = new InvoiceMultiMechanicModel();
                    $multi_mechanic->invoice_id = $request->update_id;
                    $multi_mechanic->user_id = $mechanic;
                    $multi_mechanic->save();
                }
            }

            //remove old Seller
            InvoiceMultiSellerModel::where('invoice_id',$request->update_id)->delete();
            //add new Seller
            if(!empty($request->seller)) {
                foreach ($request->seller as $seller) {
                    $multi_seller = new InvoiceMultiSellerModel();
                    $multi_seller->invoice_id = $request->update_id;
                    $multi_seller->user_id = $seller;
                    $multi_seller->save();
                }
            }

            //Stock Start
            $invoice_detail=InvoiceDetailModel::where('invoice_id',$request->update_id)->get();
            foreach ($invoice_detail as $inv){
                if ($inv->type=='product'||$inv->type=='new_product'){
                    //get current qty before cut stock
                    $current_qty_pre=ProductModel::where('id',$inv->pro_id)->first()->current_qty;
                    //update product current qty
                    ProductModel::where('id',$inv->pro_id)->
                    update(['current_qty'=>$current_qty_pre+$inv->qty]);
                }
            }

            //Stock End

            //delete all detail
            InvoiceDetailModel::where('invoice_id',$request->update_id)->delete();

            //Update total amount
            InvoiceModel::where('id',$request->update_id)
                ->update([
                    'total_amount'=>str_replace(',', '', $request->total_amount),
                    'total_remaining'=>str_replace(',', '', $request->total_amount),
                    'amount'=>str_replace(',', '', $request->amount),
                    'dis_type'=>$request->dis_type,
                    'dis_amount'=>str_replace(',', '', $request->dis_amount),
                    'dis_total_amount'=>str_replace(',', '', $request->dis_total_amount),

                ]);

            //check if have payment or not
            $payment=InvoicePaymentModel::where('invoice_id',$request->update_id)->count();
            if ($payment>0){
                //get all amount in payment
                $paid=InvoicePaymentModel::where('invoice_id',$request->update_id)->sum('amount');
                //get new invoice total amount
                $amount=InvoiceModel::where('id',$request->update_id)->first()->total_amount;
                //get remaining
                $remain=$amount-$paid;

                //update invoice
                if ($paid>=$amount){
                    InvoiceModel::where('id',$request->update_id)
                        ->update([
                            'payment_status'=>'paid',
                            'total_amount'=>$amount,
                            'total_paid'=>$paid,
                            'total_remaining'=>$remain
                        ]);
                }elseif ($paid>0){
                    InvoiceModel::where('id',$request->update_id)
                        ->update([
                            'payment_status'=>'partial',
                            'total_amount'=>$amount,
                            'total_paid'=>$paid,
                            'total_remaining'=>$remain
                        ]);
                }else{
                    InvoiceModel::where('id',$request->update_id)
                        ->update([
                            'payment_status'=>'credit',
                            'total_amount'=>$amount,
                            'total_paid'=>$paid,
                            'total_remaining'=>$remain
                        ]);
                }


            }else{
                InvoiceModel::where('id',$request->update_id)
                    ->update([
                        'payment_status'=>'credit'
                    ]);
            }

            return response()->json(['verify'=>'true',
                'invoice_id'=>$request->update_id
            ]);
        }

        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }

    public function save_update_detail(Request $request){

        //set default
        $cost_price=$request->cost_price;
        if ($cost_price=='NaN'){
            $cost_price=0;
        }

        $price=0;
        $total=0;
        $pro_id=0;
        $des='';

        //check if price is not free
        if ($request->total>0){
            $price=$request->price;
            $total=$request->total;
        }

        //check description
        if ($request->des_type=='product'){
            //if description is product
            $pro_id=$request->code_part;
        }/*elseif ($request->des_type=='new_product'){
            //if description is new product
            //add new product automatically
            $pro=new ProductModel();
            $pro->name=$request->des;
            $pro->total_qty=$request->qty;
            $pro->current_qty=$request->qty;
            $pro->user_id=Auth::user()->id;
            $pro->save();

            //add new product detail
            $pro_detail=new ProductDetailModel();
            $pro_detail->sell_price=$price;
            $pro_detail->qty=$request->qty;
            $pro_detail->pro_id=$pro->id;
            $pro_detail->save();

            $pro_id=$pro->id;

        }*/else{
            //if description is other
            $des=$request->des;
        }

        //only check if product
        if ($request->des_type=='product'||$request->des_type=='new_product'){
            //Stock Start

            //get current qty before cut stock
            $current_qty_pre=ProductModel::where('id',$pro_id)->first()->current_qty;
            //update product current qty
            ProductModel::where('id',$pro_id)->
                update(['current_qty'=>$current_qty_pre-$request->qty]);

            //Stock End

            //Alert notification if current qty product = 1
            //get current qty after cut stock

/*            $current_qty=ProductModel::where('id',$pro_id)->first()->current_qty;
            if ($current_qty<=3&&$current_qty>0){
                //Permission Start
                $pro=ProductModel::find($pro_id);
                $user=User::where('status',1)->get();
                foreach ($user as $u){

                    //Custom get permission role
                    $pri=get_per_by_role('notification','allow_notification',$u->role_id);

                    //Send notification only user who has permission
                    if ($pri){
                        $u->notify(new NotifyLowStock($pro));
                    }

                }
                //Permission End
            }*/

        }


        //add invoice detail
        $detail=new InvoiceDetailModel();
        $detail->qty=$request->qty;
        $detail->cost_price=$cost_price;
        $detail->price=$price;
        $detail->total=$total;
        $detail->total_cost=$request->qty*$cost_price;
        $detail->type=$request->des_type;
        $detail->des=$des;
        $detail->pro_id=$pro_id;
        $detail->invoice_id=$request->invoice_id;
        $detail->note=$request->note;
        $detail->save();

/*        //get master
        $invoice=InvoiceModel::find($request->invoice_id);
        //update master
        $total_amount=$request->total;
        $total_remain=$request->total;
        InvoiceModel::where('id',$request->invoice_id)
            ->update([
                'total_amount'=>$invoice->total_amount+=$total_amount,
                'total_remaining'=>$invoice->total_remaining+=$total_remain
            ]);*/

        return response()->json(['last'=>$request->last]);
    }

    public function save_update_payment(Request $request){
        $payment=new InvoicePaymentModel();
        $payment->date=date('Y-m-d');
        $payment->amount=$request->amount;
        $payment->note=$request->note;
        $payment->invoice_id=$request->invoice_id;
        $payment->save();

        //update invoice
        $invoice=InvoiceModel::where('id',$request->invoice_id)->first();
        $total_remain=$invoice->total_amount-($request->amount+$invoice->total_paid);

        //check if payment is paid equal to total or bigger
        if (($request->amount+$invoice->total_paid)>=$invoice->total_amount){
            InvoiceModel::where('id',$request->invoice_id)
                ->update(['payment_status'=>'paid',
                    'total_paid'=>$request->amount+$invoice->total_paid,
                    'total_remaining'=>$total_remain
                ]);
        }elseif ($request->amount+$invoice->total_paid>0){
            //if payment is paid but not enough
            InvoiceModel::where('id',$request->invoice_id)
                ->update(['payment_status'=>'partial',
                    'total_paid'=>$request->amount+$invoice->total_paid,
                    'total_remaining'=>$total_remain
                ]);
        }

        return response()->json(['verify'=>'true',
        ]);
    }

    public function get_data_by_date(Request $request){

        $cost_in_stock=Liseng::cost_in_stock($request->start,$request->end,$request->user,$request->seller);
        $cost_out_stock=Liseng::cost_out_stock($request->start,$request->end,$request->user,$request->seller);
        $total_amount=Liseng::total_amount($request->start,$request->end,$request->user,$request->seller);
        $total_paid=Liseng::total_paid($request->start,$request->end,$request->user,$request->seller);
        $total_remain=Liseng::total_remain($request->start,$request->end,$request->user,$request->seller);


        return response()->json([
            'cost_in_stock'=>$cost_in_stock,
            'cost_out_stock'=>$cost_out_stock,
            'total_amount'=>$total_amount,
            'total_paid'=>$total_paid,
            'total_remain'=>$total_remain
        ]);
    }

    public function pagination($page){

        $master_pag=InvoiceModel::select('date')
            ->groupBy('date')
            ->orderBy('date','DESC')
            ->paginate(1,['*'],'page',$page);

        $cost_in_stock=Liseng::cost_in_stock($master_pag->first()->date,$master_pag->first()->date);
        $cost_out_stock=Liseng::cost_out_stock($master_pag->first()->date,$master_pag->first()->date);
        $total_amount=Liseng::total_amount($master_pag->first()->date,$master_pag->first()->date);
        $total_paid=Liseng::total_paid($master_pag->first()->date,$master_pag->first()->date);
        $total_remain=Liseng::total_remain($master_pag->first()->date,$master_pag->first()->date);

        return response()->json(['next_page'=>$master_pag->nextPageUrl(),'has_more_pages'=>$master_pag->hasMorePages(),
            'previousPageUrl'=>$master_pag->previousPageUrl(),'total'=>$master_pag->total(),'per_page'=>1,'current_page'=>$master_pag->currentPage(),
            'master_pag'=>$master_pag,'cost_in_stock'=>$cost_in_stock,'cost_out_stock'=>$cost_out_stock,'total_amount'=>$total_amount,'total_paid'=>$total_paid,
            'total_remain'=>$total_remain,'date'=>$master_pag->first()->date
        ]);
    }

    public function export_invoice($id){
       
        return \Excel::create('Invoice-'.Carbon::now(), function($excel) use ($id) {
                $excel->sheet('Detail', function($sheet) use ($id) {
                    
                    $sheet->setWidth(array(
                        'A'     =>  10,
                        'B'     =>  80,
                        'C'     =>  30,
                        'D'     =>  30,
                        'E'     =>  30
                    ));
                    $sheet->cells('A11:E1000', function($cells) {
                        $cells->setAlignment('center');
                    });
          
                    $sheet->loadView('invoice.export')->with('id',$id);

                });

                ob_end_clean();
            })->download('xls');
    }
}
