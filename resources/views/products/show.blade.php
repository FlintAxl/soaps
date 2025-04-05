@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('products.public.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>
    <div class="row">
        <div class="col-md-6">
            @if($product->images->isNotEmpty())
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                     class="img-fluid rounded-3"
                     alt="{{ $product->name }}">
            @endif
        </div>
        <div class="col-md-6">
            <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
            <div class="rating mb-3">
                @for($i = 1; $i <= 5; $i++)
                    <i class="{{ $i <= $product->average_rating ? 'fas' : 'far' }} fa-star text-warning"></i>
                @endfor
                <span class="ms-2 text-muted">({{ $product->reviews->count() }} reviews)</span>
            </div>
            <p class="lead">{{ $product->description }}</p>
            <div class="d-flex align-items-center gap-3 mb-4">
                <h3 class="text-primary">${{ number_format($product->price, 2) }}</h3>
                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>

            @if($product->stock > 0)
                @auth
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <input type="number"
                                   name="quantity"
                                   value="1"
                                   min="1"
                                   max="{{ $product->stock }}"
                                   class="form-control quantity-input"
                                   style="width: 70px;"
                                   aria-label="Quantity">
                            <button type="submit" class="btn btn-primary add-to-cart-btn">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                        @if($product->stock < 10)
                            <small class="text-warning d-block mt-1">
                                Only {{ $product->stock }} left in stock!
                            </small>
                        @endif
                    </form>
                @else
                    <div class="mt-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 login-prompt">
                            <i class="fas fa-sign-in-alt"></i> Login to Purchase
                        </a>
                    </div>
                @endauth
            @else
                <button class="btn btn-outline-secondary mt-3 w-100" disabled>
                    <i class="fas fa-times-circle"></i> Out of Stock
                </button>
            @endif
        </div>
    </div>

    <!-- Reviews Section (Keep existing reviews code) -->
    <div class="mt-5">
        <!-- Existing reviews code here -->
    </div>
</div>
@endsection
