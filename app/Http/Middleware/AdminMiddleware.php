<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
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

        if(($request->path() == 'admin' || $request->path() == 'admin/user/register' || $request->path() == 'admin/user/{id}/edit') &&!(Session::get('user')['role']=='admin' || Session::get('user')['role']=='Admin')){
            $request->session()->flash('error_msg', 'Access Denied! You do not have permission to perform the operation');
            return redirect('file');
        }
        return $next($request);
    }
}
