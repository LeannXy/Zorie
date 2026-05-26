<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use Livewire\Volt\Volt;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\CategoryController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {


    Route::view('/dashboard', 'pages.dashboard.dashboard')
        ->name('dashboard');

    Route::get('/products', [ProductController::class, 'index'])
        ->name('products');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.delete');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    Route::view('/categories', 'pages.categories')
        ->name('categories');

    Route::view('/customers', 'pages.customers')
        ->name('customers');

    Route::view('/orders', 'pages.orders')
        ->name('orders');

    // Route::view('/settings', 'pages.settings')
    //     ->name('settings');

    Route::view('/analytics', 'pages.analytics')
        ->name('analytics');

    Route::get('/products/search', [ProductController::class, 'search']);
    Route::get(
        '/search',
        [SearchController::class, 'index']
    )->name(
        'search'
    );

    Route::post(
        '/products/bulk-delete',
        [ProductController::class, 'bulkDelete']
    )->name(
        'products.bulkDelete'
    );

    Route::get(
        '/products/export',
        [ProductController::class, 'export']
    )->name(
        'products.export'
    );




    Route::get(
        '/categories',
        [CategoryController::class, 'index']
    )->name('categories');

    Route::post(
        '/categories',
        [CategoryController::class, 'store']
    )->name('categories.store');

    Route::put(
        '/categories/{category}',
        [CategoryController::class, 'update']
    )->name('categories.update');

    Route::delete(
        '/categories/{category}',
        [CategoryController::class, 'destroy']
    )->name('categories.delete');
    Route::get(
        '/categories/check',
        [CategoryController::class, 'check']
    );
    Route::patch(
        '/categories/{category}/toggle-status',
        [CategoryController::class, 'toggleStatus']
    )->name(
        'categories.toggleStatus'
    );

    Route::patch(
        '/categories/{category}/toggle-featured',
        [CategoryController::class, 'toggleFeatured']
    )->name(
        'categories.toggleFeatured'
    );
    Route::post(
        '/categories/bulk-delete',
        [CategoryController::class, 'bulkDelete']
    );
    Route::post(
        '/categories/bulk-update',
        [CategoryController::class, 'bulkUpdate']
    );
    Route::get(
        '/categories/export',
        [CategoryController::class, 'export']
    )->name(
        'categories.export'
    );



    // Route::get(
    //     '/orders',
    //     [OrderController::class, 'index']
    // )->name(
    //     'orders'
    // );
    // Route::patch(
    //     '/orders/{order}/status',
    //     [OrderController::class, 'updateStatus']
    // )->name(
    //     'orders.status'
    // );
    // Route::post(
    //     '/orders/bulk-update',
    //     [OrderController::class, 'bulkUpdate']
    // )->name(
    //     'orders.bulkUpdate'
    // );
    // Route::post(
    //     '/orders/bulk-delete',
    //     [OrderController::class, 'bulkDelete']
    // )->name(
    //     'orders.bulkDelete'
    // );
    // Route::get(
    //     '/orders/{order}',
    //     [OrderController::class, 'show']
    // )->name(
    //     'orders.show'
    // );
    // Route::get(
    //     '/orders/export',
    //     [OrderController::class, 'export']
    // )->name(
    //     'orders.export'
    // );
    Route::get(
        '/orders',
        [OrderController::class, 'index']
    )->name('orders');


    Route::get(
        '/orders/export',
        [OrderController::class, 'export']
    )->name('orders.export');


    Route::post(
        '/orders/bulk-update',
        [OrderController::class, 'bulkUpdate']
    )->name('orders.bulkUpdate');


    Route::post(
        '/orders/bulk-delete',
        [OrderController::class, 'bulkDelete']
    )->name('orders.bulkDelete');


    Route::patch(
        '/orders/{order}/status',
        [OrderController::class, 'updateStatus']
    )->name('orders.status');


    Route::get(
        '/orders/{order}',
        [OrderController::class, 'show']
    )->name('orders.show');

    Route::delete(

        '/orders/{order}',

        [OrderController::class, 'destroy']

    )->name(
        'orders.destroy'
    );



    Route::get(
        '/testimonials',
        [TestimonialController::class, 'index']
    )->name(
        'testimonials'
    );

    Route::patch(
        '/testimonials/{testimonial}/status',
        [TestimonialController::class, 'updateStatus']
    )->name(
        'testimonials.status'
    );

    Route::delete(
        '/testimonials/{testimonial}',
        [TestimonialController::class, 'destroy']
    )->name(
        'testimonials.destroy'
    );
    Route::delete(
        '/testimonials/{testimonial}',
        [TestimonialController::class, 'destroy']
    )->name(
        'testimonials.delete'
    );



    Route::get(
        '/customers',
        [CustomerController::class, 'index']
    )->name(
        'customers'
    );

    Route::patch(
        '/customers/{customer}/status',
        [CustomerController::class, 'updateStatus']
    )->name(
        'customers.status'
    );

    Route::patch(
        '/customers/{customer}/profile',
        [CustomerController::class, 'updateProfile']
    )->name(
        'customers.profile'
    );

    Route::get(
        '/customers/export',
        [CustomerController::class, 'export']
    )->name(
        'customers.export'
    );




    Route::get(
        '/analytics',
        [AnalyticsController::class, 'index']
    )->name(
        'analytics'
    );


    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->middleware([
        'auth',
        'verified'
    ])->name(
        'dashboard'
    );

    Route::get(
        '/dashboard/export',
        [DashboardController::class, 'export']
    )->name(
        'dashboard.export'
    );
});








require __DIR__ . '/settings.php';
