<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\admin\CheckAdmin;
use App\Http\Controllers\AdminAuth\ProductController;
use App\Http\Controllers\AdminAuth\CategoryController;
use App\Http\Controllers\AdminAuth\SubCategoryController;
use App\Http\Controllers\AdminAuth\Product_SubCategoryController;
use App\Http\Controllers\HomePageController;
use App\http\Controllers\Shop_page_Controller;
use App\Http\Controllers\CartController;
use App\Http\Controllers\userAuth\UserloginController;
use App\Http\Controllers\AdminAuth\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// shopping cart pages routes 

// home page
Route::get('/',[HomePageController::class,'index'])->name('home');

// shop page
Route::get('index/shop_page/{categoryslug?}/{subcategroyslug?}',[Shop_page_Controller::class, 'index'])->name('shop_page');

Route:: get('product_page/{slug?}',[Shop_page_Controller::class,'product'])->name('front_product');

// cart page


Route::middleware(['web'])->group(function () {
    
Route::get('cart',[CartController::class, 'cart'])->name('cart');

Route::post('add_to_cart',[CartController::class, 'addToCart'])->name('add-to-cart');

Route::post('update_cart',[CartController::class, 'updateToCart'])->name('update-to-cart');

Route::post('delete_item',[CartController::class, 'deleteItem'])->name('delete_item');
});


// user authentication pages


Route::get('user/login',[UserloginController::class, 'login'])->name('login_user');

Route::get('user/register',[UserloginController::class, 'register'])->name('register_user');

Route::post('/process',[UserloginController::class, 'store_registration'])->name('store_user');

Route::post('authenticate',[UserloginController::class, 'authenticate'])->name('authenticate_user');



Route::group(['middleware' => ['user',]], function () {
    
    Route::get('/profile',[UserloginController::class, 'profile'])->name('user_profile');

    Route::get('/logout',[UserloginController::class,'logout'])->name('logout_user');
    
    Route::get('/checkout',[CartController::class, 'checkout'])->name('checkout');

    Route::post('/checkout',[CartController::class,'checkout_data_store'])->name('store_checkout_data');

    Route::get('/thankyou',[CartController::class, 'thankyou'])->name('thankyou');
    
});

























Route::get('/admin/login', [LoginController::class, 'index']);
// Route::post('/admin/loginform',[LoginController::class, 'authentication']);
Route::post('/authentication', [LoginController::class, 'authentication'])->name('authentication');

Route::group(['middleware' => ['admin',]], function () {
    // Your admin routes go here
    Route::get('/admin/dashboard', [LoginController::class, 'dashboard'])->name('template.admin.dashboard');

    Route::get('/admin/logout',[LoginController::class, 'logout'])->name('logout');
    
    // category routes 
    Route::get('/category',[CategoryController::class,'index'])->name('category');
    
    Route::post('/category/store',[CategoryController::class, 'createcat'])->name('storing_category');

    Route::get('/category/list',[CategoryController::class,'show'])->name('category.list');
    
    Route::get('/category/{id}/{category}',[CategoryController::class,'edit'])->name('category.edit');

    Route::put('/category/{id}/update',[CategoryController::class, 'update'])->name('category.update');

    Route::delete('/category/{id}/delete',[CategoryController::class, 'destroy'])->name('category.delete');


    // sub_category routes
    Route::get('/sub_category',[SubCategoryController::class,'index'])->name('sub_category');

    Route::post('/sub_category/store',[SubCategoryController::class, 'store'])->name('subcategory.store');

    Route::get('/sub_category/list',[SubCategoryController::class,'show'])->name('sub_category.list');

    Route::get('/sub_category/{id}/{category}',[SubCategoryController::class,'edit'])->name('sub_category.edit');

    Route::put('/sub_category/{id}/update',[SubCategoryController::class, 'update'])->name('sub_category.update');

    Route::delete('/sub_category/{id}/delete',[SubCategoryController::class, 'destroy'])->name('sub_category.delete');


    //product routes 
    Route::get('/product/create',[ProductController::class,'index'])->name('product_page');
    
    Route::post('/product/store',[ProductController::class, 'store'])->name('product.store');

    Route::get('/get-subcategories', [Product_SubCategoryController::class, 'getSubcategories'])->name('get-subcategories');
    
    Route::get('/product/list',[ProductController::class, 'show'])->name('product-list');
   
    Route::get('/product/{id}',[ProductController::class,'edit'])->name('product.edit');

    Route::put('/product/{id}/update',[ProductController::class, 'update'])->name('product_update');

    Route::delete('/product/{id}/delete',[ProductController::class, 'destroy'])->name('product.delete');
});