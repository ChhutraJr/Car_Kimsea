<?php

namespace App\Http\Controllers;


use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    //    Server Side Master
    function get_data()
    {
        //get all master and relationship values
        $master=User::orderBy('id','DESC')
            ->leftjoin('role as r','r.id','users.role_id')
            ->select('users.*','r.name as role');

        return DataTables::of($master)
            //Edit created date format
            ->editColumn('created_at', function($master) {

                return Carbon::parse($master->created_at)->format('d M, Y');

            })
            ->addColumn('name', function ($master){
                if (!empty($master->last_name)){
                    return $master->first_name.' '.$master->last_name;
                }else{
                    return $master->first_name;
                }
            })
            ->make(true);
    }

    public function index(){
        //Permission Start
        if (!config('global.view_user')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.user_icon')]);
        config(['global.text_content_title' => 'Users']);

        //set index link
        config(['global.index_link' => 'user.get_data']);

        //set no data content
        config(['global.no_data_title' => 'No Users Found']);
        config(['global.no_data_text' => 'You have not added any user add first user now']);
        config(['global.no_data_btn' => 'Add New User']);

        //set link add new
        config(['global.add_new_link' => '/user/create']);
        //set link update
        config(['global.update_link' => '/user/update']);

        $master = User::all();

        $data = array(
            'master' => $master,
        );



        return view('user.index', $data);
    }

    // Show create view master
    public function create(){
        //Permission Start
        if (!config('global.add_user')){
            return view('errors.not_found');
        }
        //Permission End

        //set product content global icon and name
        config(['global.icon_content_title' => config('global.user_icon')]);
        config(['global.text_content_title' => 'Add new user']);
        config(['global.parent_text_content_title' => 'Users']);

        //set submit route
        config(['global.submit_link' => 'store.user']);
        //set index route
        config(['global.index_link' => '/users']);

        $roles= role();

        $data = array(
            'user' => '',
            'roles' => $roles
        );
        return view('user.create', $data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function store(Request $request)
    {

        //Check if input is right or wrong
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4|max:100|unique:users,username',
            'password'=>'required|min:6|max:15',
            'confirm_password' => 'required|min:6|max:15|same:password',
            'first_name' => 'required|max:50',
            'last_name' => 'max:50',
            'image'=>'mimes:jpeg,png',
            'role' => 'required'
        ]);

        //If input is right
        if ($validator->passes()) {

            $path='profile\avatar\user.png';
            if ($request->file('image')!=null){
                $path=$request->file('image')->store('profile/avatar');
            }

            //Add user to database
            $user =new User();
            $user->username=$request->username;
            $user->password=bcrypt($request->password);
            $user->first_name=$request->first_name;
            $user->last_name=$request->last_name;
            $user->image=$path;
            $user->role_id=$request->role;
            $user->save();


            Session::flash('message', 'User have been added !');
            Session::flash('alert-type', 'success');

            return response()->json(['verify'=>'true',
                'name'=>$request->username,
            ]);
        }

        //Send errors if input is wrong
        return ['errors' => $validator->errors()];


    }
    // Show update view master
    public function update($id){
        //Permission Start
        if (!config('global.update_user')){
            return view('errors.not_found');
        }
        //Permission End

        //set content global icon and name
        config(['global.icon_content_title' => config('global.user_icon')]);
        config(['global.text_content_title' => 'Edit User']);
        config(['global.parent_text_content_title' => 'Users']);

        //set submit route
        config(['global.submit_link' => 'save_update.user']);
        //set index route
        config(['global.index_link' => '/users']);

        $roles= role();

        $master=User::where('id',$id)->first();

        $data=array(
            'roles'=>$roles,
            'master'=>$master
        );

        return view('user.update',$data);

    }

    public function save_update(Request $request){
        //Check if input is right or wrong
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4|max:100',
            'first_name' => 'required|max:50',
            'last_name' => 'max:50',
            'image'=>'mimes:jpeg,png',
            'role' => 'required'
        ]);

        //check if the username is the same
        $current_user=User::where('id',$request->update_id)->first();
        if ($current_user->username!=$request->username){
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:4|max:100|unique:users,username',
                'first_name' => 'required|max:50',
                'last_name' => 'max:50',
                'image'=>'mimes:jpeg,png',
                'role' => 'required'
            ]);
        }

        //check if user want to change password
        $pass=$current_user->password;
        if (!empty($request->password)||!empty($request->confirm_password)){
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:4|max:100',
                'password'=>'required|min:6|max:15',
                'confirm_password' => 'required|min:6|max:15|same:password',
                'image'=>'mimes:jpeg,png',
                'role' => 'required'
            ]);

            $pass=bcrypt($request->password);
        }


        //If input is right
        if ($validator->passes()) {

            //get old image
            $path=$current_user->image;

            //if have new image remove old image and add new
            if ($request->file('image')!=null){

                if ($current_user->image!='profile\avatar\user.png'){
                    Storage::delete($path);
                }

                $path=$request->file('image')->store('/profile/avatar');

            }


            User::where('id',$request->update_id)->update([
                'username'=>$request->username,
                'password'=>$pass,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'image'=>$path,
                'role_id'=>$request->role

            ]);


            Session::flash('message', 'User have been updated !');
            Session::flash('alert-type', 'success');

            //Send value back to view
            return response()->json(['verify'=>'true']);
        }

        //Send errors if input is wrong
        return ['errors' => $validator->errors()];
    }

    function status(Request $request){

        $user=User::where('id',$request->id)->first();

        //update user status to deactivate
        if ($user->status==1){
            User::where('id',$request->id)->update(['status'=>0]);
        }else{
            //update user status to activate
            User::where('id',$request->id)->update(['status'=>1]);
        }


    /*    Session::flash('message', $user->username.' have been updated !');
        Session::flash('title', 'User');
        Session::flash('alert-type', 'success');
        return redirect('/user');*/

        return response()->json(['verify'=>'true',
            'status'=>$user->status,
        ]);

    }

    public function all_users(){
        //$user=User::where('status',1)->get();
        //Permission Start
        $user=User::where('status',1)
            ->join('privilege','privilege.role_id','users.role_id')
            ->join('role','role.id','privilege.role_id')
            ->join('sub_module','sub_module.id','privilege.sub_module_id')
            ->join('module','module.id','privilege.module_id')
            ->where('module.name', 'notification')
            ->where('sub_module.name', 'allow_notification')
            ->select('users.id as id')
            ->get();
        //Permission End
        return $user;
    }
}