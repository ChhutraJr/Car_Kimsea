<?php

namespace App\Http\Controllers;

use App\ModuleModel;
use App\PrivilegeModel;
use App\RoleModel;
use App\SubModuleModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(){
        //Permission Start
        if (!config('global.add_user')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.role_icon')]);
        config(['global.text_content_title' => 'Roles']);

        //set index link
        config(['global.index_link' => 'role.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Roles Found']);
        config(['global.no_data_text' => 'You have not added any role add first role now']);
        config(['global.no_data_btn' => 'Add New Role']);

        //set link add new
        config(['global.add_new_link' => '/role/create']);
        //set link update
        config(['global.update_link' => '/role/update']);

        //set delete
        config(['global.alert_delete_title' => 'This role will be deleted.']);
        config(['global.delete_link' => 'master_delete.role']);
        config(['global.after_delete_text' => 'Role has been deleted.']);
        config(['global.cant_delete_text' => 'The user related to this role exist.']);


        $master=RoleModel::all();
        $data=array(
            'master'=>$master
        );
        return view('user.role.index',$data);

    }
    public function create(){
        //Permission Start
        if (!config('global.add_user')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.role_icon')]);
        config(['global.text_content_title' => 'Add new role']);
        config(['global.parent_text_content_title' => 'Roles']);

        //set submit route
        config(['global.submit_link' => 'store.role']);
        //set index route
        config(['global.index_link' => '/roles']);

        $module=ModuleModel::orderBy('order')->get();

        return view('user.role.create')->with('module',$module);
    }
    public function store(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:role,name'
            ]);

            if ($validator->passes()){
                $master=new RoleModel();
                $master->name=$request->name;
                $master->save();

                Session::flash('message', 'Role have been added !');
                Session::flash('alert-type', 'success');

                return response()->json(['verify'=>'true','id'=>$master->id]);
            }

            return ['errors' => $validator->errors(),'data'=>$request->all()];

    }
    public function update($id){
        //Permission Start
        if (!config('global.add_user')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.role_icon')]);
        config(['global.text_content_title' => 'Edit Role']);
        config(['global.parent_text_content_title' => 'Roles']);

        //set submit route
        config(['global.submit_link' => 'save_update.role']);
        //set index route
        config(['global.index_link' => '/roles']);

        $master=RoleModel::where('id',$id)->first();
        $module=ModuleModel::orderBy('order')->get();

        $data=array(
            'master'=>$master,
            'module'=>$module
        );

        return view('user.role.update',$data);
    }
    public function save_update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100'
        ]);

        if ($validator->passes()){
            $current_name=RoleModel::where('id',$request->update_id)->first()->name;
            RoleModel::where('id',$request->update_id)->update([
                'name'=>$request->name
            ]);

            Session::flash('message', 'Role have been updated !');
            Session::flash('alert-type', 'success');

            //delete all old permission
            PrivilegeModel::where('role_id',$request->update_id)->delete();

            return response()->json(['verify'=>'true','id'=>$request->update_id]);
        }

        return ['errors' => $validator->errors(),'data'=>$request->all()];
    }

    public function delete(Request $request){

        $master=User::where('role_id',$request->id)->count();
        //check if no related master
        if ($master==0){
            //delete master
            RoleModel::where('id',$request->id)->delete();

            //delete all permission
            PrivilegeModel::where('role_id',$request->id)->delete();
        }else{
            //if have related master
            return response()->json(['delete'=>'false']);
        }

    }

//    Server Side
    function get_data()
    {
        $master=RoleModel::orderBy('id','DESC')->select();

        //return $products;
        return DataTables::of($master)->make(true);
    }

    //Permission
    public function per(Request $request){
        $sub = $request->sub_module;
        foreach (explode(",", $sub) as $sub_module)
        {
            if (!empty($sub_module)){
                $module_id=SubModuleModel::where('id',$sub_module)->first()->module_id;
                $pri=new PrivilegeModel();
                $pri->role_id=$request->role_id;
                $pri->module_id=$module_id;
                $pri->sub_module_id=$sub_module;
                $pri->save();
            }

        }

        return response()->json(['verify'=>'true']);

        //return $request->all();
    }

    //add privilege to database
/*    public function per_create($pri,$r_id,$m_id,$sm_id){
        //only add if the checkbox is true
        if ($pri==1){
            $pri=new PrivilegeModel();
            $pri->role_id=$r_id;
            $pri->module_id=$m_id;
            $pri->sub_module_id=$sm_id;
            $pri->save();
        }

    }*/

    //get count has permission or not
/*    public function get_checked($role_id,$m_id,$sm_id){
        return PrivilegeModel::where('role_id',$role_id)
            ->where('module_id',$m_id)
            ->where('sub_module_id',$sm_id)
            ->count();
    }*/

    //return all module
    public function module(){
        return ModuleModel::orderBy('order')->get();
    }

    //return all sub module
    public function sub_module_all(){
        return SubModuleModel::select('id')->get();
    }

    //return all sub module by module id
    public function sub_module($module_id){
        return SubModuleModel::select('id')->where('module_id',$module_id)->get();
    }
}
