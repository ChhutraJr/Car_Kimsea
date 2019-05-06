<?php

use App\CustomerModel;
use App\InvoiceModel;
use App\ProductModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Notifications\NotifyPMReminder;
use App\Notifications\NotifyPostServiceFollowUp;

function get_product_description($id){
    $product = ProductModel::find($id);
    if($product){
       $des=$product->name;        
       return $des;   
    }
    return '';
}
function get_customer_multi_tel($customer_id){
    $customer = \App\CustomerModel::find($customer_id);
    $tel_multi = '';
    $count=0;
    $divide='';
    if($customer)  {
       $tels = $customer->multi_tel;
       if($tels){

           foreach($tels as $tel) {
                        if ($count>0){
                            $divide='/';
                        }
                        $count++;
                        //format tel
                        $trim=trim($tel->name,"(");
                        $str1=str_replace(')',' ',$trim);
                        $str2=str_replace('-',' ',$str1);

                        $tel_multi.=$divide.$str2;
           }
       }
    }


    return $tel_multi;
}
function get_multi_mechanic_name($invoice_id){
     $multi_mechanic_data = \App\InvoiceMultiMechanicModel::where('invoice_id',$invoice_id)->get();
     $count=0;
     $multi_mechanic='';
     if($multi_mechanic_data){


        foreach ($multi_mechanic_data as $mechanic){
             $count++;
            if ($count>1){
                $multi_mechanic.=' , '.$mechanic->user()->first()->first_name.' '.$mechanic->user()->first()->last_name;
            }else{
                //first mechanic
                $multi_mechanic.=$mechanic->user()->first()->first_name.' '.$mechanic->user()->first()->last_name;
            }
         }
     }
     return $multi_mechanic;
}
function get_multi_sa_name($invoice_id){
     $multi_sa_data = \App\InvoiceMultiSAModel::where('invoice_id',$invoice_id)->get();
     $count=0;
     $multi_sa='';
     if($multi_sa_data){
        foreach ($multi_sa_data as $sa){
            $count++;
               if ($count>1){
                   $multi_sa.=' , '.$sa->user()->first()->first_name.' '.$sa->user()->first()->last_name;
               }else{
                   //first sa
                   $multi_sa.=$sa->user()->first()->first_name.' '.$sa->user()->first()->last_name;
               }
        }
     }
     return $multi_sa;
}
//List all product category with popular product category count
function product_use_for(){
    return \App\ProductUseForModel::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM product WHERE product.cat_id = product_use_for.id) as count'))
    )->orderBy('count','desc')->get();
}

//List all product model with popular product model count
function product_model(){
    return \App\ProductModelModel::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM product WHERE product.model_id = product_model.id) as count'))
    )->orderBy('count','desc')->get();
}

//List all vehicle model with popular vehicle model count
function vehicle_model(){
    return \App\VehicleModelModel::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM vehicle WHERE vehicle.model_id = vehicle_model.id) as count'))
    )->orderBy('count','desc')->get();
}

//List all vehicle brand with popular vehicle brand count
function vehicle_brand(){
    return \App\VehicleBrandModel::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM vehicle WHERE vehicle.brand_id = vehicle_brand.id) as count'))
    )->orderBy('count','desc')->get();
}

//List all vehicle color with popular vehicle color count
function vehicle_color(){
    return \App\VehicleColorModel::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM vehicle WHERE vehicle.color_id = vehicle_color.id) as count'))
    )->orderBy('count','desc')->get();
}

//Add new value if has new value on select box
function add_new_select($model,$name){
    //check if have add new value
    $check_select_val=$model::where('id',$name)->count();
    //if new value
    if ($check_select_val==0&&!empty($name)){
        //add new model
        $val=new $model();
        $val->name=$name;
        $val->save();

        //change cat id to new cat
        return $val->id;
    }else{
        return $name;
    }
}

//List all role with popular user count
function role(){
    return \App\RoleModel::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM users WHERE users.role_id = role.id) as count'))
    )->orderBy('count','desc')->get();
}

//List all expense category with popular expense category count
function expense_category(){
    return \App\ExpenseCategoryModel::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM expense WHERE expense.cat_id = expense_category.id) as count'))
    )->orderBy('count','desc')->get();
}

