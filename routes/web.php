<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController; // Added this
use App\Http\Controllers\ReviewController; // Added this
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;
use App\Models\Product; // Add this at the top
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| These are the routes for your application.
| They are loaded by the RouteServiceProvider within a group that
| contains the "web" middleware group.
|--------------------------------------------------------------------------
*/

// User Management Routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::put('/users/{user}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');
Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Product Routes for users
Route::get('/products-list', [ProductController::class, 'publicIndex'])->name('products.public.index');



// Product Resource Routes (admin)
Route::resource('products', ProductController::class)->except(['show']); // Exclude show if using custom one
Route::get('products/restore/{id}', [ProductController::class, 'restore'])->name('products.restore');

// Public product show route (place before resource if not excluded)
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Import Routes excel
Route::get('/import', [ImportController::class, 'show'])->name('import.show');
Route::post('/import', [ImportController::class, 'store'])->name('import.store');

// Orders
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');
Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])
    ->name('orders.cancel')
    ->middleware('auth');
Route::put('/orders/{order}/receive', [OrderController::class, 'receive'])
->name('orders.receive')
->middleware('auth');


// Reviews
Route::get('/orders/{order}/reviews/{product}/create', [ReviewController::class, 'create'])
    ->name('reviews.create')->middleware('auth');
Route::post('/orders/{order}/reviews/{product}', [ReviewController::class, 'store'])
    ->name('reviews.store')->middleware('auth');

// Reviews update routes

Route::get('/orders/{order}/reviews/{product}/{review}/edit', [ReviewController::class, 'edit'])
    ->name('reviews.edit')
    ->middleware('auth')
    ->where([
        'order' => '\d+',
        'product' => '\d+',
        'review' => '\d+'
    ]);

// Add this new route for update
Route::put('/orders/{order}/reviews/{product}/{review}', [ReviewController::class, 'update'])
    ->name('reviews.update')
    ->middleware('auth')
    ->where([
        'order' => '\d+',
        'product' => '\d+',
        'review' => '\d+'
    ]);

// Admin Review Management
Route::get('/admin/reviews', [ReviewController::class, 'adminIndex'])
    ->name('admin.reviews.index')
    ->middleware(['auth', 'can:admin']);

Route::delete('/admin/reviews/{review}', [ReviewController::class, 'adminDestroy'])
    ->name('admin.reviews.destroy')
    ->middleware(['auth', 'can:admin']);



 Route::middleware('auth')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

// Landing Page
Route::get('/', function () {
    $products = Product::all(); // Fetch all products
    return view('products.public_index', ['products' => $products]); // Pass to view
});
Route::get('/', [ProductController::class, 'publicIndex'])->name('home');
// or if you want to keep it as publicIndex:
Route::get('/', [ProductController::class, 'publicIndex'])->name('products.public_index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware(['auth', 'can:admin']);






// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

// Profile routes
Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');


// Admin Order Management
Route::prefix('admin')->middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{order}/update-status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
});


Route::prefix('admin')->group(function () {

    Route::get('/reports/sales', [ReportController::class, 'salesReports'])->name('admin.reports.sales');
    Route::post('/reports/sales-data', [ReportController::class, 'getSalesData'])->name('admin.reports.sales-data');
});

Route::get('/download-receipt/{order}', function (\App\Models\Order $order) {
    $path = storage_path('app/public/pdfs/Order_' . $order->id . '.pdf');
    if (!file_exists($path)) abort(404);
    return response()->download($path);
})->name('download.receipt');
