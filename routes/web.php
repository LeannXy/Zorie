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
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\AddressController;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CategoryBannerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicProductController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ReviewController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public all products route
Route::get(
    '/all-products',
    [PublicProductController::class, 'index']
)->name('all-products');
Route::get(
    '/product/{product}',
    [PublicProductController::class, 'show']
)->name('product.show');

// Public running route
Route::view('/running', 'pages.running')->name('running');
Route::view('/about', 'pages.home.about')->name('about');

// Public search route
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/products-search', [PublicProductController::class, 'search'])->name('products.search');

// Public cart and wishlist routes




// tampilkan cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// tambah ke cart
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');

// update qty
Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');

// hapus item
Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

// clear cart
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// hitung jumlah cart
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');
Route::post('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
Route::post(
    '/buy-now',
    [CheckoutController::class, 'buyNow']
)->name('buy-now');


// customer akun - Protected Routes (using session middleware)
Route::middleware(['CheckCustomerSession'])->group(function () {
    Route::get('/my-account/dashboard', [CustomerAccountController::class, 'dashboard'])->name('customer.account');

    Route::get('/my-account/profile', [
        CustomerController::class,
        'profile'
    ])->name('customer.profile');

    Route::get('/my-account/orders', [
        CustomerController::class,
        'orders'
    ])->name('customer.orders');

    Route::get('/my-account/wishlist', [
        CustomerController::class,
        'wishlist'
    ])->name('customer.wishlist');

    Route::get('/my-account/reviews', [
        CustomerController::class,
        'reviews'
    ])->name('customer.reviews');

    // Detail Transaksi & Success Page
    Route::get('/checkout/success/{order}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/orders/{order}/invoice', [App\Http\Controllers\CheckoutController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/check-ongkir', [App\Http\Controllers\CheckoutController::class, 'checkOngkir'])->name('check.ongkir');

    // Tambahan detail order di akun
    Route::get('/my-account/orders/{order}', [CustomerController::class, 'showOrder'])->name('customer.orders.show');

   Route::post(
    '/reviews/store',
    [ReviewController::class, 'store']
)->name('reviews.store');

    Route::get('/my-account/security', [
        CustomerController::class,
        'security'
    ])->name('customer.security');

    Route::get('/my-account/addresses', [
        AddressController::class,
        'index'
    ])->name('customer.addresses');
});

Route::post(
    '/customer/login',
    [CustomerAuthController::class, 'login']
)->name('customer.login.post');
Route::get(
    '/customer/login',
    [CustomerAuthController::class, 'showLogin']
)->name('customer.login');

Route::post(
    '/customer/register',
    [CustomerAuthController::class, 'register']
)->name('customer.register');

Route::post(
    '/customer/logout',
    [CustomerAuthController::class, 'logout']
)->name('customer.logout');

/////////////////
//forgot password
/////////////////
Route::view(
    '/forgot-password',
    'pages.home.forgotPassword'
)->name('customer.password.request');

Route::post(
    '/forgot-password',
    [CustomerAuthController::class, 'sendResetLink']
)->name('customer.password.email');

Route::post(
    '/forgot-password/send',
    [CustomerAuthController::class, 'sendOtp']
)->name('customer.password.send');

Route::post(
    '/forgot-password/reset',
    [CustomerAuthController::class, 'resetPassword']
)->name('customer.password.reset');

Route::post(
    '/forgot-password/verify',
    [CustomerAuthController::class, 'verifyOtp']
)->name('customer.password.verify');

// route step fogot pw
Route::get('/forgot-password/cancel', function () {

    session()->forget([
        'showOtpForm',
        'showPasswordForm',
        'reset_email'
    ]);

    return redirect()->route('customer.login');
})->name('customer.password.cancel');

////////////////
//login google
///////////////
Route::get(
    '/auth/google',
    [GoogleController::class, 'redirect']
)->name('google.login');

Route::get(
    '/auth/google/callback',
    [GoogleController::class, 'callback']
);

Route::get('/test-rajaongkir', function () {

    $response = Http::withHeaders([
        'key' => env('RAJAONGKIR_API_KEY')
    ])->get(
        'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination',
        [
            'search' => 'jepara'
        ]
    );

    dd(
        $response->status(),
        $response->headers(),
        $response->body()
    );
});

///////////////////
//cek id raja ongkir
///////////////////
Route::get('/test-city', function () {

    $response = Http::withHeaders([
        'key' => env('RAJAONGKIR_API_KEY')
    ])->get(
        'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination',
        [
            'search' => 'jepara'
        ]
    );

    dd($response->json());
});

Route::get('/cekkota', function () {

    $response = Http::withHeaders([
        'key' => env('RAJAONGKIR_API_KEY')
    ])->get(
        'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination',
        [
            'search' => '59452'
        ]
    );

    dd($response->json());

});
Route::get(
    '/search-city',
    [AddressController::class,'searchCity']
);
Route::get(
    '/search-postal-code',
    [AddressController::class, 'searchPostalCode']
)->name('search.postal.code');
///////////////////
//edit profil
//////////////////
Route::middleware(['CheckCustomerSession'])->group(function () {
    Route::post(
        '/my-account/profile',
        [CustomerAccountController::class, 'updateProfile']
    )->name('customer.profile.update');
    
    Route::post(
        '/customer/change-password',
        [CustomerAccountController::class, 'changePassword']
    )->name('customer.password.change');
    
    Route::post(
        '/customer/address',
        [AddressController::class, 'store']
    )->name('address.store');

    Route::delete(
        '/customer/address/{address}',
        [AddressController::class, 'destroy']
    )->name('address.destroy');

    Route::post(
        '/customer/address/default/{address}',
        [AddressController::class, 'setDefault']
    )->name('address.default');

    Route::put(
        '/customer/address/{address}',
        [AddressController::class, 'update']
    )->name('address.update');
    
    Route::post(
        '/customer/email/send-otp',
        [CustomerAuthController::class, 'sendEmailVerificationOtp']
    )->name('customer.email.send-otp');

    Route::post(
        '/customer/email/verify',
        [CustomerAuthController::class, 'verifyEmailOtp']
    )->name('customer.email.verify');
    
    Route::post(
        '/customer/email/send-old-otp',
        [CustomerAccountController::class, 'sendOldEmailOtp']
    )->name('customer.email.send-old-otp');

    Route::post(
        '/customer/email/verify-old-otp',
        [CustomerAccountController::class, 'verifyOldEmailOtp']
    )->name('customer.email.verify-old-otp');

    Route::post(
        '/customer/email/verify-new-email',
        [CustomerAccountController::class, 'sendNewEmailOtp']
    )->name('customer.email.send-new-otp');

    Route::post(
        '/customer/email/verify-new-otp',
        [CustomerAccountController::class, 'verifyNewEmailOtp']
    )->name('customer.email.verify-new-otp');

    Route::post(
        '/testimonials/store',
        [TestimonialController::class, 'storeFromCustomer']
    )->name('testimonials.store');

    Route::put(
        '/testimonials/{testimonial}',
        [TestimonialController::class, 'updateFromCustomer']
    )->name('testimonials.update');

    Route::delete(
        '/testimonials/{testimonial}',
        [TestimonialController::class, 'destroyFromCustomer']
    )->name('testimonials.destroy');
});


// Callback Midtrans harus tetap di luar middleware (Public)
Route::post('/midtrans/callback', [App\Http\Controllers\CheckoutController::class, 'callback'])->name('midtrans.callback');

///////////////////
//DASHBOARD
///////////////////
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/products', [ProductController::class, 'index'])
        ->name('products');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.delete');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    // Rute view dihapus karena sudah ditangani oleh Controller di bawah

    Route::get('/products/search', [ProductController::class, 'search']);
    Route::post(
        '/products/bulk-delete',
        [ProductController::class, 'bulkDelete']
    )->name(
        'products.bulkDelete'
    );
    Route::get(
        '/products/create',
        [ProductController::class, 'create']
    )->name('products.create');

    Route::get(
        '/products/{product}/edit',
        [ProductController::class, 'edit']
    )->name('products.edit');
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
    Route::get(
        '/categories/create',
        [CategoryController::class, 'create']
    )->name('categories.create');

    Route::get(
        '/categories/{category}/edit',
        [CategoryController::class, 'edit']
    )->name('categories.edit');

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
    Route::resource(
        'category-banners',
        CategoryBannerController::class
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

    Route::delete(
        '/customers/{customer}',
        [CustomerController::class, 'destroy']
    )->name('customers.destroy');

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
        '/dashboard/export',
        [DashboardController::class, 'export']
    )->name(
        'dashboard.export'
    );
});

require __DIR__ . '/settings.php';
