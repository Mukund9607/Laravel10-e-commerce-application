<?php

namespace App\Http\Controllers\AdminAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Image;
class CategoryController extends Controller
{
   public function index(){
        return view('template.admin.category');
   } 
   



   public function show(Request $request){
    $search = $request->input('table_search');
    $categories = Category::query();
    if ($search) {
        $categories->where('name', 'LIKE', '%' . $search . '%');
    }
    $categories = $categories->simplePaginate(10);
     
        return view('template.admin.list',compact('categories'));
   }


   public function createcat(Request $request)
{
        // dd('test');
        $credentials = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:category',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        //Your logic to store the category goes here
        $category = new Category();
        $category-> name = $request->name;
        $category-> slug = $request->slug;
        $category-> status = $request->status;
        if($request->has('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;

            $path = 'image/category/';
            $file->move($path, $filename);

            if(File::exists($category->image)){
                File::delete($category->image);
            }
            $category->image =  $path.$filename;

            
        }
  
        $category->save();
        
        return response()->json(['status' => true, 'message' => 'category added successfully']);
    
}


    public function edit(string $id, Request $request){
        // echo $id;
        $category = Category::findOrFail($id);

        // Pass the note data to the view
        return view('template.admin.edit_category', ['category' => $category]);
    }

    public function update(string $id , Request $request){

        $category = Category::findOrFail($id);
        $credentials = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:category,slug,'.$category->id.',id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        //Your logic to store the category goes here
        // $category = new Category();
        $category-> name = $request->name;
        $category-> slug = $request->slug;
        $category-> status = $request->status;
        if($request->has('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;

            $path = 'image/category/';
            $file->move($path, $filename);

            if(File::exists($category->image)){
                File::delete($category->image);
            }
            $category->image =  $path.$filename;

        }
  
        $category->update();
        
        return response()->json(['status' => true, 'message' => 'category updated successfully']);
    }

    public function destroy(string $id , Request $request){
        $category = Category::findOrFail($id);


        
    // Delete category image
    if (File::exists($category->image)) {
        File::delete($category->image);
    }

    // Delete the category
    $category->delete();

    return response()->json(['status' => true, 'message' => 'Category deleted successfully']);

    }





}
