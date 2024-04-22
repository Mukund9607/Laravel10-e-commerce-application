<?php

namespace App\Http\Controllers;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index(){
        $categories = Category::with('subcategories')->orderBy('name', 'ASC')->get();
        $products = Product::where('status','1')->orderBy('title','ASC')->get();
        $latest_products = Product::where('status','1')->orderBy('id','ASC')->take(8)->get();
        return view('template.user.welcome', ['categories' => $categories,'products' => $products, 'latest_products' =>$latest_products]);
    }

}



