<?php

namespace App\Http\Middleware\admin;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        {
            if (Auth::check() && Auth::user()->role == 2) {
                
                return $next($request);
            }elseif (Auth::check()) {
                // If the user is logged in but not an admin, redirect them to the login page with an alert
                return redirect('/admin/login')->with('error', 'You do not have admin access');
            }else{
                return redirect('/admin/login')->with('error', 'You have not admin access');
            }
    
            
        }
    }
}
