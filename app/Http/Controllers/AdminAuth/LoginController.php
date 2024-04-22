<?php

namespace App\Http\Controllers\AdminAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\User;
class LoginController extends Controller
{

    public function index(){
        
        return view('template.admin.login');

    }

    public function authentication(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        // Authentication passed...
        return redirect()->intended(route('template.admin.dashboard'));
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}



    public function dashboard()
    {
    // You can add any logic here to prepare data for the admin dashboard
    
        return view('template.admin.dashboard');
    }



    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }

}
