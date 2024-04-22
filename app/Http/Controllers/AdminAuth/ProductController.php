<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    public function index(){
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        return view('template.admin.product', $data);
    }
    public function store(Request $request){
        // dd('test');
        $credentials = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' =>'required|numeric',
            'category_id' => 'required|numeric',
            'description' => 'nullable|string'
            

        ]);

        // Sanitize the description to remove HTML tags
        $description = strip_tags($request->description);
        //Your logic to store the category goes here
        $product = new Product();
        $product-> title = $request->title;
        $product-> slug = $request->slug;
        $product-> category_id = $request->category_id;
        $product-> subcategory_id = $request->subcategory_id;
        $product->description = $description;
        $product-> compare_price = $request->compare_price; 
        $product-> price = $request ->price;
        if($request->has('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;

            $path = 'product/product_images/';
            $file->move($path, $filename);

            if(File::exists($product->image)){
                File::delete($product->image);
            }
            $product->image =  $path.$filename;

            
        }
  
        $product->save();
        
        return response()->json(['status' => true, 'message' => 'product added successfully']);
    }






    public function show(Request $request)
    {
        $search = $request->input('table_search');
        $products = Product::query();
        // dd($search);
        if ($search) {
            $products->where('title', 'LIKE', '%' . $search . '%');
        }
        $products->with('category','subcategory'); 
                      //fetch the category to show it in subcategory listing
        $products = $products->simplePaginate(10);

        return view('template.admin.product_list', compact('products'));
    }

    

    public function edit(string $id, Request $request)
    {
    
    $product = Product::findOrFail($id);
    $subcategories = Subcategory::where('category_id',$product->category_id)->get(); // Fetch subcategory using product's subcategory_id
    $categories = Category::orderBy('name', 'ASC')->get();
    $data = [
        'product' => $product,
        'subcategories' => $subcategories,
        'categories' => $categories,
    ];

    return view('template.admin.edit_product', $data);
    }
    

    
    public function update(string $id, Request $request)
    {

        $product = Product::findOrFail($id);
        $credentials = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' =>'required|numeric',
            'category_id' => 'required|numeric',
            'description' => 'nullable|string'
        ]);
        // Sanitize the description to remove HTML tags
        $description = strip_tags($request->description);

        //Your logic to store the category goes here
        // $category = new Category();
        // $ $product = new Product();
        $product-> title = $request->title;
        $product-> slug = $request->slug;
        $product->status = $request->status;
        $product-> category_id = $request->category_id;
        $product-> subcategory_id = $request->subcategory_id;
        $product->description = $description;
        $product-> compare_price = $request->compare_price; 
        $product-> price = $request ->price;
        if($request->has('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;

            $path = 'product/product_images/';
            $file->move($path, $filename);

            if(File::exists($product->image)){
                File::delete($product->image);
            }
            $product->image =  $path.$filename;

            
        }
  
        $product->update();
        
        return response()->json(['status' => true, 'message' => 'product updated successfully']);
    }



    
    public function destroy(string $id, Request $request)
    {
        $product = Product::findOrFail($id);


        if (File::exists($product->image)) {
            File::delete($product->image);
        }
        // Delete the category
        $product->delete();

        return response()->json(['status' => true, 'message' => 'product deleted successfully']);
    }











}
