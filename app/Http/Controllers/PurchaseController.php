<?php

namespace App\Http\Controllers;

use App\InvoiceDetailModel;
use App\PurchaseModel;
use App\SupplierModel;
use App\PurchasePaymentModel;
use App\ProductModel;
use App\ProductDetailModel;
use Liseng;
use App\PurchaseDetailModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{

    //Server Side
    function get_data()
    {
        //get all master and relationship values
        $master = PurchaseModel::orderBy('id','DESC')
                ->join('supplier', 'purchase.supplier_id', '=', 'supplier.id')
                ->select('purchase.*','supplier.name as sup_name');
                
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
                ->whereBetween( DB::raw('date(purchase.created_at)'), [$start, $end] );

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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Permission Start
        if (!config('global.view_purchase')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.purchase_icon')]);
        config(['global.text_content_title' => 'Purchases']);

        //set index link
        config(['global.index_link' => 'purchase.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Purchases Found']);
        config(['global.no_data_text' => 'You have not added any purchase add first purchase now']);
        config(['global.no_data_btn' => 'Add New Purchase']);

        //set link add new
        config(['global.add_new_link' => '/purchases/create']);
        //set link update
        config(['global.update_link' => '/purchases/update']);
        config(['global.print_link' => '/purchases/print']);

        //set delete
        config(['global.alert_delete_title' => 'This purchase and all sub purchases will be deleted.']);
        config(['global.delete_link' => 'master_delete.purchase']);
        config(['global.after_delete_text' => 'Purchase and all sub purchases have been deleted.']);
        config(['global.cant_delete_text' => 'The invoices related to this purchase exist.']);

        $master = PurchaseModel::all();

        //for filter date
        if (!$master->isEmpty()){
            //get first master date
            $first_master = PurchaseModel::orderBy('date','ASC')->first();
            config(['global.start_date'=>$first_master->created_at]);
        }


        $data=array(
            'master' => $master
        );

        return view('purchase.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Permission Start
        if (!config('global.add_purchase')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.purchase_icon')]);
        config(['global.text_content_title' => 'Add new purchase']);
        config(['global.parent_text_content_title' => 'Purchases']);

        //set submit route
        config(['global.submit_link' => 'purchases.store']);
        //set index route
        config(['global.index_link' => '/purchases']);

        $sup  = getAllSupplier();
        $user = getAllUser();

        $data=array(
            'users' => $user,
            'sup'   => $sup,
        );
        return view('purchase.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(Liseng::countSupplier($request->supplier));
        $validator = Validator::make($request->all(), [
            'supplier' => 'required',
            'date'     => 'required',
            'note'     => 'max:500'
        ]);

        if ($validator->passes()){

            //set default cat id
            $sup_id = $request->supplier;

            //check if supplier have add new value
            $check_sup = Liseng::countSupplier($sup_id);
            //if new value
            if ($check_sup==0&&!empty($sup_id)){
                //get last supplier
                $count_sup = Liseng::countSupplier();
                //if no supplier default id to 1
                $id_number = 1;
                if ($count_sup!=0){
                    //when supplier more than one plus id number +1
                    $sup       = Liseng::getLastSupplier();
                    $id_number = $sup->id_number+1;
                }

                //add new supplier
                $sup       = new SupplierModel();
                $sup->name = $sup_id;
                $sup->save();

                //change cus id to new cus
                $sup_id = $sup->id;
            }

            //check if has purchase or not
            $purchase_count = PurchaseModel::count();
            if ($purchase_count==0){
                $no = 1;
            }else{
                $last_purchase = PurchaseModel::orderBy('id','DESC')->first();
                $no            = $last_purchase->ref_no+1;
            }

            $master         = new PurchaseModel();
            $master->ref_no = $no;
            $master->date=$request->date;
            $master->supplier_id     = $sup_id;
            $master->note            = $request->note;
            $master->payment_status  = 'due';
            $master->purchase_status = 'pending';
            // $master->purchase_due=123;
            $master->user_id = Auth::user()->id;
            $master->total_amount=str_replace(',', '', $request->total_amount);
            $master->total_remaining=str_replace(',', '', $request->total_amount);
            $master->save();


            return response()->json(['verify'=>'true',
                'purchase_id' => $master->id
            ]);
        }

        return ['errors' => $validator->errors()];
    }

    public function store_detail(Request $request)
    {

        //set default
        $pro_id = 0;
        $des    = '';

        //if description is product
        $pro_id = $request->code_part;


        //Stock Start
        $current_qty_pre=ProductModel::where('id',$pro_id)->first()->current_qty;
        $total_qty_pre=ProductModel::where('id',$pro_id)->first()->total_qty;

        //update product qty
        ProductModel::where('id',$pro_id)
            ->update([
                'current_qty'=>$current_qty_pre+$request->qty,
                'total_qty'=>$total_qty_pre+$request->qty
            ]);
        //Stock End

        //check description
        /*if ($request->des_type=='product'){
        //if description is product
            $pro_id = $request->code_part;


            //Stock Start
            $current_qty_pre=ProductModel::where('id',$pro_id)->first()->current_qty;
            $total_qty_pre=ProductModel::where('id',$pro_id)->first()->total_qty;

            //update product qty
            ProductModel::where('id',$pro_id)
                ->update([
                    'current_qty'=>$current_qty_pre+$request->qty,
                    'total_qty'=>$total_qty_pre+$request->qty
                ]);
            //Stock End

        }else{*/

            /*$pro              = new ProductModel();
            $pro->name        = $request->des;
            $pro->total_qty   = $request->qty;
            $pro->current_qty = $request->qty;
            $pro->user_id     = Auth::user()->id;
            $pro->save();*/

            //add new product detail
           /* $pro_detail             = new ProductDetailModel();
            $pro_detail->sell_price = $request->sell_price;
            $pro_detail->cost_price = $request->cost_price;
            $pro_detail->qty        = $request->qty;
            $pro_detail->profit     = $request->profit;
            $pro_detail->total_cost = $request->total_cost;
            $pro_detail->pro_id     = $pro->id;
            $pro_detail->save();*/

//            $pro_id = $pro->id;
     //   }

        //add purchase detail
        $detail             = new PurchaseDetailModel();
        $detail->type       = $request->des_type;
        $detail->cost_price = $request->cost_price;
        $detail->sell_price = $request->sell_price;
        $detail->qty        = $request->qty;
        $detail->total_cost = $request->total_cost;
        $detail->profit      = $request->profit;
        $detail->pro_id      = $pro_id;
        $detail->purchase_id = $request->purchase_id;
        $detail->save();

        //get master
/*        $purchase = PurchaseModel::find($request->purchase_id);
        //update master
        $total_amount = $request->total_cost;
        $total_remain = $request->total_cost;
        PurchaseModel:: where('id',$request->purchase_id)
            ->update([
                'total_amount'   =>$purchase->total_amount    += $total_amount,
                'total_remaining'=>$purchase->total_remaining += $total_remain
            ]);*/

        return response()->json(['last'=>$request->last]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseModel  $purchaseModel
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseModel $purchaseModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseModel  $purchaseModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Permission Start
        if (!config('global.update_purchase')){
            return view('errors.not_found');
        }
        //Permission End

        config(['global.icon_content_title' => config('global.purchase_icon')]);
        config(['global.text_content_title' => 'Edit Purchase']);
        config(['global.parent_text_content_title' => 'Purchases']);

        //set submit route
        config(['global.submit_link' => 'save_update.purchase']);
        //set index route
        config(['global.index_link' => '/purchases']);

        $sup    = Liseng::getSupplier();
        $pa     = Liseng::getUser();
        $master = PurchaseModel::where('id',$id)->first();

        $data=array(
            'sup'    => $sup,
            'pa'     => $pa,
            'master' => $master
        );


        return view('purchase.update',$data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseModel  $purchaseModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $purchase_detail=PurchaseDetailModel::where('purchase_id',$request->id)->get();

        //Check if has related invoice with product start
        foreach ($purchase_detail as $pd){
            //Check if related invoice
            $invoice_detail=InvoiceDetailModel::where('pro_id',$pd->pro_id)->count();
            if ($invoice_detail>0){
                return response()->json(['delete'=>'false']);
            }
        }
        //Check if has related invoice with product end

        //Stock Start
        foreach ($purchase_detail as $pd){
            $product=ProductModel::find($pd->pro_id);
            ProductModel::where('id',$pd->pro_id)
                ->update(['total_qty'=>$product->total_qty-$pd->qty,
                        'current_qty'=>$product->current_qty-$pd->qty
                    ]);
        }
        //Stock End

        //delete master
        PurchaseModel:: where('id',$request->id)->delete();

        //delete all sub master
        PurchasePaymentModel:: where('purchase_id',$request->id)->delete();
        PurchaseDetailModel:: where('purchase_id',$request->id)->delete();


    }

    public function delete_payment(Request $request){
        //delete all sale payment
        PurchasePaymentModel:: where('purchase_id',$request->purchase_id)->delete();

        //update purchase
        PurchaseModel:: where('id',$request->purchase_id)
            ->update([
                'total_paid'      => 0,
                'total_remaining' => 0
                ]);
    }

    // Add sale payment multiple
    public function store_payment_multi(Request $request){

        //if payment date is empty
        if ($request->date=='NaN-NaN-NaN'){
            $request->date = null;
        }

        //only add to database if one have value
        if (!empty($request->date)||!empty($request->amount)||!empty($request->note)){
            $pa              = new PurchasePaymentModel();
            $pa->date        = $request->date;
            $pa->amount      = $request->amount;
            $pa->note        = $request->note;
            $pa->purchase_id = $request->purchase_id;
            $pa->save();
        }
        //update purchase
        $purchase = PurchaseModel::where('id',$request->purchase_id)->first();
        // dd($request->all());
        $total_paid   = $purchase->total_paid+$request->amount;
        $total_remain = $purchase->total_amount-$total_paid;
        //check if payment is paid equal to total or bigger
        if ($total_paid>=$purchase->total_amount){
            PurchaseModel:: where('id',$request->purchase_id)
            ->update([
                'payment_status'  => 'paid',
                'total_paid'      => $total_paid,
                'total_remaining' => $total_remain
            ]);
        }elseif ($total_paid>0){
            //if payment is paid but not enough
            PurchaseModel:: where('id',$request->purchase_id)
                ->update([
                    'payment_status'  => 'partial',
                    'total_paid'      => $total_paid,
                    'total_remaining' => $total_remain
                    ]);
        }else{
            PurchaseModel:: where('id',$request->purchase_id)
            ->update(['payment_status'=>'due',
                    'total_paid'      => $total_paid,
                    'total_remaining' => $total_remain
                ]);
            }
        return response()->json(['verify'=>'true']);   
    }

    //Get data payment to view
    public function update_payment($id){

        $data=array(
            'payment' => PurchasePaymentModel::orderBy('id','ASC')->where('purchase_id',$id)->get(),
        );

        return $data;
    }

    //check product qty
    public function check_product_qty(Request $request){

        //check if product or not
        $check_pro = ProductModel::where('id',$request->des)->first();
        if (!empty($check_pro)){
            //check if product qty smaller than input new qty
            if ($check_pro->current_qty<$request->qty){
                return response()->json(['check_qty'=>'false',
                    'id'      => $request->id,
                    'pro_qty' => $check_pro->current_qty
                ]);
            }
        }

        return response()->json(['check_qty'=>'true',
            'id' => $request->id,
        ]);
    }

/*    //check description
    public function check_des(Request $request){

        //check if product or not
        $check_des = ProductModel::where('id',$request->des)->first();
        if (!empty($check_des)){
            return response()->json(['des'=>'false',
                'id' => $request->id,
            ]);
        }else{
            return response()->json(['des'=>'true',
                'id' => $request->id,
            ]);
        }
    }*/
    
    //Get detail data to view
    public function update_detail($id){

        $detail=PurchaseDetailModel::leftjoin('product','product.id','purchase_detail.pro_id')
            ->orderBy('purchase_detail.id','ASC')
            ->where('purchase_detail.purchase_id',$id)
            ->select('purchase_detail.*','product.name as pro_name','product.id as pro_id','product.code_part as code_part')
            ->get();

        $data=array(
            'detail'           => $detail,
            'grand_total'      => PurchaseModel::where('id',$id)->first()->total_amount,
            'purchase_product' => Liseng::getProduct()
        );
        return $data;
    }

    public function save_update(Request $request){
        $validator = Validator::make($request->all(), [
            'supplier' => 'required',
            'date'     => 'required',
            'note'     => 'max:500'
        ]);

        if ($validator->passes()){

            //set default cat id
            $sup_id = $request->supplier;

            //check if supplier have add new value
            $check_cus = SupplierModel::where('id',$request->supplier)->count();
            //if new value
            if ($check_cus==0&&!empty($request->supplier)){
                //get last supplier
                $count_master = SupplierModel::count();
                //if no supplier default id to 1
                $id_number = 1;
                if ($count_master!=0){
                    //when supplier more than one plus id number +1
                    $sup       = SupplierModel::orderBy('id','DESC')->first();
                    $id_number = $sup->id_number+1;
                }
                //add new cus
                $sup            = new SupplierModel();
                $sup->id_number = $id_number;
                $sup->name      = $request->supplier;
                $sup->type      = 'new';
                $sup->save();

                //change cus id to new cus
                $sup_id = $sup->id;
            }

            //Update master
            PurchaseModel:: where('id',$request->update_id)
                ->update([
                    'date'=>$request->date,
                    'supplier_id'     => $sup_id,
                    'note'            => $request->note,
                    'total_amount'    => str_replace(',', '', $request->total_amount),
                    'total_remaining' => str_replace(',', '', $request->total_amount)
                ]);

            //Stock Start
            $purchase_detail=PurchaseDetailModel::where('purchase_id',$request->update_id)->get();
            foreach ($purchase_detail as $pur){
                if ($pur->type=='product'||$pur->type=='new_product'){
                    //get current qty and total qty before cut stock
                    $current_qty_pre=ProductModel::where('id',$pur->pro_id)->first()->current_qty;
                    $total_qty=ProductModel::where('id',$pur->pro_id)->first()->total_qty;
                    //update product current qty
                    ProductModel::where('id',$pur->pro_id)->
                    update(['current_qty'=>$current_qty_pre-$pur->qty,
                            'total_qty'=>$total_qty-$pur->qty
                            ]);
                }
            }

            //Stock End

            //delete all detail
            PurchaseDetailModel:: where('purchase_id',$request->update_id)->delete();

            //check if have payment or not
            $payment = PurchasePaymentModel::where('purchase_id',$request->update_id)->count();
            if ($payment>0){
                //get all amount in payment
                $paid = PurchasePaymentModel::where('purchase_id',$request->update_id)->sum('amount');
                //get new purchase total amount
                $amount = PurchaseModel::where('id',$request->update_id)->first()->total_amount;
                //get remaining
                $remain = $amount-$paid;

                //update purchase

                //check if payment is paid equal to total or bigger
                if ($paid>=$amount){
                    PurchaseModel::where('id',$request->update_id)
                        ->update(['payment_status'=>'paid',
                            'total_amount'=>$amount,
                            'total_paid'=>$paid,
                            'total_remaining'=>$remain
                        ]);
                }elseif ($paid>0){
                    //if payment is paid but not enough
                    PurchaseModel::where('id',$request->update_id)
                        ->update(['payment_status'=>'partial',
                            'total_amount'=>$amount,
                            'total_paid'=>$paid,
                            'total_remaining'=>$remain
                        ]);
                }

            }else{
                PurchaseModel::where('id',$request->update_id)
                    ->update(['payment_status'=>'due']);
            }

            return response()->json(['verify'=>'true',
                'purchase_id' => $request->update_id
            ]);
        }

        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }

    public function save_update_detail(Request $request){

        //set default
        $pro_id = 0;
        $des    = '';

        $pro_id = $request->code_part;

        //Stock Start
        $current_qty_pre=ProductModel::where('id',$pro_id)->first()->current_qty;
        $total_qty_pre=ProductModel::where('id',$pro_id)->first()->total_qty;

        //update product qty
        ProductModel::where('id',$pro_id)
            ->update([
                'current_qty'=>$current_qty_pre+$request->qty,
                'total_qty'=>$total_qty_pre+$request->qty
            ]);

        //check description
        /*if ($request->des_type=='product'){
            //if description is product
            $pro_id = $request->des;

            //Stock Start
            $current_qty_pre=ProductModel::where('id',$pro_id)->first()->current_qty;
            $total_qty_pre=ProductModel::where('id',$pro_id)->first()->total_qty;

            //update product qty
            ProductModel::where('id',$pro_id)
                ->update([
                    'current_qty'=>$current_qty_pre+$request->qty,
                    'total_qty'=>$total_qty_pre+$request->qty
                ]);
            //Stock End

        }else{

            $pro              = new ProductModel();
            $pro->name        = $request->des;
            $pro->total_qty   = $request->qty;
            $pro->current_qty = $request->qty;
            $pro->user_id     = Auth::user()->id;
            $pro->save();*/

            //add new product detail
            /* $pro_detail             = new ProductDetailModel();
             $pro_detail->sell_price = $request->sell_price;
             $pro_detail->cost_price = $request->cost_price;
             $pro_detail->qty        = $request->qty;
             $pro_detail->profit     = $request->profit;
             $pro_detail->total_cost = $request->total_cost;
             $pro_detail->pro_id     = $pro->id;
             $pro_detail->save();*/

            //$pro_id = $pro->id;
//        }

        //add purchase detail
        $detail             = new PurchaseDetailModel();
        $detail->type       = $request->des_type;
        $detail->cost_price = $request->cost_price;
        $detail->sell_price = $request->sell_price;
        $detail->qty        = $request->qty;
        $detail->total_cost = $request->total_cost;
        $detail->profit      = $request->profit;
        $detail->pro_id      = $pro_id;
        $detail->purchase_id = $request->purchase_id;
        $detail->save();

        //get master
/*        $purchase = PurchaseModel::find($request->purchase_id);
        //update master
        $total_amount = $request->total_cost;
        $total_remain = $request->total_cost;
        PurchaseModel:: where('id',$request->purchase_id)
            ->update([
                'total_amount'   =>$purchase->total_amount    += $total_amount,
                'total_remaining'=>$purchase->total_remaining += $total_remain
            ]);*/

        return response()->json(['last'=>$request->last]);
    }

    public function store_payment(Request $request){

        $payment=new PurchasePaymentModel();
        $payment->date=date('Y-m-d');
        $payment->amount=$request->amount;
        $payment->note=$request->note;
        $payment->purchase_id=$request->purchase_id;
        $payment->save();

        //update purchase
        $purchase=PurchaseModel::where('id',$request->purchase_id)->first();
        $total_remain=$purchase->total_amount-$request->amount;
        //check if payment is paid equal to total or bigger
        if ($request->amount>=$purchase->total_amount){
            PurchaseModel::where('id',$request->purchase_id)
                ->update(['payment_status'=>'paid',
                    'total_paid'=>$request->amount,
                    'total_remaining'=>$total_remain
                ]);
        }elseif ($request->amount>0){
            //if payment is paid but not enough
            PurchaseModel::where('id',$request->purchase_id)
                ->update(['payment_status'=>'partial',
                    'total_paid'=>$request->amount,
                    'total_remaining'=>$total_remain
                ]);
        }

        return response()->json(['verify'=>'true',
        ]);
    }


}
