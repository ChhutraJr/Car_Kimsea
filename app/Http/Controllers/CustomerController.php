<?php

namespace App\Http\Controllers;

use App\CustomerModel;
use App\CustomerMultiFollowUpModel;
use App\CustomerMultiTelModel;
use App\InvoiceDetailModel;
use App\InvoiceModel;
use App\ProductUseForModel;
use App\ProductModel;
use App\RepairOrderModel;
use App\VehicleColorModel;
use App\VehicleModel;
use App\VehicleModelModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    //    Server Side Master
    function get_data(Request $request)
    {

        if (empty($request->data1)){
            //get all master and relationship values
            $master=CustomerModel::orderBy('id','DESC')
                ->leftjoin('vehicle as v','v.cus_id','customer.id')
                ->leftjoin('vehicle_model as vm','vm.id','v.model_id')
                ->leftjoin('vehicle_color as vc','vc.id','v.color_id')
                ->select('customer.*','v.plate_no','v.year','vm.name as vm_name','vc.name as vc_name');


        }else{
            //get all master and relationship values by cus id
            $master=CustomerModel::orderBy('id','DESC')
                ->leftjoin('vehicle as v','v.cus_id','customer.id')
                ->leftjoin('vehicle_model as vm','vm.id','v.model_id')
                ->leftjoin('vehicle_color as vc','vc.id','v.color_id')
                ->select('customer.*','v.plate_no','v.year','vm.name as vm_name','vc.name as vc_name')
                ->where('customer.id_number',$request->data1);
        }


        //return $products;
        return DataTables::of($master)
            ->addColumn('tel', function($master) {

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

            })
            ->editColumn('type', function($master) {


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
            ->editColumn('created_at', function($master) {

                return Carbon::parse($master->created_at)->format('d M, Y');

            })
            ->addColumn('first_service', function ($master){

                if (!empty($master->invoice()->first())){
                    $first_service=$master->invoice()->first()->date;
                    return Carbon::parse($first_service)->format('d M, Y');
                }

                return '';
            })

            ->addColumn('last_service', function ($master){
                if (!empty($master->invoice()->first())){
                    $last_service=$master->invoice()->orderBy('id','DESC')->first()->date;
                    return Carbon::parse($last_service)->format('d M, Y');
                }

                return '';
            })
            ->addColumn('total_amount', function ($master){

                $total_amount=0;
                if (!empty($master->invoice)){
                    foreach ($master->invoice as $inv){
                        $total_amount+=$inv->total_amount;
                    }
                    return  '$'.number_format($total_amount, 2);
                }else{
                    return '$0.00';
                }

            })
            ->addColumn('follow_up', function ($master){

                $follow_up=CustomerMultiFollowUpModel::where('cus_id',$master->id)->orderBy('follow_up_date','DESC')->first();
                if (!empty($follow_up)){
                    return Carbon::parse($follow_up->follow_up_date)->format('d M, Y');
                }else{
                    return 'N/A';
                }

            })
            ->make(true);
    }
    //Server Side Master Filter Date
    function get_data_filter(Request $request)
    {
        //get start and end date
        $start=$request->data1;
        $end=$request->data2;
        $type=$request->data3;


        //if the select box is all type
        if (empty($type)){
            //get all master and relationship values
            $master=CustomerModel::orderBy('id','DESC')
                ->leftjoin('vehicle as v','v.cus_id','customer.id')
                ->leftjoin('vehicle_model as vm','vm.id','v.model_id')
                ->leftjoin('vehicle_color as vc','vc.id','v.color_id')
                ->select('customer.*','v.plate_no','v.year','vm.name as vm_name','vc.name as vc_name')
                ->whereBetween( DB::raw('date(customer.created_at)'), [$start, $end] );
        }else{
            //filter by type and date

            //get all master and relationship values
            $master=CustomerModel::orderBy('id','DESC')
                ->leftjoin('vehicle as v','v.cus_id','customer.id')
                ->leftjoin('vehicle_model as vm','vm.id','v.model_id')
                ->leftjoin('vehicle_color as vc','vc.id','v.color_id')
                ->select('customer.*','v.plate_no','v.year','vm.name as vm_name','vc.name as vc_name')
                ->whereBetween( DB::raw('date(customer.created_at)'), [$start, $end] )
                ->where('customer.type',$type);
        }

        return DataTables::of($master)
            ->addColumn('tel', function($master) {

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

            })
            ->editColumn('type', function($master) {

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
            ->editColumn('created_at', function($master) {

                return Carbon::parse($master->created_at)->format('d M, Y');

            })
            ->addColumn('first_service', function ($master){

                if (!empty($master->invoice()->first())){
                    $first_service=$master->invoice()->first()->date;
                    return Carbon::parse($first_service)->format('d M, Y');
                }

                return '';
            })

            ->addColumn('last_service', function ($master){
                if (!empty($master->invoice()->first())){
                    $last_service=$master->invoice()->orderBy('id','DESC')->first()->date;
                    return Carbon::parse($last_service)->format('d M, Y');
                }

                return '';
            })
            ->addColumn('total_amount', function ($master){

                $total_amount=0;
                if (!empty($master->invoice)){
                    foreach ($master->invoice as $inv){
                        $total_amount+=$inv->total_amount;
                    }
                    return  '$'.number_format($total_amount, 2);
                }else{
                    return '$0.00';
                }

            })
            ->addColumn('follow_up', function ($master){

                $follow_up=CustomerMultiFollowUpModel::where('cus_id',$master->id)->orderBy('follow_up_date','DESC')->first();
                if (!empty($follow_up)){
                    return Carbon::parse($follow_up->follow_up_date)->format('d M, Y');
                }else{
                    return 'N/A';
                }

            })
            ->make(true);
    }

    //Server Side Detail
    function get_data_detail(Request $request){
        //get all detail values by customer id
        $detail=InvoiceDetailModel::join('invoice as inv','inv.id','invoice_detail.invoice_id')
            ->select('invoice_detail.*',
                'inv.ro as ro',
                'inv.km as km'
            )
            ->where('inv.cus_id',$request->data1)

            ->orderBy('date','DESC')
            ->orderBy('id','DESC');

        //return $products;
        return DataTables::of($detail)
            //Edit created date format
            ->addColumn('date', function($detail) {
                if (!empty($detail->invoice()->first()->date)) {
                    return Carbon::parse($detail->invoice()->first()->date)->format('d M, Y');
                }else{
                    return '';
                }
            })
            ->addColumn('des', function ($detail){
                if (!empty($detail->type)){
                    //check description is product or other
                    if ($detail->type=='other'){
                        $des=$detail->des;
                    }else{
                        $des=$detail->pro()->first()->name;
                    }

                    return $des;
                }else{
                    return '';
                }

            })
            //Edit price format
            ->addColumn('price', function($detail) {

                //check if has price or not
                if (!empty($detail->price)){
                    return  '$'.number_format($detail->price, 2);
                }else{
                    return '$0.00';
                }

            })
            //Edit total format
            ->addColumn('total', function($detail) {

                //check if has total cost or not
                if (!empty($detail->total)){
                    return  '$'.number_format($detail->total, 2);
                }else{
                    return '$0.00';
                }

            })
            ->addColumn('invoice_no', function ($detail){
                if (!empty($detail->invoice()->first()->invoice_no)){
                    return str_pad($detail->invoice()->first()->invoice_no, 6, '0', STR_PAD_LEFT);
                }else{
                    return '';
                }
            })
            ->addColumn('mechanic', function ($detail){
                $multi_mechanic='';
                $count=0;
                if (!empty($detail->invoice()->first()->multi_mechanic)){
                    foreach ($detail->invoice()->first()->multi_mechanic as $mechanic){
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
            ->addColumn('sa', function ($detail){
                $multi_sa='';
                $count=0;
                if (!empty($detail->invoice()->first()->multi_sa)){
                    foreach ($detail->invoice()->first()->multi_sa as $sa){
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
            ->make(true);
    }

    public function index($value1=null,$value2=null,$value3=null)
    {


        if ($value1 == 'print-ro') {
            $id = $value2;
            $master = CustomerModel::where('customer.id', $id)
                ->leftjoin('vehicle as v', 'v.cus_id', 'customer.id')
                ->leftjoin('vehicle_model as vm', 'vm.id', 'v.model_id')
                ->leftjoin('vehicle_color as vc', 'vc.id', 'v.color_id')
                ->select('customer.*', 'v.plate_no', 'v.year',
                    'vm.name as vm_name', 'vc.name as vc_name'
                )
                ->first();

            $ro_no=0;
            $ro=RepairOrderModel::orderBy('ro_no','DESC')->first();
            if (!empty($ro)){
                $ro_no=$ro->ro_no+1;
            }else{
               $ro_no=1;
            }

            return view('customer.print')->with('master',$master)->with('ro_no',$ro_no);

        }else{
            if (!config('global.view_customer')) {
                return view('errors.not_found');
            }

            //set content global icon and name
            config(['global.icon_content_title' => config('global.cus_icon')]);
            config(['global.text_content_title' => 'Customers']);

            //set index link
            config(['global.index_link' => 'customer.get_data']);

            //set no data content
            config(['global.no_data_title' => 'No Customers Found']);
            config(['global.no_data_text' => 'You have not added any customer add first customer now']);
            config(['global.no_data_btn' => 'Add New Customer']);

            //set link add new
            config(['global.add_new_link' => '/customer/create']);
            //set link update
            config(['global.update_link' => '/customer/update']);

            //set delete
            config(['global.alert_delete_title' => 'This customer and all sub customers will be deleted.']);
            config(['global.delete_link' => 'master_delete.customer']);
            config(['global.after_delete_text' => 'Customer and all sub customers have been deleted.']);
            config(['global.cant_delete_text' => 'The invoices related to this customer exist.']);

            //set value to id if click from notification
            if ($value1=='id'){
                config(['global.cus_id' => $value2]);
            }

            $master = CustomerModel::orderBy('id', 'DESC')->get();

            //for filter date
            if (!$master->isEmpty()) {
                //update customer type
                update_customer_type();
                //get first master date
                $first_master = CustomerModel::orderBy('created_at', 'ASC')->first();
                config(['global.start_date' => $first_master->created_at]);
            }

            $data = array(
                'master' => $master
            );

            return view('customer.index', $data);

        }
    }

    public function create(){
        //Permission Start
        if (!config('global.add_customer')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.cus_icon')]);
        config(['global.text_content_title' => 'Add Customer']);
        config(['global.parent_text_content_title' => 'Customers']);

        //set submit route
        config(['global.submit_link' => 'store.customer']);
        //set index route
        config(['global.index_link' => '/customers']);


        $model=vehicle_model();
        $brand=vehicle_brand();
        $color=vehicle_color();

        $data=array(
            'model'=>$model,
            'brand'=>$brand,
            'color'=>$color
        );
        return view('customer.create',$data);
    }

    public function store(Request $request){

        if(!empty($request->plate_no)){
            $validator = Validator::make($request->all(), [
                'customer_name' => 'required|max:100',
                'contact_number' => 'max:100',
                'email' => 'max:100',
                'plate_no' => 'unique:vehicle,plate_no|max:50',
                'year' => 'max:10',
                'contact_address' => 'max:500'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'customer_name' => 'required|max:100',
                'contact_number' => 'max:100',
                'email' => 'max:100',
                'year' => 'max:10',
                'contact_address' => 'max:500'
            ]);
        }

//        return $request->all();
        if ($validator->passes()){

            //check if name, phone and plate no is empty
            if (empty($request->customer_name)&&empty($request->contact_number)&&empty($request->plate_no)){
                return response()->json(['verify'=>'false',
                ]);
            }

            //add new if has new model
            $model_id=add_new_select('App\VehicleModelModel',$request->model);

            //check if color have add new value
            $color_id=add_new_select('App\VehicleColorModel',$request->color);

            //get last master
            $count_master=CustomerModel::count();
            //if no customer default id to 1
            $id_number=1;
            if ($count_master!=0){
                //when customer more than one plus id number +1
                $cus=CustomerModel::orderBy('id','DESC')->first();
                $id_number=$cus->id_number+1;
            }

            //add master
            $master=new CustomerModel();
            $master->id_number=$id_number;
            $master->name=$request->customer_name;
            $master->address=$request->contact_address;
            $master->email=$request->email;
            $master->type='new';
            $master->save();

            //add vehicle
            $vehicle=new VehicleModel();
            $vehicle->plate_no=$request->plate_no;
            $vehicle->year=$request->year;
            $vehicle->model_id=$model_id;
            $vehicle->color_id=$color_id;
            $vehicle->cus_id=$master->id;
            $vehicle->save();

            //add tel
            $con = $request->contact_number;
            foreach (explode(",", $con) as $c)
            {
                if (!empty($c)){
                    $tel= new CustomerMultiTelModel();
                    $tel->name = $c;
                    $tel->cus_id = $master->id;
                    $tel->save();
                }
            }
            //return message
            Session::flash('message', 'Customer have been added !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true',
                'cus_id'=>$master->id
                //  'pro_id'=>$master->id
            ]);
        }

        return ['errors' => $validator->errors(),'data'=>$request->all()];


    }

    //    get data follow up to view
    public function update_follow_up($id){

        $data=array(
            'follow_up'=>CustomerMultiFollowUpModel::orderBy('follow_up_date','ASC')
                ->orderBy('id','ASC')
                ->where('cus_id',$id)->get(),
        );

        return $data;
    }

    public function delete(Request $request){

        //Check if have related sale start
        $invoice=InvoiceModel::where('cus_id',$request->id)->count();
        if ($invoice>0){
            return response()->json(['delete'=>'false']);
        }
        //Check if have related sale end

        //delete master
        CustomerModel::where('id',$request->id)->delete();

        //delete all sub master
        CustomerMultiTelModel::where('cus_id',$request->id)->delete();
        VehicleModel::where('cus_id',$request->id)->delete();

    }

    // Add customer follow up
    public function store_follow_up(Request $request){


        //if follow up date is empty
        if ($request->follow_up_date=='NaN-NaN-NaN'){
            $request->follow_up_date=null;
        }

        //if call date is empty
        if ($request->call_date=='NaN-NaN-NaN'){
            $request->call_date=null;
        }

        //return $request->call_date;

        //only add to database if one have value
        if (!empty($request->follow_up_date)||!empty($request->call_date)||!empty($request->feedback)){
            $fu=new CustomerMultiFollowUpModel();
            $fu->follow_up_date=$request->follow_up_date;
            $fu->call_date=$request->call_date;
            $fu->feedback=$request->feedback;
            $fu->cus_id=$request->cus_id;
            $fu->save();
        }


        return response()->json(['verify'=>'true']);

    }

    // Delete customer follow up
    public function delete_follow_up(Request $request){
        CustomerMultiFollowUpModel::where('cus_id',$request->cus_id)->delete();
    }

    //    Server Side Follow Up
    function get_data_follow_up(Request $request)
    {
        //get all master and relationship values
        $fu=CustomerMultiFollowUpModel::where('cus_id',$request->data1)
            ->orderBy('follow_up_date','ASC')
            ->orderBy('id','ASC');

        return DataTables::of($fu)
            //Edit date format
            ->editColumn('follow_up_date', function($fu) {

                return Carbon::parse($fu->follow_up_date)->format('d M, Y');

            })
            //Edit date format
            ->editColumn('call_date', function($fu) {

                return Carbon::parse($fu->call_date)->format('d M, Y');

            })
            ->make(true);
    }

    //    Show update view master
    public function update($id){
        //Permission Start
        if (!config('global.update_customer')){
            return view('errors.not_found');
        }
        //Permission End

        //set product content global icon and name
        config(['global.icon_content_title' => config('global.cus_icon')]);
        config(['global.text_content_title' => 'Edit Customer']);
        config(['global.parent_text_content_title' => 'Customers']);

        //set submit route
        config(['global.submit_link' => 'save_update.customer']);
        //set index route
        config(['global.index_link' => '/customers']);

        $model=vehicle_model();
        $brand=vehicle_brand();
        $color=vehicle_color();

        $master=CustomerModel::where('id',$id)->first();
        $vehicle=VehicleModel::where('cus_id',$id)->first();


        $data=array(
            'model'=>$model,
            'brand'=>$brand,
            'color'=>$color,
            'master'=>$master,
            'vehicle'=>$vehicle,
        );

        return view('customer.update',$data);
    }

    // Save update
    public function save_update(Request $request){

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|max:100',
            'contact_number' => 'max:100',
            'email' => 'max:100',
            'plate_no' => 'max:50',
            'year' => 'max:10',
            'contact_address' => 'max:500'
        ]);

//        return $request->all();
        if ($validator->passes()){

            //check if name, phone and plate no is empty
            if (empty($request->customer_name)&&empty($request->contact_number)&&empty($request->plate_no)){
                return response()->json(['verify'=>'false',
                ]);
            }

            //add new if has new model
            $model_id=add_new_select('App\VehicleModelModel',$request->model);

            //check if color have add new value
            $color_id=add_new_select('App\VehicleColorModel',$request->color);

            //update master
            CustomerModel::where('id',$request->update_id)
                ->update(['name'=>$request->customer_name,
                    'address'=>$request->contact_address,
                    'email'=>$request->email,
                ]);


            $vehicle=VehicleModel::where('cus_id',$request->update_id)->count();

            if (!empty($request->plate_no)||!empty($request->year)||!empty($model_id)||!empty($color_id)){

                //check if vehicle if already exist if it not create one
                if ($vehicle==0){
                    $ve=new VehicleModel();
                    $ve->plate_no=$request->plate_no;
                    $ve->year=$request->year;
                    $ve->model_id=$model_id;
                    $ve->color_id=$color_id;
                    $ve->cus_id=$request->update_id;
                    $ve->save();
                }else{
                    //otherwise just update
                    //update vehicle
                    VehicleModel::where('cus_id',$request->update_id)
                        ->update(['plate_no'=>$request->plate_no,
                            'year'=>$request->year,
                            'model_id'=>$model_id,
                            'color_id'=>$color_id,
                        ]);

                }
            }


            //remove old tel before add new tel
            CustomerMultiTelModel::where('cus_id',$request->update_id)->delete();

            //add tel
            $con = $request->contact_number;
            foreach (explode(",", $con) as $c)
            {
                if (!empty($c)){
                    $tel= new CustomerMultiTelModel();
                    $tel->name = $c;
                    $tel->cus_id = $request->update_id;
                    $tel->save();
                }
            }

            //return message
            Session::flash('message', 'Customer have been updated !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true',
                //  'pro_id'=>$master->id
            ]);
        }

        return ['errors' => $validator->errors(),'data'=>$request->all()];

    }


    function exportCustomerDetail($id){
        $data = array();
        $detail=InvoiceDetailModel::join('invoice as inv','inv.id','invoice_detail.invoice_id')
            ->where('inv.cus_id',$id)->orderBy('inv.date','asc')
            ->get()->toArray();
        
        if(count($detail)>0){


//        $data['customer_data']=CustomerModel::find($detail[0]['cus_id']);

            $data['customer_data']=CustomerModel::where('customer.id',$detail[0]['cus_id'])
                ->leftjoin('vehicle as v','v.cus_id','customer.id')
                ->leftjoin('vehicle_model as vm','vm.id','v.model_id')
                ->leftjoin('vehicle_color as vc','vc.id','v.color_id')
                ->select('customer.*','v.plate_no','v.engine_model','v.start_counter','v.year','v.engine_no','v.vin',
                    'vm.name as vm_name','vc.name as vc_name'
                )
                ->first();
//         $invoice_first_date= InvoiceModel::orderBy('date','asc')->where('cus_id',$id)->first()->date;
            $data['first_service'] = Carbon::parse($detail[0]['date'])->format('d M, Y');
//        dd($data['customer_data']);
//        $data['vehicle_data'] = VehicleModel::where('cus_id',$detail[0]['cus_id'])->get();
            $data['invoice_detail']=$detail;

            return \Excel::create('Maintenace & Service Record-'.Carbon::now(), function($excel) use ($data) {

                $excel->sheet('Detail', function($sheet) use ($data) {

                    $sheet->cells('A11:J100', function($cells) {


                        $cells->setAlignment('center');


                    });
                    $lang  = \Illuminate\Support\Facades\Request::segment(3);
                    if($lang == 'english'){
                        $sheet->loadView('customer.customer_export')->with('data',$data);
                    } else {
                        $sheet->loadView('customer.customer_export_kh')->with('data',$data);
                    }

                });

                ob_end_clean();
            })->download('xlsx');
            
        }else{
            return "No Detail";
        }
    }
    public function update_ro_no(Request $request){

        $ro_no=0;
        $ro=RepairOrderModel::orderBy('ro_no','DESC')->first();
        if (!empty($ro)){
            $ro_no=$ro->ro_no+1;
        }else{
            $ro_no=1;
        }

        $r=new RepairOrderModel();
        $r->cus_id=$request->cus_id;
        $r->ro_no=$ro_no;
        $r->save();

    }
}
