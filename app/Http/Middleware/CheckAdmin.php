<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    //Permission Start
    //on window load
/*    public function __construct()
    {
        if (Auth::check()){
            //Permission Start
            get_nav();
            //Permission End

        }
    }*/
    //Permission End

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()==null){
            return redirect()->route('login.system');
        }

        //Permission Start
        get_nav();
//        notify_follow_up();
        //Permission End

        return $next($request);
    }
}
