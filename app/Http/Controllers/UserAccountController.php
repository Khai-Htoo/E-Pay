<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class UserAccountController extends Controller
{
    //user account page
    public function index()
    {
        return view('user.account.index');
    }
    // update Password
    public function updatePassword()
    {
        return view('user.account.updatePassword');
    }
    // change password
    public function changePassword(Request $request)
    {
        $dbPassword = User::where('id', Auth::user()->id)->first();
        $dbPassword = $dbPassword->password;
        $this->cpValidate($request);
        if (Hash::check($request->oldPassword, $dbPassword)) {
            User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->newPassword)]);
            $user = User::where('id',Auth::user()->id)->first();

            $title = 'Change Password';
            $message = 'Your password is successfully changed.';
            $source_id = Auth::user()->id;
            $source_type = User::class;
            $deep_link = [
                'target'=>'transferDetail',
                'parameter'=>null
            ];

            Notification::send($user, new GeneralNotification($title,$message,$source_id,$source_type,$deep_link ));
            return back()->with(['success' => 'Password change password!']);
        }
        return back()->with(['fail'=>'Incorrect Password!Try again Bratha']);
    }
    // validation for change password
    private function cpValidate($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword',
        ])->validate();
    }

}
