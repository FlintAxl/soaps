<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Mail\OrderStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
                      ->latest()
                      ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,shipping,completed,cancelled',
            'admin_note' => 'nullable|string|max:500'
        ]);

        $previousStatus = $order->status;
        $newStatus = $request->status;

        $order->update(['status' => $newStatus]);

        // Only send email if status actually changed
        if ($previousStatus != $newStatus) {
            try {
                Mail::to($order->user->email)
                    ->send(new OrderStatusUpdated($order, $newStatus, $request->admin_note));
            } catch (\Exception $e) {
                \Log::error("Failed to send status update email for order #{$order->id}: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Order status updated successfully');
    }
}
