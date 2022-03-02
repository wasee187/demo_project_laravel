<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
       
        if(($request->path() =='login' || $request->path() == 'register') && Session::get('user')){
            //redirecting logged in user to different path depending on their role
            if(Session::get('user')['role']=='admin' || Session::get('user')['role']=='Admin'){
                return redirect('/admin');
            }else{
                return redirect('/file');
            }
        }else if(($request->path() =='admin' || $request->path() == 'admin/user/register' || $request->path() == 'file' || $request->path() == 'user/file_upload') && !Session::get('user')){
            //restricting non logged in user
            return redirect('/login');
        }
        
        return $next($request);
    }
}
