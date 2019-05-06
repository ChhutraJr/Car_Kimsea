<?php

namespace App\Http\Controllers;

use App\InvoiceDetailModel;
use App\Notifications\NotifyNewProduct;
use App\ProductUseForModel;
use App\ProductDetailModel;
use App\ProductModel;
use App\ProductModelModel;
use App\PurchaseDetailModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class ProductController extends Controller
{

    //    Server Side Master
    function get_data(Request $request)
    {
        if (empty($request->data1)){
            //get all master and relationship values
            $master=ProductModel::orderBy('id','DESC')
                ->leftjoin('product_model as m','m.id','product.model_id')
                ->leftjoin('product_use_for as c','c.id','product.cat_id')
                ->select('product.*','m.name as m_name','c.name as c_name');
        }else{
            //get all master and relationship values
            $master=ProductModel::orderBy('id','DESC')
                ->leftjoin('product_model as m','m.id','product.model_id')
                ->leftjoin('product_use_for as c','c.id','product.cat_id')
                ->select('product.*','m.name as m_name','c.name as c_name')
                ->where('product.id',$request->data1);
        }


        //return $products;
        return DataTables::of($master)
            //Edit created date format
            ->editColumn('created_at', function($master) {

                //get lastest product detail
                //check if have sub products or not
                if ($master->detail()->count()!=0){
                    //get latest sub product
                    $last_detail=$master->detail()->orderBy('id','DESC')->first();
                    //format date using carbon
                    return Carbon::parse($last_detail->created_at)->format('d M, Y');
                }

                //if have no sub products
                return Carbon::parse($master->created_at)->format('d M, Y');

            })
            ->editColumn('type', function($master) {

                //check if has type or not
                if(!empty($master->type)){
                    //convert to capitalize first letter
                    return ucfirst(trans($master->type));
                }

                return '';

            })
            ->make(true);
    }

    //    Server Side Detail
    function get_data_detail(Request $request)
    {
        //get all detail values by product id
        $detail=ProductDetailModel::orderBy('id','ASC')->where('pro_id',$request->data1)
            ->select('product_detail.*');

        //return $products;
        return DataTables::of($detail)
            //Edit created date format
            ->editColumn('created_at', function($detail) {

                //if have no sub products
                return Carbon::parse($detail->created_at)->format('d M, Y');

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
            ->editColumn('total_cost', function($detail) {

                //check if has total cost or not
                if (!empty($detail->total_cost)){
                    return  '$'.number_format($detail->total_cost, 2);
                }else{
                    return '$0.00';
                }

            })
            /*            //Edit total cost format
                        ->editColumn('total_cost', function($detail) {

                            //check if has total cost or not
                            if (!empty($detail->total_cost)){
                                return  '$'.number_format($detail->total_cost, 2);
                            }else{
                                return '$0.00';
                            }

                        })*/
            //Edit profit format
            ->editColumn('profit', function($detail) {

                //check if has total cost or not
                if (!empty($detail->profit)){
                    return  '$'.number_format($detail->profit, 2);
                }else{
                    return '$0.00';
                }

            })
            ->make(true);
    }
    //    Server Side Master Filter Date
    function get_data_filter_date(Request $request)
    {
        //get start and end date
        $start=$request->data1;
        $end=$request->data2;

        //get all master and relationship values
        $master=ProductModel::orderBy('id','DESC')
            ->leftjoin('product_model as m','m.id','product.model_id')
            ->leftjoin('product_use_for as c','c.id','product.cat_id')
            ->select('product.*','m.name as m_name','c.name as c_name')
            ->whereBetween( DB::raw('date(product.created_at)'), [$start, $end] );

        //return $products;
        return DataTables::of($master)
            //Edit created date format
            ->editColumn('created_at', function($master) {

                //get lastest product detail
                //check if have sub products or not
                if ($master->detail()->count()!=0){
                    //get latest sub product
                    $last_detail=$master->detail()->orderBy('id','DESC')->first();
                    //format date using carbon
                    return Carbon::parse($last_detail->created_at)->format('d M, Y');
                }

                //if have no sub products
                return Carbon::parse($master->created_at)->format('d M, Y');

            })
            ->editColumn('type', function($master) {

                //check if has type or not
                if(!empty($master->type)){
                    //convert to capitalize first letter
                    return ucfirst(trans($master->type));
                }

                return '';

            })
            ->make(true);
    }

    public function index($value1=null,$value2=null){
        //Permission Start
        if (!config('global.view_product')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.pro_icon')]);
        config(['global.text_content_title' => 'Products']);

        //set index link
        config(['global.index_link' => 'product.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Products Found']);
        config(['global.no_data_text' => 'You have not added any product add first product now']);
        config(['global.no_data_btn' => 'Add New Product']);

        //set link add new
        config(['global.add_new_link' => '/product/create']);
        //set link update
        config(['global.update_link' => '/product/update']);

        //set delete
        config(['global.alert_delete_title' => 'This product and all sub products will be deleted.']);
        config(['global.delete_link' => 'master_delete.product']);
        config(['global.after_delete_text' => 'Product and all sub products have been deleted.']);
        config(['global.cant_delete_text' => 'The purchases related to this product exist.']);

        //set value to id if click from notification
        if ($value1=='id'){
            config(['global.pro_id' => $value2]);
        }

        $master=ProductModel::all();

        /*$cat=DB::table('product_category')
            ->leftjoin('product', 'product.cat_id', 'product_category.id')
            ->select(DB::raw('count(product.cat_id) as repetition'),'product_category.name')
            ->orderBy('repetition', 'desc')
            ->get();*/

        //for filter date
        if (!$master->isEmpty()){
            //get first master date
            $first_master=ProductModel::orderBy('created_at','ASC')->first();
            config(['global.start_date'=>$first_master->created_at]);
        }


        $cat=product_use_for();
        $data=array(
            'master'=>$master,
            'category'=>$cat
        );

        return view('product.index',$data);

    }

    public function create($pro_name=null){

        config(['global.pro_name'=>$pro_name]);

        //Permission Start
        if (!config('global.add_product')){
            return view('errors.not_found');
        }
        //Permission End

        //set product content global icon and name
        config(['global.icon_content_title' => config('global.pro_icon')]);
        config(['global.text_content_title' => 'Add Product']);
        config(['global.parent_text_content_title' => 'Products']);

        //set submit route
        config(['global.submit_link' => 'store.product']);
        //set index route
        config(['global.index_link' => '/products']);


        $use_for=product_use_for();
        $model=product_model();
        $pros=ProductModel::select('name')
            ->groupBy('name')
            ->get();

        $data=array(
            'use_for'=>$use_for,
            'model'=>$model,
            'pros'=>$pros
        );
        return view('product.create',$data);
    }
    public function store(Request $request){


        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:100',
            'code_part' => 'required|max:100|unique:product,code_part'
        ]);

        if ($validator->passes()){

//            return $request->all();

            //set default cat id
            $cat_id=$request->category;
            //set default model id
            $model_id=$request->model;

            //check if cat have add new value
            $check_cat=ProductUseForModel::where('id',$request->category)->count();
            //if new value
            if ($check_cat==0&&!empty($request->category)){

                //check if duplicate name
                $check_cat_name=ProductUseForModel::where('name',$request->category)->count();

                //if no duplicate cat name
                if ($check_cat_name==0){
                    //add new cat
                    $cat=new ProductUseForModel();
                    $cat->name=$request->category;
                    $cat->save();

                    //change cat id to new cat
                    $cat_id=$cat->id;
                }else{
                    //if category name is the same only get id
                    $cat_id=ProductUseForModel::where('name',$request->category)->first()->cat_id;
                }

            }

            //check if model have add new value
            $check_model=ProductModelModel::where('id',$request->model)->count();
            //if new value
            if ($check_model==0&&!empty($request->model)){

                //check if duplicate name
                $check_model_name=ProductModelModel::where('name',$request->model)->count();

                //if no duplicate cat name
                if ($check_model_name==0){
                    //add new model
                    $model=new ProductModelModel();
                    $model->name=$request->model;
                    $model->save();

                    //change cat id to new cat
                    $model_id=$model->id;
                }else{
                    //if model name is the same only get id
                    $model_id=ProductModelModel::where('name',$request->model)->first()->model_id;
                }

            }

            $master = new ProductModel();
            $master->name=$request->product_name;
            $master->code_part=$request->code_part;
            $master->type=$request->type;
            $master->cat_id=$cat_id;
            $master->model_id=$model_id;
            $master->user_id=Auth::user()->first()->id;
            $master->save();

            //return message
  /*          Session::flash('message', $request->product_name.' have been added !');
            Session::flash('title', 'Product');
            Session::flash('alert-type', 'success');*/

            return response()->json(['verify'=>'true',
                'pro_id'=>$master->id
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

   // Products_validate_name

    public function code_part_validate(Request $request){

            $validator = Validator::make($request->all(), [
                'code_part' => 'required|max:100|unique:product,code_part'
            ]);
            return ['errors' => $validator->errors()];
    }


    public function store_detail(Request $request){

        if ($request->qty>0){
            //add product detail
            $detail=new ProductDetailModel();
            $detail->qty=$request->qty;
            $detail->cost_price=$request->cost_price;
            $detail->sell_price=$request->sell_price;
            $detail->total_cost=$request->total_cost;
            $detail->profit=$request->profit;
            $detail->pro_id=$request->pro_id;
            $detail->save();

            //get master
            $pro=ProductModel::find($request->pro_id);
            //update master
            ProductModel::where('id',$request->pro_id)
                ->update([
                    'total_qty'=>$pro->total_qty+=$request->qty,
                    'current_qty'=>$pro->current_qty+=$request->qty,
                    'grand_total_cost'=>$pro->grand_total_cost+=$request->total_cost
                ]);

            if ($request->last=='true'){
                //Permission Start
                /*$pro=ProductModel::find($request->pro_id);
                $user=User::where('status',1)->get();
                foreach ($user as $u){

                    //Custom get permission role
                    $pri=get_per_by_role('notification','allow_notification',$u->role_id);

                    //Send notification only user who has permission
                    if ($pri){
                        $u->notify(new NotifyNewProduct($pro, Auth::user()));
                    }
                }*/
                //Permission End
            }

        }else{

            //Permission Start
            /*$pro2=ProductModel::find($request->pro_id);
            $user2=User::where('status',1)->get();
            foreach ($user2 as $u2){

                //Custom get permission role
                $pri2=get_per_by_role('notification','allow_notification',$u2->role_id);

                //Send notification only user who has permission
                if ($pri2){
                    $u2->notify(new NotifyNewProduct($pro2, Auth::user()));
                }
            }*/
            //Permission End

        }

        $pro=ProductModel::find($request->pro_id);
        return response()->json(['pro_name'=>$pro->name,'last'=>$request->last]);

    }
//    Show update view master
    public function update($id){
        //Permission Start
        if (!config('global.update_product')){
            return view('errors.not_found');
        }
        //Permission End

        //set product content global icon and name
        config(['global.icon_content_title' => config('global.pro_icon')]);
        config(['global.text_content_title' => 'Edit Product']);
        config(['global.parent_text_content_title' => 'Products']);

        //set submit route
        config(['global.submit_link' => 'save_update.product']);
        //set submit detail route
        config(['global.submit_detail_link' => 'save_update_detail.product']);
        //set index route
        config(['global.index_link' => '/products']);

        $use_for=product_use_for();
        $model=product_model();

        $master=ProductModel::where('id',$id)->first();
        $pros=ProductModel::select('name')
            ->groupBy('name')
            ->get();

        $data=array(
            'use_for'=>$use_for,
            'model'=>$model,
            'master'=>$master,
            'pros'=>$pros
        );


        return view('product.update',$data);
    }
//    get detail data to view
    public function update_detail($id){

        $data=array(
            'detail'=>ProductDetailModel::orderBy('id','ASC')->where('pro_id',$id)->get(),
            'grand_total'=>ProductModel::where('id',$id)->first()->grand_total_cost
        );

        return $data;
    }
    public function save_update(Request $request){

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:100',
            'code_part' => 'required|max:100'
        ]);

        if ($validator->passes()){

            //set default cat id
            $cat_id=$request->category;
            //set default model id
            $model_id=$request->model;

            //check if cat have add new value
            $check_cat=ProductUseForModel::where('id',$request->category)->count();
            //if new value
            if ($check_cat==0&&!empty($request->category)){

                //check if duplicate name
                $check_cat_name=ProductUseForModel::where('name',$request->category)->count();

                //if no duplicate cat name
                if ($check_cat_name==0){
                    //add new cat
                    $cat=new ProductUseForModel();
                    $cat->name=$request->category;
                    $cat->save();

                    //change cat id to new cat
                    $cat_id=$cat->id;
                }else{
                    //if category name is the same only get id
                    $cat_id=ProductUseForModel::where('name',$request->category)->first()->cat_id;
                }

            }

            //check if model have add new value
            $check_model=ProductModelModel::where('id',$request->model)->count();
            //if new value
            if ($check_model==0&&!empty($request->model)){

                //check if duplicate name
                $check_model_name=ProductModelModel::where('name',$request->model)->count();

                //if no duplicate cat name
                if ($check_model_name==0){
                    //add new model
                    $model=new ProductModelModel();
                    $model->name=$request->model;
                    $model->save();

                    //change cat id to new cat
                    $model_id=$model->id;
                }else{
                    //if model name is the same only get id
                    $model_id=ProductModelModel::where('name',$request->model)->first()->model_id;
                }

            }

//          Update master
            ProductModel::where('id',$request->update_id)
                ->update([
                    'name'=>$request->product_name,
                    'code_part'=>$request->code_part,
                    'type'=>$request->type,
                    'cat_id'=>$cat_id,
                    'model_id'=>$model_id,
                    'total_qty'=>0,
                    'grand_total_cost'=>0
                ]);


            //if remove product
            if ($request->delete=='true'){
                //Clear all detail
                ProductDetailModel::where('pro_id',$request->update_id)->delete();

                ProductModel::where('id',$request->update_id)
                    ->update([
                        'current_qty'=>0
                    ]);
            }


            /*Session::flash('message', $request->product_name.' have been added !');
            Session::flash('title', 'Product');
            Session::flash('alert-type', 'success');*/

            return response()->json(['verify'=>'true',
                'pro_id'=>$request->update_id
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
    public function save_update_detail(Request $request){

        if ($request->qty>0){
            //get master
            $master=ProductModel::find($request->pro_id);
            $purchase_detail_qty=PurchaseDetailModel::where('pro_id',$request->pro_id)->sum('qty');

            //if remove product
            if ($request->delete=='true'){
                //add product detail
                $detail=new ProductDetailModel();
                $detail->qty=$request->qty;
                $detail->cost_price=$request->cost_price;
                $detail->sell_price=$request->sell_price;
                $detail->profit=$request->profit;
                $detail->total_cost=$request->total_cost;
                $detail->pro_id=$request->pro_id;
                $detail->save();


                //update master
                ProductModel::where('id',$request->pro_id)
                    ->update([
                        'total_qty'=>($master->total_qty+$purchase_detail_qty)+$request->qty,
                        'current_qty'=>$master->current_qty+=$request->qty,
                        'grand_total_cost'=>$master->grand_total_cost+=$request->total_cost
                    ]);
            }else{
                //update product detail without remove all detail
                /*
                            //master
                            $master=ProductModel::where('id',$request->pro_id)->first();*/

                //check if new detail (add new when have no detail and update when detail already have)
                $ch_old=ProductDetailModel::where('id',$request->id)->count();
                if($ch_old==0){
                    //add new detail
                    $detail=new ProductDetailModel();
                    $detail->qty=$request->qty;
                    $detail->cost_price=$request->cost_price;
                    $detail->sell_price=$request->sell_price;
                    $detail->profit=$request->profit;
                    $detail->total_cost=$request->total_cost;
                    $detail->pro_id=$request->pro_id;
                    $detail->save();


                    //update master
                    ProductModel::where('id',$request->pro_id)
                        ->update([
                            'total_qty'=>($master->total_qty+$purchase_detail_qty)+$request->qty,
                            'current_qty'=>$master->current_qty+=$request->qty,
                            'grand_total_cost'=>$master->grand_total_cost+=$request->total_cost
                        ]);

                }else{
                    //if detail already exist
                    //update old detail

                    //new qty
                    $qty=$request->qty;
                    //old qty
                    $old_qty=ProductDetailModel::where('id',$request->id)->first()->qty;

                    //check if qty have been changed
                    if ($old_qty<$qty||$old_qty>$qty){
                        //if new qty bigger than old qty (we need to plus qty)
                        if ($old_qty<$qty){
                            //get qty plus
                            $p=$qty-$old_qty;

                            //plus old qty total and current qty total on master
                            ProductModel::where('id',$request->pro_id)
                                ->update([
                                    'current_qty'=>$master->current_qty+$p
                                ]);
                        }else{
                            //get qty minus
                            $m=$old_qty-$qty;

                            //minus old qty total and current qty total on master
                            ProductModel::where('id',$request->pro_id)
                                ->update([
                                    'current_qty'=>$master->current_qty-$m
                                ]);

                        }
                    }

                    //update master
                    ProductModel::where('id',$request->pro_id)
                        ->update([
                            'total_qty'=>($master->total_qty+$purchase_detail_qty)+$request->qty,
                            'grand_total_cost'=>$master->grand_total_cost+=$request->total_cost
                        ]);

                    //update product detail
                    ProductDetailModel::where('id',$request->id)
                        ->update([
                            'qty'=>$request->qty,
                            'cost_price'=>$request->cost_price,
                            'sell_price'=>$request->sell_price,
                            'profit'=>$request->profit,
                            'total_cost'=>$request->total_cost,
                        ]);
                }

            }

        }

        return response()->json(['last'=>$request->last]);

    }
    public function delete(Request $request){

        //Check if related invoice
        $invoice_detail=InvoiceDetailModel::where('pro_id',$request->id)->count();
        //Check if related purchase
        $purchase_detail=PurchaseDetailModel::where('pro_id',$request->id)->count();


        if ($invoice_detail>0){
            //if have related invoice
            return response()->json(['delete'=>'false_invoice']);
        }elseif ($purchase_detail>0){
            //if have related purchase
            return response()->json(['delete'=>'false_purchase']);
        }


        //delete if no related invoice

        //delete master
        ProductModel::where('id',$request->id)->delete();

        //delete all sub master
        ProductDetailModel::where('pro_id',$request->id)->delete();

    }



    // Get grand total
    public function grand_total($id){
        $pro=ProductModel::find($id);
        return $pro->grand_total_cost;
    }
    // Get Product by ID
    function get_product($id){

        $product_detail=ProductDetailModel::where('pro_id',$id)
            ->orderBy('created_at','DESC')->first();
        $purchase_detail=PurchaseDetailModel::where('pro_id',$id)
            ->orderBy('created_at','DESC')->first();

        $cost_price=0;
        $sell_price=0;
        if (!empty($product_detail)||!empty($purchase_detail)){
            //if product detail is empty
            if (empty($product_detail)){
                $cost_price=$purchase_detail->cost_price;
                $sell_price=$purchase_detail->sell_price;
            }elseif (empty($purchase_detail)){
                //if product purchase is empty
                $cost_price=$product_detail->cost_price;
                $sell_price=$product_detail->sell_price;
            }else{
                //if product detail and product purchase is not empty
                if ($product_detail->created_at>$purchase_detail->created_at){
                    $cost_price=$product_detail->cost_price;
                    $sell_price=$product_detail->sell_price;
                }else{
                    $cost_price=$purchase_detail->cost_price;
                    $sell_price=$purchase_detail->sell_price;
                }
            }

        }

        return ['cost_price'=>$cost_price,
            'sell_price'=>$sell_price
        ];

    }
}
