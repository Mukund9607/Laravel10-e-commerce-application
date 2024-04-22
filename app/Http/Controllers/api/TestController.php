<?php

namespace App\Http\Controllers\api;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    // function to call api 
    public function api_call(Request $request)
    { 
        return response()->json([
            'status' => true,
            'message' => "api hit successfully",
            'data'=> $request->all()
        ]);
    }
}
