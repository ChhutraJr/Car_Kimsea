<?php
// namespace App;

use App\PurchaseDetailModel;
use App\PurchasePaymentModel;
use App\SupplierModel;
use App\ProductModel;
use App\ProductDetailModel;
use App\User;
use App\InvoiceModel;
use App\InvoiceDetailModel;
use App\CustomerModel;
use App\CustomerMultiTelModel;
use App\VehicleModel;
use App\VehicleModelModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\ExpenseModel;

class Liseng{

    //for invoice create the same customer
    public static $sa='';
    public static $mechanic='';
    public static $seller='';

    //get purchase detail
    public static function getPurchaseDetail($value=null){
        if(isset($value) && $value){
            return PurchaseDetailModel::where('purchase_id',$value)->get();
        }
        return PurchaseDetailModel::orderBy('id','DESC')->get();
    }
    
    //get sum of purchase detail
    public static function getSumPurchaseDetail($value=null){
        if(isset($value) && $value){
            $total_detail=0;
            $detail_items=PurchaseDetailModel::where('purchase_id',$value)->get();
            foreach($detail_items as $item){
                $total_detail+=$item->total_cost;
            }
            return $total_detail;
        }
        return PurchaseDetailModel::sum('total_cost');
    }
    
    //get purchase payment
    public static function getPurchasePayment($value=null){
        if(isset($value) && $value){
            return PurchasePaymentModel::where('purchase_id',$value)->get();
        }
        return PurchasePaymentModel::orderBy('id','DESC')->get();
    }

    //get supplier
    public static function getSupplier($value=null){
        if(isset($value) && $value){
            return SupplierModel::find($value);
        }
        return SupplierModel::orderBy('id','DESC')->get();
    }

    //count supplier
    public static function countSupplier($value=null){
        if(isset($value) && $value){
            return SupplierModel::where('id',$value)->count();
        }
        return SupplierModel::orderBy('id','DESC')->count();
    }

    //get last supplier
    public static function getLastSupplier(){
        return SupplierModel::orderBy('id','DESC')->first();
    }

    //get users
    public static function getUser($value=null){
        if(isset($value) && $value){
            return User::find($value);
        }
        return User::orderBy('id','DESC')->get();
    }

    //get products
    public static function getProduct($value=null){
        if(isset($value) && $value){
            return ProductModel::find($value);
        }
        return ProductModel::orderBy('id','DESC')->get();
    }

    //get customer
    public static function getCustomerBySellID($value=null){
        if(isset($value) && $value){
            $invoice = InvoiceModel::find($value);
            return CustomerModel::find($invoice->cus_id);
        }
        return '';
    } 

