<?php

namespace App\Http\Controllers;

use App\CustomerModel;
use App\ProductModelModel;
use App\PurchaseModel;
use App\User;

use App\ProductModel;
use App\ProductUseForModel;
use App\InvoiceModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        //Permission Start
        if (!config('global.view_dashboard')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.dashboard_icon')]);
        config(['global.text_content_title' => 'Dashboard']);

        //count all customers
        $cus=CustomerModel::count();
        config(['global.cus_count'=>$cus]);

        //count all users
        $user=User::count();
        config(['global.user_count'=>$user]);

        //count all product
        $pro=ProductModel::count();

        //count all product category
        $model=ProductModelModel::count();

        $today_sale=InvoiceModel::whereDate('date', DB::raw('CURDATE()'))->sum('total_amount');

        config(['global.today_sale_amount'=>$today_sale]);

        $total_sale=InvoiceModel::sum('total_amount');
        config(['global.total_sale_amount'=>$total_sale]);

        $invoices=InvoiceModel::orderBy('date','DESC')->limit(5)->get();
        $purchases=PurchaseModel::orderBy('date','DESC')->limit(5)->get();

        $data=array(
            'product'=>$pro,
            'model'=>$model,
            'invoices'=>$invoices,
            'purchases'=>$purchases

        );
        return view('dashboard.index',$data);
    }
}
