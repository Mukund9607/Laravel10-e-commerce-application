<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Orders;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\Orderitem;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Models\CustomerAddresses;
use App\Models\CustomersAddresses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Can;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

// we are using this plugins here for cart functionality 

// https://github.com/hardevine/laravelshoppingcart

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        Log::info('Session before adding item:', session()->all());
        $product = Product::find($request->Id); // Assuming 'Id' is the correct key for the product ID
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Check if the product is already in the cart
        $cartContent = Cart::content();
        session(['cartContent' => Cart::content()]);
        $productAlreadyInCart = false;
        foreach ($cartContent as $item) {
            if ($product->id == $item->id) {
                $productAlreadyInCart = true;
                break;
            }
        }

        if ($productAlreadyInCart) {
            return response()->json(['message' => 'Product already in cart'], 200);
        } else {
            // Add the product to the cart with the specified quantity
            Cart::add($product->id, $product->title, 1, $product->price, ["image" => $product->image]);
            session(['cartContent' => Cart::content()]);
            return response()->json(['message' => 'Product added to cart successfully'], 200);
        }
        Log::info('Session after adding item:', session()->all());
    }


    public function updateToCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);

        return response()->json(['message' => 'cart update successfully'], 200);
    }

    // 
    public function deleteItem(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::remove($rowId, $qty);


        return response()->json(['message' => 'item deleted successfully'], 200);
    }

    public function cart()
    {
        // dd(Cart::content());
        $categories = Category::with('subcategories')->where('status', 1)->orderBy('name', 'ASC')->get();

        $cartContent = session('cartContent', []);

        // dd($products);
        $data = [
            'categories' => $categories,
            'cartContent' => $cartContent
        ];


        return view('template.user.cart', $data);
    }




    // checkout method

    public function checkout()
    {
        $categories = Category::with('subcategories')->where('status', 1)->orderBy('name', 'ASC')->get();
        // If cart is empty then redirect to cart page
        if (Cart::count() == 0) {
            return redirect()->route('cart');
        }
        $CustomersAddresses = null;
        // if user is not login then redirect to login page
        if (Auth::check() == false) {
            // if the user tries to access the checkout page without login
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }

            return redirect()->route('login_user');
        }
        // retrive the info from customer_address table to display it on checkout page.
        $CustomersAddresses = CustomersAddresses::where('user_id', Auth::user()->id)->first();



        $countries = Country::orderBy('name', 'ASC')->get();
        $data = [
            'categories' => $categories,
            'countries' => $countries,
            'CustomersAddresses' => $CustomersAddresses
        ];
        session()->forget('url.intended');

        return view('template.user.checkout', $data);
    }


    public function checkout_data_store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:30',
            'apartment' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "fix it",
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }

        $user = Auth::user();

        // if user store the address then we won't insert it again we will update it
        // step-2 
        // store the data in customes_address table
        CustomersAddresses::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'mobile' => $request->mobile


            ]
        );



        // step-3
        // store the data in orders table
        if ($request->payment_method == 'cod') {
            $shipping = 0;
            $subtotal = Cart::subtotal(2, '.', '');
            $grand_total = $subtotal + $shipping;


            $order = new Orders;
            $order->subtotal = $subtotal;
            $order->shipping = $shipping;
            $order->grand_total = $grand_total;
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->country_id = $request->country;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->city =  $request->city;
            $order->state =  $request->state;
            $order->zip =  $request->zip;
            $order->mobile = $request->mobile;
            $order->notes = $request->order_notes;
            $order->save();

            // step-4
            // store the data in orderItem table
            foreach (Cart::content() as $item) {
                $orderitem = new Orderitem;
                $orderitem->product_id = $item->id;
                $orderitem->order_id = $order->id;
                $orderitem->name = $item->name;
                $orderitem->qty = $item->qty;
                $orderitem->price = $item->price;
                $orderitem->total =  $item->price * $item->qty;
                $orderitem->save();
            }
            Cart::destroy();
            return response()->json([
                "message" => "order save successfully",
                "status" => true
            ]);
        } else {

            $response = null;
            $stripe = new \Stripe\StripeClient(env('STRIPE_TEST_SK'));

            // Initialize an empty array to hold line items
            $lineItems = [];

            foreach (Cart::content() as $item) {

                // Fetch product information from the database
                $product = Product::find($item->id);


                if ($product && $product->title && $product->price > 0) {
                    $lineItems[] = [

                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => ['name' => $product->title],
                            'unit_amount' =>  $product->price * 100,
                        ],
                        'quantity' => $item->qty,
                    ];
                }
            }

            // Initialize $response variable to null

            if (count($lineItems) > 0) {
                $response = $stripe->checkout->sessions->create([
                    'mode' => 'payment',
                    'line_items' => $lineItems,
                    'success_url' => 'https://example.com/success',
                    'cancel_url' => 'https://example.com/cancel',
                ]);
            }
            // dd($response);  

            if (isset($response->id) && $response->id != '') {
                // Return the Stripe payment page URL to the frontend
                return response()->json([
                    'status' => true,
                    'message' => 'Payment session created successfully.',
                    'payment_url' => $response->url
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create payment session.'
                ]);
            }
        }
    }




    public function thankyou()
    {
        $categories = Category::with('subcategories')->where('status', 1)->orderBy('name', 'ASC')->get();
        $data = [
            'categories' => $categories,
        ];
        return view('template.user.thankyou', $data);
    }
}
