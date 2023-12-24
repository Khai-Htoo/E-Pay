<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DashboardController extends Controller
{
    // admin and user route
    public function dashboard(){
        if(Auth::user()->role === 'user'){
            return redirect()->route('userHomePage');
        }if (Auth::user()->role === 'admin') {
           return redirect()->route('adminHomePage');
        }
    }

    public function adminHomePage(){
        return view('admin.adminDashboard');
    }

    // for user home page
    public function userHomePage(){
        return view('user.userPage');
    }

    // for login
    public function login(){
     return view('auth.login');
    }
}
