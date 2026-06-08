@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-[#f5f5f3] font-['Plus_Jakarta_Sans',sans-serif]" x-data="{
        tab: '{{ session('active_tab', 'dashboard') }}',
        mobileNav: false,
        logoutModal: false,
        changeEmailStep: {{ session('change_email_step', 0) }},
        passwordStrength: 0,
        needsAlertDismissed: false,
        addressMode: 'create',
        addressPage: 'list',
        selectedLocationId: null,
        editingAddressId: null,
    
        user: {
            name: @js($customer->name),
            email: @js($customer->email),
            phone: @js($customer->phone),
            provider: @js($customer->provider),
            dob: '1995-08-15',
            gender: 'male',
            avatar: null,
            emailVerified: @js($customer->email_verified),
            phoneVerified: @js(!empty($customer->phone)),
            hasPassword: @js(!empty($customer->password)),
    
        },
    
        form: {
            recipient_name: '',
            phone: '',
            province: '',
            city: '',
            district: '',
            postal_code: '',
            address: '',
            rajaongkir_city_id: '',
            is_default: false,
        },
        get initials() {
            return this.user.name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
        },
    
        get isVerified() {
            return this.user.emailVerified && this.user.phoneVerified && this.user.hasAddress;
        },
    
        get needsAlert() {
            return !this.user.phoneVerified || !this.user.hasAddress;
        },
    
        checkPassword(val) {
            let s = 0;
            if (val.length >= 8) s++;
            if (/[A-Z]/.test(val)) s++;
            if (/[0-9]/.test(val)) s++;
            if (/[^A-Za-z0-9]/.test(val)) s++;
            this.passwordStrength = s;
        },
    
        switchTab(t) {
            this.tab = t;
            this.mobileNav = false;
        }
    }">

        {{-- MOBILE TOP BAR --}}
        <div
            class="lg:hidden flex items-center justify-between px-5 py-4 bg-white border-b border-[#e5e5e3] sticky top-0 z-30">
            <span class="text-[17px] font-black tracking-[-0.04em] text-[#111]">ZORIE</span>
            <button @click="mobileNav = !mobileNav"
                class="w-9 h-9 flex items-center justify-center rounded-full border border-[#e5e5e3] bg-[#f5f5f3]">
                <svg x-show="!mobileNav" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
                <svg x-show="mobileNav" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        {{-- MOBILE NAV DROPDOWN --}}
        <div x-show="mobileNav" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-end="opacity-0 -translate-y-2"
            class="lg:hidden fixed top-[61px] left-0 right-0 z-20 bg-white border-b border-[#e5e5e3] shadow-lg"
            style="display:none;">
            <div class="grid grid-cols-2 gap-px bg-[#e5e5e3] border-t border-[#e5e5e3]">
                @foreach ([['customer.account', 'Dashboard'], ['customer.profile', 'Profile'], ['customer.orders', 'Orders'], ['customer.wishlist', 'Wishlist'], ['customer.reviews', 'Reviews'], ['customer.security', 'Security']] as [$route, $label])
                    <a href="{{ route($route) }}"
                        class="bg-white text-[#555] px-4 py-3.5 text-[12px] font-bold tracking-[0.06em] uppercase text-left transition-colors {{ Route::is($route) ? 'bg-[#111] text-white' : '' }}">{{ $label }}</a>
                @endforeach
                <button @click="logoutModal = true; mobileNav = false"
                    class="bg-white text-red-500 px-4 py-3.5 text-[12px] font-bold tracking-[0.06em] uppercase text-left">Logout</button>
            </div>
        </div>

        <div class="max-w-[1280px] mx-auto px-5 py-8 lg:py-12 flex gap-8">
            {{-- SIDEBAR --}}
            @include('pages.home.account._sidebar')
            <div class="min-h-screen bg-gray-50 pt-32 pb-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Header with Back Button -->
                    <div class="mb-8 flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900">Wishlist Saya</h1>
                            <p class="text-gray-600 mt-2">{{ count($wishlistItems) }} item dalam wishlist Anda</p>
                        </div>
                        <a href="{{ route('home') }}"
                            class="flex items-center gap-2 text-gray-600 hover:text-gray-900 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Awal
                        </a>
                    </div>

                    @if (count($wishlistItems) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($wishlistItems as $product)
                                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                                    <!-- Product Image -->
                                    <div class="relative h-48 bg-gray-200 overflow-hidden">
                                        @if ($product->images->count() > 0)
                                            <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                                alt="{{ $product->name }}"
                                                class="w-full h-full object-cover hover:scale-110 transition">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="text-gray-400 text-sm">Tidak Ada Gambar</span>
                                            </div>
                                        @endif

                                        <!-- Remove Button -->
                                        <button onclick="removeFromWishlist({{ $product->id }})"
                                            class="absolute top-2 right-2 bg-white rounded-full p-2 shadow hover:bg-red-600 hover:text-white transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $product->name }}
                                        </h3>
                                        <p class="text-gray-600 text-sm mt-1 line-clamp-2">{{ $product->description }}</p>

                                        <p class="text-gray-900 font-bold text-lg mt-3">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</p>

                                        <!-- Stock Status -->
                                        @if ($product->stock > 0)
                                            <p class="text-green-600 text-sm font-semibold mt-2">Stok Tersedia</p>
                                        @else
                                            <p class="text-red-500 text-sm font-semibold mt-2">Stok Habis</p>
                                        @endif

                                        <!-- Add to Cart Button -->
                                        @if ($product->stock > 0)
                                            <button onclick="addToCart({{ $product->id }})"
                                                class="w-full mt-4 bg-black text-white py-2 rounded font-semibold hover:bg-gray-800 transition">
                                                Tambah ke Keranjang
                                            </button>
                                        @else
                                            <button disabled
                                                class="w-full mt-4 bg-gray-300 text-gray-600 py-2 rounded font-semibold cursor-not-allowed">
                                                Stok Habis
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Wishlist Anda kosong</h2>
                            <p class="text-gray-600 mb-6">Mulai tambahkan item ke wishlist Anda</p>
                            <a href="{{ route('home') }}"
                                class="inline-block bg-black text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
                                Lanjutkan Berbelanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>



            {{-- Logout Modal --}}
            <div x-show="logoutModal" x-transition class="fixed inset-0 z-40 bg-black/50 flex items-center justify-center"
                style="display:none;">
                <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8 max-w-sm">
                    <h3 class="text-[16px] font-bold text-[#111] mb-2">Yakin ingin keluar?</h3>
                    <p class="text-[13px] text-[#666] mb-6">Anda akan keluar dari akun Anda.</p>
                    <div class="flex gap-3">
                        <button @click="logoutModal = false"
                            class="flex-1 px-4 py-3 border border-[#e5e5e3] text-[#111] rounded-xl text-[12px] font-bold hover:bg-[#f5f5f3] transition-all">Batal</button>
                        <form method="POST" action="{{ route('customer.logout') }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full py-3 bg-red-500 text-white rounded-xl text-[12px] font-bold hover:bg-red-600 transition-all">Ya,
                                Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
         @include('pages.home.sections.footer')

    <script>
        function removeFromWishlist(productId) {
            if(!confirm('Apakah Anda yakin ingin menghapus produk ini dari wishlist?')) return;

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
            // Menggunakan route cart.store via fetch
            fetch(`/cart`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    product_id: productId,
                    qty: 1,
                    size: 'All' // Fallback jika tidak membutuhkan size spesifik dari halaman wishlist
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Produk berhasil ditambahkan ke keranjang!');
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal menambahkan produk ke keranjang.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    </div>

    @endsection
