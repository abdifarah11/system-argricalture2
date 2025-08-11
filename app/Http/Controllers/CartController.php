<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Region;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        return view('website.ecommerce.cart');
    }

    /**
     * Go to checkout page
     */
    public function goToCheckout()
    {
        $regions = Region::all();
        return view('website.ecommerce.chackout', compact('regions'));
    }

    /**
     * Add a product to the cart
     */
    public function addToCart(Request $request)
    {
        $id = $request->id;
        $product = Crop::with('prices')->find($id);

        if (!$product || $product->prices->isEmpty()) {
            return response()->json(['error' => 'Product or price not found.'], 404);
        }

        $price = $product->prices->first();
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'quantity' => 1,
                'price'    => $price->price,
                'unit'     => $price->unit,
                'image'    => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Product added to cart.',
            'cart'    => $cart
        ]);
    }

    /**
     * View the cart
     */
    public function viewCart()
    {
        return view('website.ecommerce.cart');
    }

    /**
     * Update a cart item's quantity
     */
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart', []);

            if (isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = (int) $request->quantity;
                session()->put('cart', $cart);

                return response()->json(['success' => true, 'message' => 'Cart updated!']);
            }

            return response()->json(['success' => false, 'message' => 'Item not found in cart.'], 404);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request.'], 400);
    }

    /**
     * Remove a single item from the cart
     */
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed!');
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        session()->forget('cart');

        // If using a database cart
        if (auth()->check() && class_exists(\App\Models\Cart::class)) {
            \App\Models\Cart::where('user_id', auth()->id())->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully.'
        ]);
    }
}