//List all expense category with popular expense category count
function expense_product(){
    return \App\ProductModel::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM expense WHERE expense.pro_id = product.id) as count'))
    )->orderBy('count','desc')->get();
}

//List all customer with popular invoice count
function invoice_customer(){
    return \App\CustomerModel::leftjoin('vehicle','vehicle.cus_id','customer.id')
        ->select(
        array(
            DB::raw('(SELECT count(*) FROM invoice WHERE invoice.cus_id = customer.id) as count'),
            'customer.id as id',
            'customer.name as name',
            'vehicle.plate_no as plate_no'
        )
    )->orderBy('count','desc')->get();
}


//List all supplier
function getAllSupplier(){
    return \App\SupplierModel::orderBy('id','desc')->get();
}
function getAllUser(){
    return \App\User::orderBy('id','desc')->get();
}

//list all user sa with popular invoice
function invoice_multi_sa(){
    return \App\User::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM invoice INNER JOIN invoice_multi_sa as sa ON sa.invoice_id = invoice.id WHERE sa.user_id = users.id) as count'))
    )->orderBy('count','desc')
    ->get();
}

//list all user mechanic with popular invoice
function invoice_multi_machanic(){
    return \App\User::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM invoice INNER JOIN invoice_multi_mechanic as mechanic ON mechanic.invoice_id = invoice.id WHERE mechanic.user_id = users.id) as count'))
    )->orderBy('count','desc')
    ->get();
}

//list all user seller with popular invoice
function invoice_multi_seller(){
    return \App\User::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM invoice INNER JOIN invoice_multi_seller as seller ON seller.invoice_id = invoice.id WHERE seller.user_id = users.id) as count'))
    )->orderBy('count','desc')
        ->get();
}

//list all product with popular invoice
function invoice_product(){
    return \App\ProductModel::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM invoice_detail WHERE invoice_detail.pro_id = product.id) as count'))
    )->orderBy('count','desc')->get();
}

//list all user with popular invoice
function invoice_user(){
    return \App\User::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM invoice WHERE invoice.user_id = users.id) as count'))
    )->orderBy('count','desc')->get();
}

//list all seller with popular invoice
function invoice_seller(){
    return \App\User::select(
        array(
            '*',
            DB::raw('(SELECT count(*) FROM invoice_multi_seller as ims WHERE ims.user_id = users.id) as count'))
    )->orderBy('count','desc')->get();
}

//update customer type
function update_customer_type(){
    $customers=CustomerModel::select('id')->get();
    //Update all customer type
    foreach ($customers as $c){

        $twelve_month_ago=Carbon::now()->subMonth(12)->toDateString();
        $now = Carbon::now()->toDateString();

        //new type
        //count all invoice if has no invoice or only one invoice return type new
        $count_new=InvoiceModel::where('cus_id',$c->id)
            ->whereBetween( DB::raw('date(date)'), [$twelve_month_ago, $now] )
            ->count();
        if ($count_new<2){
            CustomerModel::where('id',$c->id)
                ->update(['type'=>'new']);

            //check red type
            $count_all=InvoiceModel::where('cus_id',$c->id)->count();
            //count all invoice if this year invoice is empty and this customer has one invoice before return red
            if ($count_new==0&&$count_all>0){
                CustomerModel::where('id',$c->id)
                    ->update(['type'=>'red']);
            }

        }else{
            //gold type
            $three_month_ago = Carbon::now()->subMonth(3)->toDateString(); // or ->format(..)
            //count all invoice that has this customer in the last 3 months
            $count_gold=InvoiceModel::where('cus_id',$c->id)
                ->whereBetween( DB::raw('date(date)'), [$three_month_ago, $now] )
                ->count();
            if ($count_gold>0){
                CustomerModel::where('id',$c->id)
                    ->update(['type'=>'gold']);
            }

            //silver type
            $three_month_ago_minus_day=$fromDate = Carbon::now()->subMonth(3)->subDay()->toDateString(); // or ->format(..)
            //count all invoice that has this customer in the last 12 months to the last 3 months
            $count_silver=InvoiceModel::where('cus_id',$c->id)
                ->whereBetween(DB::raw('date(date)'), [$twelve_month_ago, $three_month_ago_minus_day])
                ->count();
            if ($count_silver>0){
                CustomerModel::where('id',$c->id)
                    ->update(['type'=>'silver']);
            }
        }


    }
}

