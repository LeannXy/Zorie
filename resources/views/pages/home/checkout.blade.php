@extends('layouts.app')

@section('content')

    @include('pages.home.sections.navbar')

    <div class="min-h-screen bg-white pt-8 pb-12">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb with Back Button -->
            <div class="mb-8 flex items-center gap-4">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-2 text-gray-600 hover:text-gray-900 font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600">Checkout</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Cart Items and Checkout Form -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Cart Items Section -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Item Keranjang</h2>

                        @if (count($cartItems) > 0)
                            <div class="space-y-4">
                                @foreach ($cartItems as $item)
                                    <div class="border border-gray-200 rounded-lg p-4 flex gap-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if ($item->product->images->count() > 0)
                                                <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                                                    alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded">
                                            @else
                                                <div class="h-24 w-24 bg-gray-200 rounded flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs text-center">Tidak Ada Gambar</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-grow">
                                            <h3 class="text-sm font-semibold text-gray-900">{{ $item->product->name }}
                                            </h3>
                                            <p class="text-xs text-gray-600 mt-1">
                                                Ukuran: {{ $item->size }}
                                            </p>
                                            <p class="text-xs text-gray-600">Warna:
                                                {{ $item->product->categories->first()?->name ?? 'Standard' }}</p>

                                            <!-- Quantity Selector -->
                                            <div class="flex items-center gap-3 mt-3">
                                                <button
                                                    onclick="updateQuantity({{ $item->product->id }}, {{ $item->qty - 1 }})"
                                                    class="w-6 h-6 flex items-center justify-center border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm">−</button>
                                                <span class="text-sm font-medium">{{ $item->qty }}</span>
                                                <button
                                                    onclick="updateQuantity({{ $item->product->id }}, {{ $item->qty + 1 }})"
                                                    class="w-6 h-6 flex items-center justify-center border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm">+</button>
                                            </div>
                                        </div>

                                        <!-- Price and Remove -->
                                        <div class="text-right">
                                            <p class="text-lg font-semibold text-gray-900">Rp
                                                {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                            <button onclick="removeFromCart({{ $item->product->id }})"
                                                class="text-xs text-red-600 hover:text-red-800 font-semibold mt-2">Hapus</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 border border-gray-200 rounded-lg">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <h3 class="text-gray-900 font-semibold mb-2">Keranjang Anda kosong</h3>
                                <p class="text-gray-600 text-sm mb-4">Mulai berbelanja untuk menambahkan item ke keranjang
                                    Anda</p>
                                <a href="{{ route('home') }}"
                                    class="inline-block text-gray-900 hover:text-gray-700 font-semibold">
                                    Lanjutkan Berbelanja
                                </a>
                            </div>
                        @endif
                    </div>


                    <!-- Shipping Information Section -->
                    <div>
                        @if ($errors->any())
                            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">

                                {{ $errors->first() }}

                            </div>
                        @endif
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="shipping_cost" id="shipping_input">
                            <input type="hidden" id="weight" value="{{ $totalWeight }}">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Pengiriman</h3>
                            <div class="space-y-4">


                                <div class="border rounded-xl p-4 bg-gray-50">

                                    <div class="flex justify-between">

                                        <h4 class="font-semibold">

                                            Alamat Pengiriman

                                        </h4>

                                        <a href="{{ route('customer.addresses') }}" class="text-blue-600 text-sm font-semibold">
                                            Ubah
                                        </a>

                                    </div>

                                    @if ($defaultAddress)
                                        <div class="mt-3">

                                            <p class="font-medium">

                                                {{ $defaultAddress->recipient_name }}

                                            </p>

                                            <p>

                                                {{ $defaultAddress->phone }}

                                            </p>

                                            <p>

                                                {{ $defaultAddress->address }}

                                            </p>

                                            <p>

                                                {{ $defaultAddress->district }},
                                                {{ $defaultAddress->city }},
                                                {{ $defaultAddress->province }}

                                            </p>

                                            <p>

                                                {{ $defaultAddress->postal_code }}

                                            </p>

                                        </div>
                                    @else
                                        <div class="text-red-500">

                                            Belum ada alamat utama

                                        </div>
                                    @endif

                                </div>
                            </div>
                    </div>

                    <!-- Payment Method Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Metode Pembayaran</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                            {{-- COD --}}
                            <label class="relative border rounded-xl p-4 flex items-center cursor-pointer hover:border-black transition-all group">
                                <input type="radio" name="payment" value="COD" checked class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                                <div class="ml-4 flex items-center justify-between w-full">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-none">COD</p>
                                        <p class="text-[11px] text-gray-500 mt-1">Bayar saat barang sampai</p>
                                    </div>
                                    <svg class="w-8 h-8 text-gray-400 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </label>

                            {{-- QRIS --}}
                            <label class="relative border rounded-xl p-4 flex items-center cursor-pointer hover:border-black transition-all group">
                                <input type="radio" name="payment" value="QRIS" class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                                <div class="ml-4 flex items-center justify-between w-full">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-none">QRIS / E-Wallet</p>
                                        <p class="text-[11px] text-gray-500 mt-1">Gopay, OVO, Dana, LinkAja</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <div class="px-1.5 py-0.5 bg-[#f5f5f5] rounded text-[9px] font-black text-[#e52e2e]">QRIS</div>
                                    </div>
                                </div>
                            </label>

                            {{-- BCA --}}
                            <label class="relative border rounded-xl p-4 flex items-center cursor-pointer hover:border-black transition-all">
                                <input type="radio" name="payment" value="BCA Transfer" class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                                <div class="ml-4 flex items-center justify-between w-full">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-none">BCA Transfer</p>
                                        <p class="text-[11px] text-gray-500 mt-1">Konfirmasi manual</p>
                                    </div>
                                    <span class="text-[10px] font-black italic text-blue-800">BCA</span>
                                </div>
                            </label>

                            {{-- Mandiri --}}
                            <label class="relative border rounded-xl p-4 flex items-center cursor-pointer hover:border-black transition-all">
                                <input type="radio" name="payment" value="Mandiri Transfer" class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                                <div class="ml-4 flex items-center justify-between w-full">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-none">Mandiri</p>
                                        <p class="text-[11px] text-gray-500 mt-1">Konfirmasi manual</p>
                                    </div>
                                    <span class="text-[10px] font-black italic text-blue-500">mandiri</span>
                                </div>
                            </label>

                            {{-- BNI/BRI --}}
                            <label class="relative border rounded-xl p-4 flex items-center cursor-pointer hover:border-black transition-all">
                                <input type="radio" name="payment" value="BNI/BRI Transfer" class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                                <div class="ml-4 flex items-center justify-between w-full">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-none">BNI / BRI</p>
                                        <p class="text-[11px] text-gray-500 mt-1">Konfirmasi manual</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <span class="text-[9px] font-black text-orange-600">BNI</span>
                                        <span class="text-[9px] font-black text-blue-700">BRI</span>
                                    </div>
                                </div>
                            </label>

                            {{-- Retail --}}
                            <label class="relative border rounded-xl p-4 flex items-center cursor-pointer hover:border-black transition-all">
                                <input type="radio" name="payment" value="Retail Outlet" class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                                <div class="ml-4 flex items-center justify-between w-full">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-none">Indomaret / Alfamart</p>
                                        <p class="text-[11px] text-gray-500 mt-1">Melalui kasir terdekat</p>
                                    </div>
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </label>
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
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h3>

                        <!-- Product Items in Summary -->
                        <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                            @foreach ($cartItems as $item)
                                <div class="flex gap-3">
                                    @if ($item->product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                                            alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded">
                                    @else
                                        <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">

                                            <span class="text-gray-400 text-xs">

                                                Tidak Ada Gambar

                                            </span>

                                        </div>
                                    @endif
                                    <div class="flex-grow">
                                        <p class="text-sm font-semibold text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-600">Ukuran: {{ $item->size }}</p>
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-xs text-gray-600">Qty: {{ $item->qty }}</span>
                                            <span class="font-semibold text-gray-900">Rp
                                                {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary Calculations -->
                        <div class="space-y-3 text-sm">

                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span>Ongkir</span>
                                <span id="shipping-cost">
                                    Rp 0
                                </span>
                            </div>

                            <hr>

                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span id="grand-total">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                        </div>



                        <!-- Checkout Button -->


                        <button type="submit"
                            class="  w-full  mt-6 bg-black  hover:bg-gray-800  text-white  py-3  rounded-lg  font-semibold  transition">


                            Buat Pesanan

                        </button>

                        </form>

                        <!-- Terms -->
                        <p class="text-xs text-gray-600 text-center mt-4">
                            Dengan melanjutkan saya menerima <a href="#"
                                class="text-gray-900 hover:text-gray-700 underline">Syarat & Ketentuan</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.home.sections.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weight = document.getElementById('weight').value;
            const hasAddress = @js($defaultAddress ? true : false);

            if (hasAddress) {
                calculateShipping(weight);
            }

            function calculateShipping(weight) {
                const shippingCostEl = document.getElementById('shipping-cost');
                const shippingInput = document.getElementById('shipping_input');
                const grandTotalEl = document.getElementById('grand-total');
                const subtotal = {{ $total }};

                shippingCostEl.innerHTML = '<span class="text-[10px] text-blue-500 animate-pulse font-bold">MENGHITUNG...</span>';

                fetch('{{ route('check.ongkir') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ weight: weight })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.data && data.data[0]) {
                        let ongkir = data.data[0].cost;
                        
                        shippingCostEl.innerText = 'Rp ' + ongkir.toLocaleString('id-ID');
                        shippingInput.value = ongkir;
                        grandTotalEl.innerText = 'Rp ' + (subtotal + ongkir).toLocaleString('id-ID');
                    } else {
                        shippingCostEl.innerHTML = '<span class="text-red-500 text-xs">Gagal memuat ongkir</span>';
                    }
                })
                .catch(err => {
                    console.error('Shipping Error:', err);
                    shippingCostEl.innerHTML = '<span class="text-red-500 text-xs">Error koneksi</span>';
                });
            }
        });
    </script>
@endsection
