<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function login(Request $req){
        $validator = Validator::make($req->all(), [
            'email' => 'required',
            'password'=> 'required'
            //validation for input
        ]);

        if ($validator->fails()) {

            return redirect('login')
                        ->withErrors($validator)
                        ->withInput();
            //redirecting back with error message

        }
        $user = User::where(['email' => $req->email])->first(); //matching the email
 
        if(!Hash::check(trim($req->password), $user->password)){
            $req->session()->flash('log_error','Invalid email or password!');
            return redirect()->back();
            //matching hashed password if error occurred than redirecting back
        }
        
        if($user->status=='Blocked'){
            //checking if user is blocked or not
            $req->session()->flash('log_error','User Blocked! Please contact respective concern');
            return redirect()->back();
        }else{
            //checking if user role is admin or user
            if($user->role=='admin' || $user->role=='Admin'){
                $req->session()->put('user',$user);
                return redirect('admin');
            }else{
                $req->session()->put('user',$user);
                return redirect('user/dashboard');
            }
        }
    }

    function register(Request $req){

        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'password'=> 'required' 
            //validation for input
        ]);
 
        if ($validator->fails()) {

            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
            //redirecting back with error message  
        }
        $pass = $req->password;
        $hashedPassword = Hash::make(trim($pass));//hashing password
        $user = new User;
        $user->name = $req->name;
        $user->email= $req->email;
        $user->password = $hashedPassword;
        $user->save(); //new user save

        $req->session()->flash('log_success','Registration Successful, Please login');
        return redirect('login'); //redirecting user for login

    }
}
