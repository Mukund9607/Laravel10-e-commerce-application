<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminAuth\SubCategoryController;
use App\Models\Subcategory;
// use Illuminate\Support\Facades\DB;

class Product_SubCategoryController extends Controller
{
    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        // Retrieve subcategories based on the selected category ID
        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        // Return JSON response containing subcategories
        return response()->json($subcategories);
    }
}
