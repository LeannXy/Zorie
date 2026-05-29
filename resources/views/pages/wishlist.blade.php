@extends('layouts.app')

@section('content')

    @include('pages.home.sections.navbar')

    <div class="min-h-screen bg-gray-50 pt-32 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header with Back Button -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">My Wishlist</h1>
                    <p class="text-gray-600 mt-2">{{ count($wishlistItems) }} item(s) in your wishlist</p>
                </div>
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Awal
                </a>
            </div>

            @if(count($wishlistItems) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($wishlistItems as $product)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                            <!-- Product Image -->
                            <div class="relative h-48 bg-gray-200 overflow-hidden">
                                @if($product->productImages->count() > 0)
                                    <img src="{{ asset('storage/' . $product->productImages->first()->image_url) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover hover:scale-110 transition">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif

                                <!-- Remove Button -->
                                <button onclick="removeFromWishlist({{ $product->id }})"
                                        class="absolute top-2 right-2 bg-white rounded-full p-2 shadow hover:bg-red-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mt-1 line-clamp-2">{{ $product->description }}</p>
                                
                                <p class="text-gray-900 font-bold text-lg mt-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                                <!-- Stock Status -->
                                @if($product->stock > 0)
                                    <p class="text-gray-900 text-sm font-semibold mt-2">In Stock</p>
                                @else
                                    <p class="text-gray-600 text-sm font-semibold mt-2">Out of Stock</p>
                                @endif

                                <!-- Add to Cart Button -->
                                @if($product->stock > 0)
                                    <button onclick="addToCart({{ $product->id }})"
                                            class="w-full mt-4 bg-black text-white py-2 rounded font-semibold hover:bg-gray-800 transition">
                                        Add to Cart
                                    </button>
                                @else
                                    <button disabled class="w-full mt-4 bg-gray-300 text-gray-600 py-2 rounded font-semibold cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Your wishlist is empty</h2>
                    <p class="text-gray-600 mb-6">Start adding items to your wishlist</p>
                    <a href="{{ route('home') }}" class="inline-block bg-black text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>

    @include('pages.home.sections.footer')

    <script>
        function removeFromWishlist(productId) {
            fetch(`/wishlist/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function addToCart(productId) {
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product added to cart!');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

@endsection
