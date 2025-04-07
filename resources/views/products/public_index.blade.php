@extends('layouts.app')

@section('content')
<div class="container shp-container py-5">
    <!-- Search Form -->
    <div class="search-form my-4">
        <form action="{{ route('products.public_index') }}" method="GET" class="row g-3 align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Search products..."
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('products.public_index', request()->except(['search'])) }}"
                           class="btn btn-outline-secondary">
                            Clear
                        </a>
                    @endif
                </div>
            </div>

            @if(request('min_price'))
                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
            @endif
            @if(request('max_price'))
                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
            @endif
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
        </form>
    </div>

    <div class="shp-header text-center mb-5">
        <h1 class="shp-title display-4 fw-bold">SOAP HAVEN</h1>
        <p class="shp-subtitle lead">Luxurious, Handcrafted Soaps for Discerning Tastes</p>

        <!-- Price Filter -->
        <div class="price-filter my-4">
            <form action="{{ route('products.public_index') }}" method="GET" class="row g-3 align-items-center justify-content-center">
                <div class="col-auto">
                    <label for="min_price" class="col-form-label">Min Price</label>
                </div>
                <div class="col-auto">
                    <input type="number"
                           name="min_price"
                           id="min_price"
                           class="form-control"
                           placeholder="$0"
                           value="{{ request('min_price') }}"
                           min="0">
                </div>

                <div class="col-auto">
                    <label for="max_price" class="col-form-label">Max Price</label>
                </div>
                <div class="col-auto">
                    <input type="number"
                           name="max_price"
                           id="max_price"
                           class="form-control"
                           placeholder="$100"
                           value="{{ request('max_price') }}"
                           min="0">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if(request('min_price') || request('max_price'))
                        <a href="{{ route('products.public_index', request()->except(['min_price', 'max_price'])) }}"
                           class="btn btn-outline-secondary ms-2">
                            Clear
                        </a>
                    @endif
                </div>

                @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
            </form>
        </div>

        <!-- Category Filter Buttons -->
        <div class="category-filters my-4">
            <button class="btn btn-category active" data-category="all">All Products</button>
            @foreach($categories as $category)
                <button class="btn btn-category" data-category="{{ $category->id }}">
                    {{ $category->description }}
                </button>
            @endforeach
        </div>

        <div class="shp-divider mx-auto"></div>
    </div>

    <div class="row g-4" id="products-container">
        @foreach($products as $product)
        <div class="col-lg-4 col-md-6 product-card"
             data-category="{{ $product->category_id ?? 'uncategorized' }}">
            <div class="card shp-product-card h-100 border-0 shadow-sm">
                <!-- Image Carousel -->
                <div class="shp-product-image-container">
                    @if($product->images->isNotEmpty())
                        <div class="shp-product-image-scroller">
                            @foreach($product->images as $image)
                                <div class="shp-product-image-wrapper">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         class="shp-product-image"
                                         alt="{{ $product->name }}"
                                         loading="lazy">
                                </div>
                            @endforeach
                        </div>
                        <div class="shp-image-indicators">
                            @foreach($product->images as $index => $image)
                                <button class="shp-image-indicator" data-index="{{ $index }}"></button>
                            @endforeach
                        </div>
                    @else
                        <div class="shp-product-image-placeholder">
                            <i class="fas fa-soap fa-4x"></i>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none product-details-link">
                    <div class="card-body shp-product-body text-center">
                        <h3 class="shp-product-title h5 mb-2">{{ $product->name }}</h3>
                        @if($product->category)
                            <span class="badge rounded-pill mb-2"
                                  style="background-color: #e6e6fa; color: #9370db;">
                                {{ $product->category->description }}
                            </span>
                        @endif
                        <p class="shp-product-description card-text mb-3">{{ Str::limit($product->description, 100) }}</p>
                    </div>
                </a>

                <!-- Single Card Footer -->
                <div class="card-footer shp-product-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="shp-product-price h5 mb-0">${{ number_format($product->price, 2) }}</span>
                        <span class="shp-stock-badge shp-stock-{{ $product->stock > 0 ? 'in' : 'out' }}">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>

                    @if($product->stock > 0)
                    @auth
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
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
        </div>
        @endforeach
    </div>

    @if($products->hasPages())
    <div class="row mt-5">
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center flex-wrap">
                    {{ $products->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
        </div>
    </div>
    @endif
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category Filter Functionality
    const categoryButtons = document.querySelectorAll('.btn-category');
    const productCards = document.querySelectorAll('.product-card');

    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const categoryId = this.dataset.category;
            productCards.forEach(card => {
                if (categoryId === 'all' || card.dataset.category === categoryId) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });

    // Image Carousel Functionality (single implementation)
    document.querySelectorAll('.shp-product-image-container').forEach(container => {
        const scroller = container.querySelector('.shp-product-image-scroller');
        const indicators = container.querySelectorAll('.shp-image-indicator');
        const imageCount = indicators.length;

        if (imageCount > 1) {
            let currentIndex = 0;
            let autoScrollInterval;
            let isDragging = false;
            let startPos = 0;
            let currentTranslate = 0;
            let prevTranslate = 0;

            function updateSlider() {
                scroller.style.transform = `translateX(-${currentIndex * 100}%)`;
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentIndex);
                });
            }

            function startAutoScroll() {
                autoScrollInterval = setInterval(() => {
                    currentIndex = (currentIndex + 1) % imageCount;
                    updateSlider();
                }, 3000);
            }

            // Initialize
            updateSlider();
            startAutoScroll();

            // Indicator click handler
            indicators.forEach(indicator => {
                indicator.addEventListener('click', function(e) {
                    e.stopPropagation();
                    currentIndex = parseInt(this.getAttribute('data-index'));
                    updateSlider();
                    clearInterval(autoScrollInterval);
                    startAutoScroll();
                });
            });

            // Touch events
            container.addEventListener('touchstart', touchStart, { passive: true });
            container.addEventListener('touchend', touchEnd, { passive: true });
            container.addEventListener('touchmove', touchMove, { passive: true });

            // Mouse events
            container.addEventListener('mousedown', mouseDown);
            container.addEventListener('mouseup', mouseUp);
            container.addEventListener('mouseleave', mouseLeave);
            container.addEventListener('mousemove', mouseMove);

            // Hover events
            container.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
            container.addEventListener('mouseleave', () => {
                if (!isDragging) startAutoScroll();
            });

            function touchStart(e) {
                startPos = e.touches[0].clientX;
                prevTranslate = currentIndex * -100;
                clearInterval(autoScrollInterval);
            }

            function touchMove(e) {
                const currentPos = e.touches[0].clientX;
                currentTranslate = prevTranslate + (currentPos - startPos) / container.offsetWidth * 100;
                scroller.style.transform = `translateX(${currentTranslate}%)`;
                scroller.style.transition = 'none';
            }

            function touchEnd() {
                const movedBy = currentTranslate - prevTranslate;
                if (movedBy < -20 && currentIndex < imageCount - 1) currentIndex++;
                else if (movedBy > 20 && currentIndex > 0) currentIndex--;

                updateSlider();
                scroller.style.transition = 'transform 0.5s ease';
                startAutoScroll();
            }

            function mouseDown(e) {
                isDragging = true;
                startPos = e.clientX;
                prevTranslate = currentIndex * -100;
                clearInterval(autoScrollInterval);
                container.style.cursor = 'grabbing';
            }

            function mouseMove(e) {
                if (!isDragging) return;
                const currentPos = e.clientX;
                currentTranslate = prevTranslate + (currentPos - startPos) / container.offsetWidth * 100;
                scroller.style.transform = `translateX(${currentTranslate}%)`;
                scroller.style.transition = 'none';
            }

            function mouseUp() {
                if (!isDragging) return;
                isDragging = false;

                const movedBy = currentTranslate - prevTranslate;
                if (movedBy < -20 && currentIndex < imageCount - 1) currentIndex++;
                else if (movedBy > 20 && currentIndex > 0) currentIndex--;

                updateSlider();
                scroller.style.transition = 'transform 0.5s ease';
                container.style.cursor = 'grab';
                startAutoScroll();
            }

            function mouseLeave() {
                if (isDragging) {
                    isDragging = false;
                    updateSlider();
                    scroller.style.transition = 'transform 0.5s ease';
                    container.style.cursor = 'grab';
                    startAutoScroll();
                }
            }
        }
    });
});
</script>

