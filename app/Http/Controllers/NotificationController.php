<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Auth;

class NotificationController extends Controller
{
    public function get() {
        $notification = Auth::user()->unreadNotifications;
//        dd($notification);

        return $notification;

//        return '';
    }

    public function read(Request $request) {
        Auth::user()->unreadNotifications()->find($request->id)->markAsRead();
        return 'success';
    }
}
