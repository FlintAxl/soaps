<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = $this->getUserCart();
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = $this->getUserCart();

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                "product_id" => $product->id,
                "name"       => $product->name,
                "quantity"   => $request->quantity,
                "price"      => $product->price,
                "image"      => $product->images->first()
                    ? asset('storage/' . $product->images->first()->image_path)
                    : asset('path/to/default/image.jpg')
            ];
        }

        $this->saveUserCart($cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id) // Changed parameter to $id
    {
        $cart = $this->getUserCart();

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            $this->saveUserCart($cart);
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully');
        }

        return redirect()->route('cart.index')->with('error', 'Product not found in cart');
    }

    public function remove($id) // Changed parameter to $id
    {
        $cart = $this->getUserCart();

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->saveUserCart($cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }

    // New method to clear the user's cart after successful order placement
    public function clearCart()
    {
        if (Auth::check()) {
            session()->forget('cart_' . Auth::id());
        }
    }

    // Retrieves the cart using a consistent session key
    public function getUserCart()
    {
        if (Auth::check()) {
            // Return array format with product IDs as keys
            return session()->get('cart_' . Auth::id(), []);
        }
        return [];
    }

    // Saves the cart to the session using a consistent key
    public function saveUserCart($cart)
    {
        if (Auth::check()) {
            session()->put('cart_' . Auth::id(), $cart);
        }
    }
}
