<?php


namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Price;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{

    // index function
    public function index()
    {
        return view('website.ecommerce.cart');
    }
      public function gocToCheckout()
    {
        $regions=Region::get();
     
        return view('website.ecommerce.chackout', compact('regions'));
    }
    // public function addToCart(Request $request)
    // {



    //     $id = $request->id;
        

    //     $product = Crop::with('prices')->where('id',$id);
     
        
      
    //     $cart = session()->get('cart', []);

    //     if (isset($cart[$id])) {
    //         $cart[$id]['quantity']++;
    //     } else {
    //         $cart[$id] = [
    //             'name' => $product->name,
    //             'quantity' => 1,
    //             'price' => $product->price,
    //             'image' => $product->image
    //         ];

    //         // dd($cart);
    //     }

    //     session()->put('cart', $cart);
        
    // }
    public function addToCart(Request $request)
{
    $id = $request->id;

    $product = Crop::with('prices')->find($id);

    if (!$product || $product->prices->isEmpty()) {
        return response()->json(['error' => 'Product or price not found.'], 404);
    }

    $price = $product->prices->first(); // Adjust this logic if needed

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => $price->price,
            'unit' => $price->unit,
            'image' => $product->image,
        ];
    }

    session()->put('cart', $cart);

    return response()->json(['message' => 'Product added to cart.', 'cart' => $cart]);
}


    public function viewCart()
    {
        return view('website.ecommerce.cart');
    }

    public function updateCart(Request $request)
    {

        if ($request->id && $request->quantity) {

            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);
            return response()->json(['success' => true, 'message' => 'Cart updated!']);

        }
    }

    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            unset($cart[$request->id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item removed!');
        }
    }


}