    //get customer tel
    public static function getCustomerTelBySellID($value=null){

        //declare a variable to store all tel
        $tel='';
        $invoice = InvoiceModel::find($value);
        //check if has tel or not
        if(isset($value) && $value){

            //sign divide tel
            $divide='';
            //count tel
            $n=0;
            $multi_tels=CustomerMultiTelModel::where('cus_id',$invoice->cus_id)->get();

            //add multiple tel
            foreach ($multi_tels as $mt){
                //add , when more than one tel
                if ($n>0){
                    $divide='/';
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

/*        if(isset($value) && $value){
            $invoice = InvoiceModel::find($value);
            return CustomerMultiTelModel::where('cus_id',$invoice->cus_id)->get();
        }
        return '';*/
    }

    //get customer tel
    public static function getCustomerPlateBySellID($value=null){
        if(isset($value) && $value){
            $invoice = InvoiceModel::find($value);
            if(isset($invoice) && $invoice){
                return VehicleModel::where('cus_id',$invoice->cus_id)->first();
            }else{
                return '';
            }
        }
        return '';
    }

    //get customer model
    public static function getCustomerModelBySellID($value=null){
        if(isset($value) && $value){
            $invoice = InvoiceModel::find($value);

            $vehicle = VehicleModel::where('cus_id',$invoice->cus_id)->first();
            if(isset($vehicle) && $vehicle){
                return VehicleModelModel::find($vehicle->model_id);
            }else{
                return '';
            }
        }
        return '';
    }

    //get invoice
    public static function getInvoiceBySellID($value=null){
        if(isset($value) && $value){
            return InvoiceModel::find($value);
        }
        return '';
    }

    //get invoice details
    public static function getInvoiceDetailBySellID($value=null){
        if(isset($value) && $value){
            return InvoiceDetailModel::where('invoice_id',$value)->get();
        }
        return '';
    }
    //get product
    public static function getProductByInvoiceDetailID($value=null){
        if(isset($value) && $value){
            $invoice_detail = InvoiceDetailModel::find($value);
            if ($invoice_detail->type=='other'){
                return $invoice_detail->des;
            }else{
                return ProductModel::find($invoice_detail->pro_id)->name;
            }

        }
        return '';
    }

    //get product detail
    public static function getCostPriceByInvoiceDetailID($value=null){
        if(isset($value) && $value){
            $invoice_detail = InvoiceDetailModel::find($value);
            $product = ProductModel::find($invoice_detail->pro_id);

            return ProductDetailModel::where('pro_id',$product->id)->orderBy('id',"DESC")->first();
        }
        return '';
    }

    public static function get_latest_cost_price($pro_id){
        $cost_price=0;
        $product_detail=ProductDetailModel::orderBy('created_at','DESC')
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

        }

        return  $cost_price;
    }

    public static function get_latest_sell_price($pro_id){
        $sell_price=0;
        $product_detail=ProductDetailModel::orderBy('created_at','DESC')
            ->where('pro_id',$pro_id)
            ->first();
        $purchase_detail=PurchaseDetailModel::orderBy('created_at','DESC')
            ->where('pro_id',$pro_id)
            ->first();

        if (!empty($product_detail)||!empty($purchase_detail)){
            //if product detail is empty
            if (empty($product_detail)){
                $sell_price=$purchase_detail->sell_price;
            }elseif (empty($purchase_detail)){
                //if product purchase is empty
                $sell_price=$product_detail->sell_price;
            }else{
                //if product detail and product purchase is not empty
                if ($product_detail->created_at>$purchase_detail->created_at){
                    $sell_price=$product_detail->sell_price;
                }else{
                    $sell_price=$purchase_detail->sell_price;
                }
            }
        }

        return  $sell_price;
    }

    public static function get_stock_out($pro_id){
        $sum=InvoiceModel::join('invoice_detail','invoice_detail.invoice_id','invoice.id')
            ->where('invoice_detail.pro_id',$pro_id)
            ->sum('invoice_detail.qty');

        return $sum;
    }

    //Box Grand total Invoice Start
    public static function cost_in_stock($start,$end,$user='',$seller=''){

        $total=0;
        if ((!empty($user)&&$user!='all_users')||(!empty($seller)&&$seller!='all_sellers')){
            if ($seller=='all_sellers'){
                //if only have user sort
                $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                    ->where('type','product')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('user_id',$user)
                    ->sum('invoice_detail.total_cost');

            }elseif($user=='all_users'){
                //if only have seller sort
                $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                    ->where('type','product')
                    ->leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('invoice.date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->distinct()
                    ->sum('invoice_detail.total_cost');
            }else{
                //if sort both
                $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                    ->where('type','product')
                    ->leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->where('invoice.user_id',$user)
                    ->distinct()
                    ->sum('invoice_detail.total_cost');
            }

        }else{
            $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                ->where('type','product')
                ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice_detail.total_cost');

        }

        return '$'.number_format($total, 2);

/*        if (empty($user)||$user=='all_users'){
            $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                ->where('type','product')
                ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice_detail.total_cost');

            return  '$'.number_format($total, 2);
        }else{
            $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                ->where('type','product')
                ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->where('invoice.user_id',$user)
                ->sum('invoice_detail.total_cost');

            return  '$'.number_format($total, 2);
        }*/

    }

    public static function cost_out_stock($start,$end,$user='',$seller=''){

        $total=0;
        if ((!empty($user)&&$user!='all_users')||(!empty($seller)&&$seller!='all_sellers')){
            if ($seller=='all_sellers'){
                //if only have user sort
                $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                    ->where('type','other')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('user_id',$user)
                    ->sum('invoice_detail.total_cost');

            }elseif($user=='all_users'){
                //if only have seller sort
                $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                    ->where('type','other')
                    ->leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('invoice.date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->distinct()
                    ->sum('invoice_detail.total_cost');
            }else{
                //if sort both
                $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                    ->where('type','other')
                    ->leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->where('invoice.user_id',$user)
                    ->distinct()
                    ->sum('invoice_detail.total_cost');
            }

        }else{
            $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                ->where('type','other')
                ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice_detail.total_cost');

        }

        return '$'.number_format($total, 2);


/*        if (empty($user)||$user=='all_users'){
            $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                ->where('type','other')
                ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice_detail.total_cost');

            return  '$'.number_format($total, 2);
        }else{
            $total=InvoiceDetailModel::join('invoice','invoice.id','invoice_detail.invoice_id')
                ->where('type','other')
                ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->where('invoice.user_id',$user)
                ->sum('invoice_detail.total_cost');

            return  '$'.number_format($total, 2);
        }*/

    }

    public static function total_amount($start,$end,$user='',$seller=''){
        $total=0;
        if ((!empty($user)&&$user!='all_users')||(!empty($seller)&&$seller!='all_sellers')){
            if ($seller=='all_sellers'){
                //if only have user sort
                $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('user_id',$user)
                    ->sum('invoice.total_amount');

            }elseif($user=='all_users'){
                //if only have seller sort
                $total=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->distinct()
                    ->sum('invoice.total_amount');
            }else{
                //if sort both
                $total=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->where('invoice.user_id',$user)
                    ->distinct()
                    ->sum('invoice.total_amount');
            }

        }else{
            $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice.total_amount');

        }

        return '$'.number_format($total, 2);
        /*if (empty($user)||$user=='all_users'){
            $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice.total_amount');

            return  '$'.number_format($total, 2);
        }else{
            $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->where('user_id',$user)
                ->sum('invoice.total_amount');

            return  '$'.number_format($total, 2);
        }*/

    }

    public static function total_paid($start,$end,$user='',$seller=''){

        $total=0;
        if ((!empty($user)&&$user!='all_users')||(!empty($seller)&&$seller!='all_sellers')){
            if ($seller=='all_sellers'){
                //if only have user sort
                $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('user_id',$user)
                    ->sum('invoice.total_paid');

            }elseif($user=='all_users'){
                //if only have seller sort
                $total=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->distinct()
                    ->sum('invoice.total_paid');
            }else{
                //if sort both
                $total=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->where('invoice.user_id',$user)
                    ->distinct()
                    ->sum('invoice.total_paid');
            }

        }else{
            $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice.total_paid');

        }

        return '$'.number_format($total, 2);

/*        if (empty($user)||$user=='all_users'){
            $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice.total_paid');

            return  '$'.number_format($total, 2);
        }else{
            $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->where('user_id',$user)
                ->sum('invoice.total_paid');

            return  '$'.number_format($total, 2);
        }*/

    }

    public static function total_remain($start,$end,$user='',$seller=''){

        $total=0;
        if ((!empty($user)&&$user!='all_users')||(!empty($seller)&&$seller!='all_sellers')){
            if ($seller=='all_sellers'){
                //if only have user sort
                $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('user_id',$user)
                    ->sum('invoice.total_remaining');

            }elseif($user=='all_users'){
                //if only have seller sort
                $total=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->distinct()
                    ->sum('invoice.total_remaining');
            }else{
                //if sort both
                $total=InvoiceModel::leftjoin('invoice_multi_seller as s','s.invoice_id','invoice.id')
                    ->orderBy('date','DESC')
                    ->whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                    ->where('s.user_id',$seller)
                    ->where('invoice.user_id',$user)
                    ->distinct()
                    ->sum('invoice.total_remaining');
            }

        }else{
            $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice.total_remaining');

        }

        return '$'.number_format($total, 2);

/*        if (empty($user)||$user=='all_users'){
            $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->sum('invoice.total_remaining');

            return  '$'.number_format($total, 2);
        }else{
            $total=InvoiceModel::whereBetween( DB::raw('date(invoice.date)'), [$start, $end] )
                ->where('user_id',$user)
                ->sum('invoice.total_remaining');

            return  '$'.number_format($total, 2);
        }*/

    }

    //Box Grand total Invoice End

    //Box Grand total Expense Start
    public static function total_amount_exp($start,$end,$cat=''){
        if (empty($cat)||$cat=='all_cats'){
            //if no cat only sort date
            $total=ExpenseModel::whereBetween( DB::raw('date(expense.date)'), [$start, $end] )
                ->sum('expense.total_amount');

            return  '$'.number_format($total, 2);
        }else{
            $total=ExpenseModel::whereBetween( DB::raw('date(expense.date)'), [$start, $end] )
                ->where('cat_id',$cat)
                ->sum('expense.total_amount');

            return  '$'.number_format($total, 2);
        }

    }

    public static function total_paid_exp($start,$end,$cat=''){
        if (empty($cat)||$cat=='all_cats'){
            $total=ExpenseModel::whereBetween( DB::raw('date(expense.date)'), [$start, $end] )
                ->where('payment_status','paid')
                ->sum('expense.total_amount');

            return  '$'.number_format($total, 2);
        }else{
            $total=ExpenseModel::whereBetween( DB::raw('date(expense.date)'), [$start, $end] )
                ->where('payment_status','paid')
                ->where('cat_id',$cat)
                ->sum('expense.total_amount');

            return  '$'.number_format($total, 2);
        }

    }

    public static function total_credit_exp($start,$end,$cat=''){
        if (empty($cat)||$cat=='all_cats'){
            $total=ExpenseModel::whereBetween( DB::raw('date(expense.date)'), [$start, $end] )
                ->where('payment_status','credit')
                ->sum('expense.total_amount');

            return  '$'.number_format($total, 2);
        }else{
            $total=ExpenseModel::whereBetween( DB::raw('date(expense.date)'), [$start, $end] )
                ->where('payment_status','credit')
                ->where('cat_id',$cat)
                ->sum('expense.total_amount');

            return  '$'.number_format($total, 2);
        }

    }

    //Box Grand total Expense End
}