<style>
    .category-filters {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
        margin: 1.5rem 0;
    }


    .btn-category {
        background-color: #f8f5ff;
        color: #9370db;
        border: 1px solid #e6e6fa;
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-category:hover,
    .btn-category.active {
        background-color: #9370db;
        color: white;
        border-color: #9370db;
    }

    .product-card {
        transition: all 0.4s ease;
    }

    .product-card.hidden {
        opacity: 0;
        transform: scale(0.95);
        height: 0;
        padding: 0;
        margin: 0;
        border: none;
    }

    .shp-container {
        background-color: #fff;
        padding: 3rem 0;
    }

    .shp-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .shp-title {
        color: #9370db;
        font-size: 2.5rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .shp-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        font-weight: 300;
    }

    .shp-divider {
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #e6e6fa, #d8bfd8, #e6e6fa);
        margin: 1.5rem auto;
    }

    .shp-product-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-radius: 12px;
        overflow: hidden;
        border: none;
        margin-bottom: 1.5rem;
        height: 100%;
    }

    .shp-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(147, 112, 219, 0.15);
    }

    .shp-product-image-container {
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .shp-product-image-scroller {
        display: flex;
        height: 100%;
        transition: transform 0.5s ease;
        will-change: transform;
    }

    .shp-product-image-wrapper {
        min-width: 100%;
        position: relative;
    }

    .shp-product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .shp-image-indicators {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 8px;
        z-index: 10;
    }

    .shp-image-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255,255,255,0.5);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .shp-image-indicator.active {
        background-color: #9370db;
        transform: scale(1.2);
    }

    .shp-product-image-placeholder {
        height: 100%;
        background-color: #f8f5ff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-details-link {
        color: inherit;
    }

    .product-details-link:hover {
        text-decoration: none;
    }

    .shp-product-body {
        padding: 1.5rem;
        text-align: center;
    }

    .shp-product-title {
        color: #343a40;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .shp-product-description {
        color: #6c757d;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .shp-product-footer {
        background: transparent;
        border: none;
        padding: 0 1.5rem 1.5rem;
    }

    .shp-product-price {
        color: #9370db;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .shp-stock-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .shp-stock-in {
        background-color: #e6e6fa;
        color: #9370db;
    }

    .shp-stock-out {
        background-color: #f8f9fa;
        color: #6c757d;
    }
</style>
@endsection
