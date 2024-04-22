<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class Shop_page_Controller extends Controller
{
    public function index(Request $request, $categoryslug = null, $subcategroyslug = null)
    {


        Log::info('Request Data:', $request->all());
        $categories = Category::with('subcategories')->where('status', 1)->orderBy('name', 'ASC')->get();

        $products = Product::where('status', 1);

        // apply filters
        if (!empty($categoryslug)) {
            $category = Category::where('slug', $categoryslug)->first();
            $products = Product::where('category_id', $category->id);
        }
        if (!empty($subcategroyslug)) {
            $subcategory = Subcategory::where('slug', $subcategroyslug)->first();
            $products = Product::where('subcategory_id', $subcategory->id);
        }

        if ($request->get('price_min') != '' && $request->get('price_max') != '') {
            $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);
        }

        if(!empty($request->get('search'))){
            $products = $products->where('title','like','%'. $request->get('search').'%');
        }


        if ($request->get('sort')) {
            if ($request->get('sort') == 'latest') {
                $products = $products->orderBy('id', 'DESC');
            } elseif ($request->get('sort') == 'price_asc') {
                $products = $products->orderBy('id', 'ASC');
            } elseif ($request->get('sort') == 'price_desc') {
                $products = $products->orderBy('id', 'DESC');
            } else {
                $products = $products->orderBy('id', 'DESC');
            }
        }


        $products = $products->simplepaginate(3);
        $data = [
            'categories' => $categories,
            'products' => $products,
            'categoryslug' => $categoryslug, // Pass the category slug to the view
            'subcategroyslug' => $subcategroyslug, // Pass the subcategory slug to the view
            'price_min' => intval($request->get('price_min')),
            'price_max' => (intval($request->get('price_max')) == 0 ? 10000 :  $request->get('price_max')),
            'sort' => $request->get('sort')
        ];


        return view('template.user.shope_page', $data);
    }



    public function product($slug){
        // echo $slug;
        $categories = Category::with('subcategories')->where('status', 1)->orderBy('name', 'ASC')->paginate(3);

        $products = Product::where('slug', $slug)->with('image')->first();
        // dd($products);
        $data = [
            'categories' => $categories,
            'products' => $products
        ];
        return view('template.user.product_page',$data);

    }
}
