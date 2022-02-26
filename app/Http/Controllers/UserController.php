<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('edit', ['user'=> $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=> 'required',
            'role'=>'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();

        }
        
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status =  $user->status;
        $user->role = $request->role;
        $user->password = $user->password;
        $user->save();
        $request->session()->flash('log_success','User updated successfully!');
        return redirect('admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('log_success','User deleted successfully!');
    }

    public function updateStatus($id){
        $user = User::find($id);
        if($user->status=='Unblocked' || $user->status=='unblocked'){
            $user->status = 'Blocked';
        }else{
            $user->status = 'Unblocked';
        }
        $user->save();
        return redirect()->back()->with('log_success','User updated successfully!');
    }
}
