<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    //notification page
    public function notification(){
        $user = User::where('id',Auth::user()->id)->first();
        $notification =$user->notifications;
        return view('user.notification',compact('notification'));
    }

    // notification detail
    public function notiDetail($id){
        $user = User::where('id',Auth::user()->id)->first();
        $notification =$user->notifications->where('id',$id)->first();
        // return $notification;
        $notification->markAsRead();
       return view('user.notiDetail',compact('notification'));
    }


}
