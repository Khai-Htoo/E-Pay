<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken(time())->plainTextToken;

        return success('successfully registered', ['token' => $token]);

    }

    // login
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password'=>'required'
        ]);

        $user = User::where('email',$request->email)->first();

        if($user){
            if(Hash::check($request->password,$user->password)){
        $token = $user->createToken(time())->plainTextToken;
                return success('Login success',['token' => $token]);
            }
            return fail('password incorrect', null);
        }
        return fail('These credentials do not match our records.', null);

    }

    // logout
    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return success('logout',null);
    }

}
