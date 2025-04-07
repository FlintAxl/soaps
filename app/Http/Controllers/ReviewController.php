<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ReviewController extends Controller
{
    public function create(Order $order, Product $product)
    {
        // Verify the user purchased this product in this order
        if (!$order->items()->where('product_id', $product->id)->exists()) {
            abort(403, 'You did not purchase this product');
        }

        // Check if review already exists
        if ($order->reviews()->where('product_id', $product->id)->exists()) {
            return redirect()->back()->with('error', 'You already reviewed this product');
        }

        return view('reviews.create', compact('order', 'product'));
    }

    public function store(Request $request, Order $order, Product $product)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5'
        ]);

        // Verify the user purchased this product
        if (!$order->items()->where('product_id', $product->id)->exists()) {
            abort(403, 'You did not purchase this product');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
            'comment' => $request->comment,
            'rating' => $request->rating
        ]);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Review submitted successfully!');
    }

    public function edit(Order $order, Product $product, Review $review)
    {
        // Verify the user is the owner of this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to edit this review');
        }

        // Verify the review belongs to this order and product
        if ($review->order_id !== $order->id || $review->product_id !== $product->id) {
            abort(404);
        }

        return view('reviews.edit', compact('order', 'product', 'review'));
    }

    public function update(Request $request, Order $order, Product $product, Review $review)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5'
        ]);

        // Verify the user is the owner of this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to update this review');
        }

        // Verify the review belongs to this order and product
        if ($review->order_id !== $order->id || $review->product_id !== $product->id) {
            abort(404);
        }

        $review->update([
            'comment' => $request->comment,
            'rating' => $request->rating
        ]);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Review updated successfully!');
    }

    public function adminIndex(Request $request)
    {
        if ($request->ajax()) {
            $reviews = Review::with(['user', 'product', 'order'])
                ->select('reviews.*')
                ->latest();

            return DataTables::of($reviews)
                ->addColumn('user_name', function ($review) {
                    return optional($review->user)->name ?? 'Deleted User';
                })
                ->addColumn('product_name', function ($review) {
                    return optional($review->product)->name ?? 'Deleted Product';
                })
                ->addColumn('order_id', function ($review) {
                    return optional($review->order)->id ?? 'N/A';
                })
                ->addColumn('action', function ($review) {
                    return '<button class="btn btn-danger btn-sm delete-review" data-id="'.$review->id.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.reviews.index');
    }

    public function adminDestroy(Review $review)
    {
        try {
            $review->delete();

            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review: ' . $e->getMessage()
            ], 500);
        }
    }
}
