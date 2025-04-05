<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function receive(Order $order)
{
    // Authorization - only order owner can receive
    if ($order->user_id != auth()->id()) {
        abort(403);
    }

    if ($order->status == 'shipping') {
        $order->update(['status' => 'completed']);
        return back()->with('success', 'Order marked as received');
    }

    return back()->with('error', 'Only shipping orders can be marked as received');
}
    public function cancel(Order $order)
{
    // Authorization
    if ($order->user_id != auth()->id()) {
        abort(403);
    }

    if ($order->status == 'pending') {
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Order cancelled');
    }

    return back()->with('error', 'Only pending orders can be cancelled');
}
    public function index()
    {
        $orders = Auth::user()->orders()
                    ->with(['items.product'])
                    ->latest()
                    ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $cartItems = app(CartController::class)->getUserCart();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('orders.create', compact('cartItems', 'total'));
    }

    public function store(Request $request)
{
    // Use the CartController's method to get user-specific cart
    $cartItems = app(CartController::class)->getUserCart();

    // Handle empty cart scenario
    if (empty($cartItems) && !$request->has('product_id')) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty');
    }

    // Handle cart checkout
    foreach ($cartItems as $productId => $item) {
        $product = Product::find($productId);
        if (!$product || $product->stock < $item['quantity']) {
            return redirect()->route('cart.index')
                ->with('error', "{$product->name} doesn't have enough stock");
        }
    }

    // Create order
    $order = Order::create([
        'user_id' => auth()->id(),
        'total_amount' => array_reduce($cartItems, function($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0),
        'status' => 'pending'
    ]);

    // Create order items
    foreach ($cartItems as $productId => $item) {
        $order->items()->create([
            'product_id' => $productId,
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ]);

        Product::find($productId)->decrement('stock', $item['quantity']);
    }

    // Clear cart using controller method
    app(CartController::class)->clearCart();

    return redirect()->route('orders.show', $order)
        ->with('success', 'Order placed successfully!');
}


    public function show(Order $order)
    {
        return view('orders.show', [
            'order' => $order->load(['items.product', 'reviews'])
        ]);
    }


    // Add this method to your OrderController

}
