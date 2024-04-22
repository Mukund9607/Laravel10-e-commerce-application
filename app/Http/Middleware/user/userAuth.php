<?php

namespace App\Http\Middleware\user;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class userAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role == 1) {
             // If the user is logged in and has a role of 1 (customer), check if they are trying to access the login page
        if ($request->is('login_user')) {
            // Redirect them to a specific page, e.g., the home page, if they are trying to access the login page
            return redirect()->route('home')->with('info', 'You are already logged in.');
        }
            // If the user is logged in and has a role of 1 (customer), allow them to proceed
            return $next($request);
        } elseif (Auth::check()) {
            // If the user is logged in but does not have a role of 1, redirect them with a general error message
            return redirect('user/login')->with('error', 'You must log in to access this page');
        } else {
            // If the user is not logged in, redirect them to the customer login page with a general message
            return redirect('user/login')->with('error', 'You must log in to access this page');
        }
    }
}
