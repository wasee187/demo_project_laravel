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
        ]);

        if ($validator->fails()) {

            return redirect('login')
                        ->withErrors($validator)
                        ->withInput();

        }
        $user = User::where(['email' => $req->email])->first();
 
        if(!Hash::check(trim($req->password), $user->password)){
            $req->session()->flash('log_error','Invalid email or password!');
            return redirect()->back();
        }
        
        if($user->status=='Blocked'){
            $req->session()->flash('log_error','User Blocked! Please contact respective concern');
            return redirect()->back();
        }else{
            if($user->role=='admin' || $user->role=='Admin'){
                $req->session()->put('user',$user);
                return redirect('admin');
            }else{
                $req->session()->put('user',$user);
                return redirect('file');
            }
        }
    }

    function register(Request $req){
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'password'=> 'required'
        ]);
 
        if ($validator->fails()) {

            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();

        }
        $pass = $req->password;
        $hashedPassword = Hash::make(trim($pass));
        $user = new User;
        $user->name = $req->name;
        $user->email= $req->email;
        $user->password = $hashedPassword;
        $user->save();
        if(Session::get('user')['role']=='admin' || Session::get('user')['role']=='Admin'){
            $req->session()->flash('log_success','User Added Successfully');
            return redirect('admin');
        }else{
            return redirect('login');
        }
    }
}
