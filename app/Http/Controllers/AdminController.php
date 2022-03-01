<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index(){
        //getting all user data
        $users_data = User::all();
        return view('dashboard', ['users'=> $users_data]);
    }


    public function user_Register(){
        //redirecting to new user registration view
        return view('user_register');
    }


    public function store_user(Request $req){//storing new user registration from admin

        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'password'=> 'required' 
            //validation for input
        ]);
 
        if ($validator->fails()) {

            return redirect('admin/user/register')
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
        
        $req->session()->flash('log_success','User Added Successfully');
        return redirect('admin');   
    }

    public function edit_user($id){

        //getting data of required user for updating user
        $user_data = User::find($id);
        return view('user_edit',['user'=> $user_data]);
    }

    public function update_user(Request $request, $id){

        //validating input data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=> 'required',
            'role'=>'required',
            'status'=>'required',
        ]);

        if ($validator->fails()) {
            // redirecting to back if error occurred
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();

        }
        //getting user data
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->role = $request->role;
        $user->password = $user->password;
        $user->save();
        $request->session()->flash('log_success','User Updated Successfully');
        return redirect('admin');
    }

    public function delete_user($id){

        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('log_success','User deleted successfully!');
    }

    public function user_status($id){
        //user status update 
        $user = User::find($id);
        if($user->status=='Unblocked' || $user->status=='unblocked'){
            //checking user status
            $user->status = 'Blocked';
        }else{
            $user->status = 'Unblocked';
        }
        $user->save();
        return redirect()->back()->with('log_success','User updated successfully!');
    }
}
