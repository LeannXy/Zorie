@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-[#f5f5f3] font-['Plus_Jakarta_Sans',sans-serif]" x-data="{
    tab: '{{ session('active_tab', 'wishlist') }}',
    mobileNav: false,
    logoutModal: false,
    changeEmailStep: {{ session('change_email_step', 0) }},
    passwordStrength: 0,
    addressMode: 'create',
    addressPage: 'list',
    selectedLocationId: null,
    editingAddressId: null,

    user: {
        name: @js($customer->name),
        email: @js($customer->email),
        phone: @js($customer->phone),
        provider: @js($customer->provider),
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

    get needsAlert() {
        return !this.user.phoneVerified;
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
    <div class="lg:hidden flex items-center justify-between px-5 py-4 bg-white border-b border-[#e5e5e3] sticky top-0 z-30">
        <span class="text-[17px] font-black tracking-[-0.04em] text-[#111]">ZORIE</span>
        <button @click="mobileNav = !mobileNav"
            class="w-9 h-9 flex items-center justify-center rounded-full border border-[#e5e5e3] bg-[#f5f5f3]">
            <svg x-show="!mobileNav" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
            <svg x-show="mobileNav" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    {{-- MOBILE NAV DROPDOWN --}}
    <div x-show="mobileNav"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden fixed top-[61px] left-0 right-0 z-20 bg-white border-b border-[#e5e5e3] shadow-lg"
        style="display:none;">
        <div class="grid grid-cols-2 gap-px bg-[#e5e5e3] border-t border-[#e5e5e3]">
            @foreach ([['customer.account','Dashboard'],['customer.profile','Profil'],['customer.orders','Pesanan'],['customer.wishlist','Wishlist'],['customer.reviews','Ulasan'],['customer.security','Keamanan']] as [$route, $label])
                <a href="{{ route($route) }}"
                    class="bg-white text-[#555] px-4 py-3.5 text-[12px] font-bold tracking-[0.06em] uppercase text-left transition-colors {{ Route::is($route) ? '!bg-[#111] !text-white' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
            <button @click="logoutModal = true; mobileNav = false"
                class="bg-white text-red-500 px-4 py-3.5 text-[12px] font-bold tracking-[0.06em] uppercase text-left">
                Logout
            </button>
        </div>
    </div>

    {{-- MAIN LAYOUT --}}
    <div class="max-w-[1280px] mx-auto px-5 py-8 lg:py-12 flex gap-8">

        {{-- SIDEBAR --}}
        @include('pages.home.account._sidebar')

        {{-- CONTENT --}}
        <main class="flex-1 min-w-0">

            {{-- Page Header --}}
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="text-[11px] font-bold tracking-[3px] uppercase text-[#000039]/35 mb-1.5">Akun saya</p>
                    <h1 class="text-[22px] font-medium text-[#111] leading-tight">Wishlist</h1>
                </div>
                @if (count($wishlistItems) > 0)
                    <span class="text-[12px] font-medium text-[#000039]/40">
                        {{ count($wishlistItems) }} produk
                    </span>
                @endif
            </div>

            @if (count($wishlistItems) > 0)

                {{-- Product Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3">
                    @foreach ($wishlistItems as $product)
                        <div class="bg-white border border-[#000039]/8 rounded-2xl overflow-hidden
                                    hover:border-[#000039]/15 hover:shadow-sm transition-all duration-300 group">

                            {{-- Image --}}
                            <div class="relative overflow-hidden bg-[#f5f5f3]" style="height:180px;">
                                @if ($product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-[#000039]/15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="1.5"/>
                                            <circle cx="8.5" cy="8.5" r="1.5" stroke-width="1.5"/>
                                            <path stroke-linecap="round" stroke-width="1.5" d="M21 15l-5-5L5 21"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Remove Button --}}
                                <button onclick="removeFromWishlist({{ $product->id }})"
                                    class="absolute top-2.5 right-2.5 w-7 h-7 rounded-full
                                           bg-white border border-[#000039]/10
                                           flex items-center justify-center
                                           text-[#000039]/40 hover:bg-red-500 hover:text-white hover:border-red-500
                                           transition-all duration-200"
                                    aria-label="Hapus dari wishlist">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Info --}}
                            <div class="p-4">
                                @if ($product->brand)
                                    <p class="text-[10px] font-bold tracking-[2px] uppercase text-[#000039]/35 mb-1">
                                        {{ $product->brand }}
                                    </p>
                                @endif
                                <p class="text-[14px] font-medium text-[#111] leading-snug mb-3 line-clamp-2">
                                    {{ $product->name }}
                                </p>
                                <p class="text-[15px] font-medium text-[#111] mb-1">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                {{-- Stock badge --}}
                                @if ($product->stock > 0)
                                    <p class="text-[11px] font-medium mb-3" style="color:#1d9e75;">Stok tersedia</p>
                                @else
                                    <p class="text-[11px] font-medium mb-3" style="color:#E24B4A;">Stok habis</p>
                                @endif

                                {{-- CTA --}}
                                @if ($product->stock > 0)
                                    <button onclick="addToCart({{ $product->id }})"
                                        class="w-full bg-[#000039] text-white rounded-xl py-2.5
                                               text-[12px] font-medium tracking-wide
                                               hover:bg-[#000039]/85 active:scale-[0.98]
                                               transition-all duration-200">
                                        Tambah ke keranjang
                                    </button>
                                @else
                                    <button disabled
                                        class="w-full bg-[#f5f5f3] text-[#000039]/25 rounded-xl py-2.5
                                               text-[12px] font-medium cursor-not-allowed">
                                        Stok habis
                                    </button>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>

            @else

                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-20 gap-5">
                    <div class="w-16 h-16 rounded-full bg-[#f5f5f3] border border-[#000039]/8 flex items-center justify-center">
                        <svg class="w-7 h-7 text-[#000039]/25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div class="text-center">
                        <p class="text-[16px] font-medium text-[#111] mb-1.5">Wishlist kamu kosong</p>
                        <p class="text-[13px] text-[#000039]/40">Simpan produk favoritmu supaya mudah ditemukan.</p>
                    </div>
                    <a href="{{ route('all-products') }}"
                       class="bg-[#000039] text-white rounded-xl px-6 py-3
                              text-[13px] font-medium tracking-wide
                              hover:bg-[#000039]/85 transition-all duration-200">
                        Jelajahi produk
                    </a>
                </div>

            @endif

        </main>
    </div>

    {{-- Logout Modal --}}
    <div x-show="logoutModal" x-transition
         class="fixed inset-0 z-40 bg-black/50 flex items-center justify-center px-5"
         style="display:none;">
        <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8 w-full max-w-sm">
            <h3 class="text-[16px] font-bold text-[#111] mb-2">Yakin ingin keluar?</h3>
            <p class="text-[13px] text-[#666] mb-6">Anda akan keluar dari akun Anda.</p>
            <div class="flex gap-3">
                <button @click="logoutModal = false"
                    class="flex-1 px-4 py-3 border border-[#e5e5e3] text-[#111] rounded-xl text-[12px] font-bold hover:bg-[#f5f5f3] transition-all">
                    Batal
                </button>
                <form method="POST" action="{{ route('customer.logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 bg-red-500 text-white rounded-xl text-[12px] font-bold hover:bg-red-600 transition-all">
                        Ya, keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('pages.home.sections.footer')

</div>

<script>
function removeFromWishlist(productId) {
    if (!confirm('Hapus produk ini dari wishlist?')) return;
    fetch(`/wishlist/remove/${productId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => { if (data.success) window.location.reload(); })
    .catch(e => console.error(e));
}

function addToCart(productId) {
    fetch('/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, qty: 1, size: 'All' })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            alert('Produk berhasil ditambahkan ke keranjang!');
            window.location.reload();
        } else {
            alert(data.message || 'Gagal menambahkan ke keranjang.');
        }
    })
    .catch(e => console.error(e));
}
</script>

@endsection