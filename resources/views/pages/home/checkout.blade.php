@extends('layouts.app')

@section('content')

    @include('pages.home.sections.navbar')

    <div class="min-h-screen bg-white pt-32 pb-12">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb with Back Button -->
            <div class="mb-8 flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600">Checkout</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Cart Items and Checkout Form -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Cart Items Section -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Cart Items</h2>

                    @if(count($cartItems) > 0)
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="border border-gray-200 rounded-lg p-4 flex gap-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item['product']->productImages->count() > 0)
                                            <img src="{{ asset('storage/' . $item['product']->productImages->first()->image_url) }}" 
                                                 alt="{{ $item['product']->name }}" 
                                                 class="h-24 w-24 object-cover rounded">
                                        @else
                                            <div class="h-24 w-24 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-400 text-xs text-center">No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-grow">
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $item['product']->name }}</h3>
                                        <p class="text-xs text-gray-600 mt-1">Sku: XXS</p>
                                        <p class="text-xs text-gray-600">Color: {{ $item['product']->category->name ?? 'Standard' }}</p>
                                        
                                        <!-- Quantity Selector -->
                                        <div class="flex items-center gap-3 mt-3">
                                            <button onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] - 1 }})" 
                                                    class="w-6 h-6 flex items-center justify-center border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm">−</button>
                                            <span class="text-sm font-medium">{{ $item['quantity'] }}</span>
                                            <button onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] + 1 }})" 
                                                    class="w-6 h-6 flex items-center justify-center border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm">+</button>
                                        </div>
                                    </div>

                                    <!-- Price and Remove -->
                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                                        <button onclick="removeFromCart({{ $item['product']->id }})" 
                                                class="text-xs text-red-600 hover:text-red-800 font-semibold mt-2">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 border border-gray-200 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="text-gray-900 font-semibold mb-2">Your cart is empty</h3>
                            <p class="text-gray-600 text-sm mb-4">Start shopping to add items to your cart</p>
                            <a href="{{ route('home') }}" class="inline-block text-gray-900 hover:text-gray-700 font-semibold">
                                Continue Shopping
                            </a>
                        </div>
                    @endif
                    </div>

                    <!-- Delivery Method Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Delivery Method</h3>
                        <div class="space-y-3">
                            <label class="border border-gray-300 rounded-lg p-4 flex items-center cursor-pointer hover:bg-gray-50 transition">
                                <input type="radio" name="delivery" value="standard" checked class="w-4 h-4 text-black">
                                <span class="ml-3 text-sm text-gray-700">
                                    <span class="font-semibold">Standard delivery (5-6 days)</span>
                                    <span class="text-gray-600 ml-2">FREE</span>
                                </span>
                            </label>
                            <label class="border border-gray-300 rounded-lg p-4 flex items-center cursor-pointer hover:bg-gray-50 transition">
                                <input type="radio" name="delivery" value="express" class="w-4 h-4 text-black">
                                <span class="ml-3 text-sm text-gray-700">
                                    <span class="font-semibold">Express delivery (1-2 days)</span>
                                    <span class="text-gray-600 ml-2">$10</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Shipping Information Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Shipping Information</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" placeholder="Country" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                                <input type="text" placeholder="City" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" placeholder="Address" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                                <input type="text" placeholder="Postal code" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Method</h3>
                        <div class="space-y-3">
                            <!-- Visa -->
                            <label class="border border-gray-300 rounded-lg p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition">
                                <div class="flex items-center">
                                    <input type="radio" name="payment" value="visa" checked class="w-4 h-4 text-black">
                                    <span class="ml-3 text-sm font-semibold text-gray-700">Visa</span>
                                </div>
                                <svg class="w-8 h-5" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="32" rx="4" fill="#1434CB"/>
                                    <text x="24" y="20" text-anchor="middle" fill="white" font-size="12" font-weight="bold">VISA</text>
                                </svg>
                            </label>

                            <!-- Mastercard -->
                            <label class="border border-gray-300 rounded-lg p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition">
                                <div class="flex items-center">
                                    <input type="radio" name="payment" value="mastercard" class="w-4 h-4 text-black">
                                    <span class="ml-3 text-sm font-semibold text-gray-700">Mastercard</span>
                                </div>
                                <svg class="w-8 h-5" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="32" rx="4" fill="#EB001B"/>
                                    <circle cx="20" cy="16" r="8" fill="#FF5F00"/>
                                    <circle cx="28" cy="16" r="8" fill="#FFB81C"/>
                                </svg>
                            </label>

                            <!-- Google Pay -->
                            <label class="border border-gray-300 rounded-lg p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition">
                                <div class="flex items-center">
                                    <input type="radio" name="payment" value="googlepay" class="w-4 h-4 text-black">
                                    <span class="ml-3 text-sm font-semibold text-gray-700">Google Pay</span>
                                </div>
                                <div class="text-xs font-bold text-gray-500">G Pay</div>
                            </label>

                            <!-- PayPal -->
                            <label class="border border-gray-300 rounded-lg p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition">
                                <div class="flex items-center">
                                    <input type="radio" name="payment" value="paypal" class="w-4 h-4 text-black">
                                    <span class="ml-3 text-sm font-semibold text-gray-700">PayPal</span>
                                </div>
                                <div class="text-xs font-bold text-blue-600">PP</div>
                            </label>
                        </div>

                        <!-- Card Details (Shown when Visa is selected) -->
                        <div id="cardDetails" class="mt-4 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" placeholder="Card number" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 col-span-2">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" placeholder="Expiry date (MM/YY)" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                                <input type="text" placeholder="CVV" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                            </div>
                            <input type="text" placeholder="Cardholder full name" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 w-full">
                        </div>

                        <!-- Log In Link -->
                        <p class="text-xs text-gray-600 mt-4">
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Log In</a>
                            <span> to save card information for next orders</span>
                        </p>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="border border-gray-200 rounded-lg p-6 sticky top-32">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>

                        <!-- Product Items in Summary -->
                        <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                            @foreach($cartItems as $item)
                                <div class="flex gap-3">
                                    @if($item['product']->productImages->count() > 0)
                                        <img src="{{ asset('storage/' . $item['product']->productImages->first()->image_url) }}" 
                                             alt="{{ $item['product']->name }}" 
                                             class="h-16 w-16 object-cover rounded">
                                    @else
                                        <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    @endif
                                    <div class="flex-grow">
                                        <p class="text-sm font-semibold text-gray-900">{{ $item['product']->name }}</p>
                                        <p class="text-xs text-gray-600">Sku: XXS</p>
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-xs text-gray-600">Qty: {{ $item['quantity'] }}</span>
                                            <span class="font-semibold text-gray-900">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary Calculations -->
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Discount</span>
                                <span>-Rp 0</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Delivery</span>
                                <span class="text-gray-900 font-semibold">FREE</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between text-lg font-bold text-gray-900">
                                <span>Total to pay</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <button class="w-full mt-6 bg-black hover:bg-gray-800 text-white py-3 rounded-lg font-semibold transition">
                            Pay Now
                        </button>

                        <!-- Terms -->
                        <p class="text-xs text-gray-600 text-center mt-4">
                            By proceeding I accept the <a href="#" class="text-gray-900 hover:text-gray-700 underline">Terms & Conditions</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.home.sections.footer')

    <script>
        // Payment method visibility control
        const paymentRadios = document.querySelectorAll('input[name="payment"]');
        const cardDetails = document.getElementById('cardDetails');

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.value === 'visa' || radio.value === 'mastercard') {
                    cardDetails.style.display = 'block';
                } else {
                    cardDetails.style.display = 'none';
                }
            });
        });

        // Initialize card details visibility
        if (document.querySelector('input[name="payment"]:checked').value !== 'visa' && 
            document.querySelector('input[name="payment"]:checked').value !== 'mastercard') {
            cardDetails.style.display = 'none';
        }

        function updateQuantity(productId, newQuantity) {
            if (newQuantity <= 0) {
                removeFromCart(productId);
                return;
            }

            fetch(`/cart/update/${productId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function removeFromCart(productId) {
            fetch(`/cart/remove/${productId}`, {
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
    </script>

@endsection
