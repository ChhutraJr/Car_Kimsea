<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected  $redirectTo = '/';
    public function index()
    {
        if (Auth::check()) {
            return redirect()->back();
        }
        return view('login.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function auth(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required|max:100',
            'password'=>'required|max:100',
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                // Authentication passed...


                //Check activate user
                $status=User::where('username',$request->username)->first()->status;
                if ($status==0){
                    Auth::logout();
                    return ['activate' => 'false'];
                }


                //Redirect Permission Start
                get_nav();
                $link='';

                if (config('global.view_dashboard')){
                    $link='dashboard';
                }elseif(config('global.view_customer')){
                    $link='customers';
                }elseif(config('global.view_sell')){
                    $link='sales';
                }elseif(config('global.view_product')){
                    $link='products';
                }elseif (config('global.view_expense')){
                    $link='expenses';
                }else{
                    $link='users';
                }
                //Redirect Permission End

                return ['verify' => 'true',
                    'role'=>Auth::user()->role()->first()->name,
                    'link'=>$link
                ];
            }else{
                return ['verify' => 'false'];
                //return redirect()->back()->with('msg',"Your Email or Password is incorrect !");
            }
        }

        return ['errors' => $validator->errors()];

    }

    public function validate_username(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:100',
        ]);

        return ['errors' => $validator->errors()];
    }
}