//return if has permission or not
function get_per($module,$sub_module){
    $pri=DB::table('privilege')
        ->join('role','role.id','privilege.role_id')
        ->join('sub_module','sub_module.id','privilege.sub_module_id')
        ->join('module','module.id','privilege.module_id')
//        ->select('sub_module.*','privilege.*')
        ->where('role_id',Auth::user()->role_id)
        ->where('module.name',$module)
        ->where('sub_module.name',$sub_module)
        ->count();

    return $pri;
}

//return if has permission or not with custom role
function get_per_by_role($module,$sub_module,$role){
    $pri=DB::table('privilege')
        ->join('role','role.id','privilege.role_id')
        ->join('sub_module','sub_module.id','privilege.sub_module_id')
        ->join('module','module.id','privilege.module_id')
        ->where('role_id',$role)
        ->where('module.name',$module)
        ->where('sub_module.name',$sub_module)
        ->count();

    return $pri;
}

//add all permission to global
function get_nav(){

    //Dashboard
    config(['global.view_dashboard'=>get_per('dashboard','view_dashboard')]);

    //Notification Start
    config(['global.notification'=>get_per('notification','allow_notification')]);
    //Notification End

    //Customer Start
    config(['global.view_customer'=>get_per('customer','view_customer')]);
    config(['global.add_customer'=>get_per('customer','add_customer')]);
    config(['global.update_customer'=>get_per('customer','update_customer')]);
    config(['global.delete_customer'=>get_per('customer','delete_customer')]);
    //Customer End

    //Purchase Start
    config(['global.view_purchase'=>get_per('purchase','view_purchase')]);
    config(['global.add_purchase'=>get_per('purchase','add_purchase')]);
    config(['global.update_purchase'=>get_per('purchase','update_purchase')]);
    config(['global.delete_purchase'=>get_per('purchase','delete_purchase')]);
    //Purchase End

    //Sell Start
    config(['global.view_sell'=>get_per('sell','view_sell')]);
    config(['global.add_sell'=>get_per('sell','add_sell')]);
    config(['global.update_sell'=>get_per('sell','update_sell')]);
    config(['global.delete_sell'=>get_per('sell','delete_sell')]);
    //Sell End

    //Product Start
    config(['global.view_product'=>get_per('product','view_product')]);
    config(['global.add_product'=>get_per('product','add_product')]);
    config(['global.update_product'=>get_per('product','update_product')]);
    config(['global.delete_product'=>get_per('product','delete_product')]);
    //Product End

    //Expense Start
    config(['global.view_expense'=>get_per('expense','view_expense')]);
    config(['global.add_expense'=>get_per('expense','add_expense')]);
    config(['global.update_expense'=>get_per('expense','update_expense')]);
    config(['global.delete_expense'=>get_per('expense','delete_expense')]);
    //Expense End

    //User Start
    config(['global.view_user'=>get_per('user','view_user')]);
    config(['global.add_user'=>get_per('user','add_user')]);
    config(['global.update_user'=>get_per('user','update_user')]);
    config(['global.delete_user'=>get_per('user','delete_user')]);
    //User End
}


