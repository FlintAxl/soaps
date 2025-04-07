    @extends('layouts.app')

    @section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-4">Checkout</h2>

                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item['image'])
                                                    <img src="{{ asset('storage/'.$item['image']) }}"
                                                        class="img-thumbnail me-3"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                @endif
                                                {{ $item['name'] }}
                                            </div>
                                        </td>
                                        <td>${{ number_format($item['price'], 2) }}</td>
                                        <td>{{ $item['quantity'] }}</td>
                                        <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping:</span>
                            <span>$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                            <span>Total:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>

                        <form action="{{ route('orders.store') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-check-circle me-2"></i> Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
