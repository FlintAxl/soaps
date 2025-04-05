@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Your Shopping Cart</h1>

    @if(count($cartItems) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                    <div class="ms-3">
                                        <h5>{{ $item['name'] }}</h5>
                                    </div>
                                </div>
                            </td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item['product_id']) }}" method="POST">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary mt-2">Update</button>
                                </form>
                            </td>
                            <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['product_id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <a href="{{ route('products.public_index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
            </div>
            <div class="col-md-6 text-end">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cart Total</h5>
                        <p class="card-text">${{ number_format($total, 2) }}</p>
                        <a href="{{ route('orders.create') }}" class="btn btn-primary">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('products.public_index') }}">Start shopping</a>
        </div>
    @endif
</div>
@endsection