//Notification customer follow up
function notify_follow_up(){
    //get 3 day ago and 3 month ago date
    $three_day_ago=Carbon::now()->subDay(3)->toDateString();
    $three_month_ago=Carbon::now()->subMonth(3)->toDateString();

    //get all customer with three day ago and three months ago
    $cus_three_day=CustomerModel::join('invoice','invoice.cus_id','customer.id')
        ->whereDate('invoice.date', '=', $three_day_ago)
//        ->groupBy('customer.id')
        ->select('customer.*')
        ->get();

//    $cus_three_day=CustomerModel::whereDate('created_at', '=', $three_day_ago)->get();

    $cus_three_month=CustomerModel::join('invoice','invoice.cus_id','customer.id')
        ->whereDate('invoice.date', '=', $three_month_ago)
//        ->groupBy('customer.id')
        ->select('customer.*')
        ->get();



    //get all unread notification
    $notifications=Auth::user()->unreadNotifications;
    $read_notifications=Auth::user()->readNotifications;

    $user=User::where('status',1)->get();
    foreach ($user as $u){

        //Custom get permission role
        $pri=get_per_by_role('notification','allow_notification',$u->role_id);

        //Send notification only user who has permission
        if ($pri){


            //Notification PM Reminder Start

            //All three day ago customer
//            dd($notifications->where('type','App\Notifications\NotifyPMReminder'));
            foreach ($cus_three_day as $cus){
                //check if read notifications is already added
                $n2=0;
                foreach ($read_notifications->where('type','App\Notifications\NotifyPMReminder') as $notifyRead){
//                       $u->notify(new NotifyPMReminder($cus));
                    //Get customer notification id
                    $notifyRead2=$notifyRead->data;
                    $notify_cus_id_read=$notifyRead2['cus']['id'];

                    //If customer three day ago and notify customer is the same +n
                    if ($cus->id==$notify_cus_id_read){
                        $n2++;
                        break;
                    }
                }

                if ($n2==0){
                    //All notification to check if already existed
                    //If don't have any notification pm reminder type
                    $first_service='';
                    $invoice=InvoiceModel::where('cus_id',$cus->id)->orderBy('date','ASC')->first();
                    if (!empty($invoice)){
                        $first_service=$invoice->date;
                    }
                    if ($notifications->where('type','App\Notifications\NotifyPMReminder')->isEmpty()){
                        $u->notify(new NotifyPMReminder($cus,$first_service));
                    }else{
                        //check if unread notifications is already added
                        $n=0;
                        foreach ($notifications->where('type','App\Notifications\NotifyPMReminder') as $notify){
//                       $u->notify(new NotifyPMReminder($cus));
                            //Get customer notification id
                            $notify2=$notify->data;
                            $notify_cus_id=$notify2['cus']['id'];
                            //If customer three day ago and notify customer is the same +n
                            if ($cus->id==$notify_cus_id){
                                $n++;
                                break;
                            }
                        }

                        //only add if $n=0 mean customer is not duplicate
                        if ($n==0){

                            $u->notify(new NotifyPMReminder($cus,$first_service));
                            break;

                        }
                    }
                }



            }

            //Notification PM Reminder End

            //Notification Post Service Follow Up Start
            foreach ($cus_three_month as $cus){
                //check if read notifications is already added
                $n2=0;
                foreach ($read_notifications->where('type','App\Notifications\NotifyPostServiceFollowUp') as $notifyRead){
//                       $u->notify(new NotifyPMReminder($cus));
                    //Get customer notification id
                    $notifyRead2=$notifyRead->data;
                    $notify_cus_id_read=$notifyRead2['cus']['id'];

                    //If customer three day ago and notify customer is the same +n
                    if ($cus->id==$notify_cus_id_read){
                        $n2++;
                        break;
                    }
                }

                if ($n2==0){
                    //All notification to check if already existed
                    //If don't have any notification post service type
                    $first_service='';
                    $invoice=InvoiceModel::where('cus_id',$cus->id)->orderBy('date','ASC')->first();
                    if (!empty($invoice)){
                        $first_service=$invoice->date;
                    }
                    if ($notifications->where('type','App\Notifications\NotifyPostServiceFollowUp')->isEmpty()){
                        $u->notify(new NotifyPostServiceFollowUp($cus,$first_service));
                    }else{
                        //check if unread notifications is already added
                        $n=0;
                        foreach ($notifications->where('type','App\Notifications\NotifyPostServiceFollowUp') as $notify){
//                       $u->notify(new NotifyPMReminder($cus));
                            //Get customer notification id
                            $notify2=$notify->data;
                            $notify_cus_id=$notify2['cus']['id'];
                            //If customer three day ago and notify customer is the same +n
                            if ($cus->id==$notify_cus_id){
                                $n++;
                                break;
                            }
                        }

                        //only add if $n=0 mean customer is not duplicate
                        if ($n==0){
                            $u->notify(new NotifyPostServiceFollowUp($cus,$first_service));
                            break;
                        }
                    }
                }

            }

            //Notification Post Service Follow Up End

        }
    }
}

?>


