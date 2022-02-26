<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authmiddleware
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
        if(($request->path()=='login' || $request->path()=='register') && $request->session()->has('user') && Session::get('user')['role']=='user'){
            return redirect('/file');
        }else if($request->path()=='login' && $request->session()->has('user') && Session::get('user')['role']=='admin'){
            return redirect('/admin');
        }
        else if($request->path()=='admin' && !$request->session()->has('user')){
            return redirect('/login');
        }
        return $next($request);
    }
}
