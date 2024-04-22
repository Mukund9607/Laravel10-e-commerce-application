<?php

namespace App\Http\Controllers\userAuth;
use \Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserloginController extends Controller
{
    public function login()
    {   Log::info('Session after login:', session()->all());
        $categories = Category::with('subcategories')->orderBy('name', 'ASC')->get();
        $data = [
            'categories' => $categories
        ];
        return view('template.user.login', $data);
    }



    public function register()
    {
        $categories = Category::with('subcategories')->orderBy('name', 'ASC')->get();
        $data = [
            'categories' => $categories
        ];
        return view('template.user.register', $data);
    }



    public function store_registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'

        ]);


        if ($validator->passes()) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required|min:5'
            
        ]);
        if ($validator->passes()) {
            Log::info('Validation passed');
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                Log::info('Authentication successful');
                return redirect()->intended();
                // return redirect()->intended(route('user_profile'));
            } else {
                // Handle the case where the login attempt was unsuccessful
                Log::info('Authentication failed');
                return redirect()->back()
                    ->withErrors(['email' => 'Invalid credentials','password'=>'Invalid credentials'])
                    ->withInput($request->only('email'));
            }
        } else {
            Log::info('Validation failed');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }


    public function profile(){
        $categories = Category::with('subcategories')->orderBy('name', 'ASC')->get();
        $data = [
            'categories' => $categories
        ];
        return view('template.user.profile', $data);
    }

    public function logout(Request $request){
        Auth::logout();
        // $request->session()->flush();
        Log::info('Session after attempting to clear cart:', session()->all());

        return redirect('user/login');
    }



}


