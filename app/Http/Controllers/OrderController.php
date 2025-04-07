<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderCancelled;
use App\Mail\OrderReceived;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function receive(Order $order)
    {
        // Authorization - only order owner can receive
        if ($order->user_id != auth()->id()) {
            abort(403);
        }

        return DB::transaction(function () use ($order) {
            if ($order->status == 'shipping') {
                $order->update(['status' => 'completed']);

                try {
                    Mail::to(auth()->user()->email)  // Changed to use auth()->user()
                        ->send(new OrderReceived($order));

                    \Log::info("Order received email sent for #{$order->id}");
                } catch (\Exception $e) {
                    \Log::error("Order received email failed: ".$e->getMessage());
                    // Continue despite email failure
                }

                return back()->with('success', 'Order marked as received');
            }

            return back()->with('error', 'Only shipping orders can be marked as received');
        });
    }

    public function cancel(Order $order)
    {
        // Authorization
        if ($order->user_id != auth()->id()) {
            abort(403);
        }

        return DB::transaction(function () use ($order) {
            if ($order->status == 'pending') {
                $order->update(['status' => 'cancelled']);

                try {
                    Mail::to(auth()->user()->email)  // Changed to use auth()->user()

                        ->send(new OrderCancelled($order));

                    \Log::info("Order cancelled email sent for #{$order->id}");
                } catch (\Exception $e) {
                    \Log::error("Order cancelled email failed: ".$e->getMessage());
                    // Continue despite email failure
                }

                return back()->with('success', 'Order cancelled');
            }

            return back()->with('error', 'Only pending orders can be cancelled');
        });
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
        // Start database transaction
        return DB::transaction(function () use ($request) {
            // Get user cart
            $cartItems = app(CartController::class)->getUserCart();

            // Validate cart
            if (empty($cartItems)) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty');
            }

            // Check stock availability
            foreach ($cartItems as $productId => $item) {
                $product = Product::findOrFail($productId);

                if ($product->stock < $item['quantity']) {
                    return redirect()->route('cart.index')
                        ->with('error', "Sorry, we only have {$product->stock} {$product->name} in stock");
                }
            }

            // Calculate total
            $total = array_reduce($cartItems, fn($total, $item) =>
                $total + ($item['price'] * $item['quantity']), 0);

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
                'tracking_number' => 'SH-' . strtoupper(uniqid()), // Generate tracking number
            ]);

            // Create order items and update stock
            foreach ($cartItems as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                Product::where('id', $productId)
                    ->decrement('stock', $item['quantity']);
            }

            // Clear cart
            app(CartController::class)->clearCart();

            try {
                // Send confirmation email with PDF
                Mail::to(auth()->user()->email)
                    ->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                // Log email error but don't fail the order
                \Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            return redirect()->route('orders.show', $order)
                ->with([
                    'success' => 'Order placed successfully!',
                    'order_id' => $order->id
                ]);
        });
    }


    public function show(Order $order)
    {
        return view('orders.show', [
            'order' => $order->load(['items.product', 'reviews'])
        ]);
    }




}
