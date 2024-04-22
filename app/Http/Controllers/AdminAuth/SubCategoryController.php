<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Subcategory;


class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        return view('template.admin.subcategory', $data);
    }

    public function show(Request $request)
    {
        $search = $request->input('table_search');
        $categories = Subcategory::query();
        if ($search) {
            $categories->where('name', 'LIKE', '%' . $search . '%');
        }
        $categories->with('category');               //fetch the category to show it in subcategory listing
        $categories = $categories->simplePaginate(10);

        return view('template.admin.sub_category_list', compact('categories'));
    }


    public function store(Request $request)
    {
        // dd( $request->category_id);
        $credentials = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:subcategory',
            'category_id' => 'required',
            'status' => 'required'
        ]);
        // dd($request);
        //Your logic to store the category goes here
        $category = new Subcategory();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->category_id = $request->category_id;
        $category->status = $request->status;
        $category->save();

        return response()->json(['status' => true, 'message' => 'Sub_category added successfully']);
    }

    public function edit(string $id, Request $request)
    {

        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['subcategory'] = $subcategory;
        return view('template.admin.edit_sub_category', $data);
    }


    public function update(string $id, Request $request)
    {

        $category = Subcategory::findOrFail($id);
        $credentials = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:category,slug,' . $category->id . ',id',
            'category_id' => 'required',
            'status' => 'required'
        ]);

        //Your logic to store the category goes here
        // $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->category_id = $request->category_id;

        $category->update();

        return response()->json(['status' => true, 'message' => 'category updated successfully']);
    }




    public function destroy(string $id, Request $request)
    {
        $category = Subcategory::findOrFail($id);


        // Delete the category
        $category->delete();

        return response()->json(['status' => true, 'message' => 'Category deleted successfully']);
    }
}
