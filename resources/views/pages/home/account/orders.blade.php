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

            {{-- MAIN CONTENT --}}
            <main class="flex-1 min-w-0" x-data="{ orderTab: '{{ request('status', 'all') }}' }">
                {{-- Filter Tabs --}}
                <div class="flex gap-1 mb-5 bg-white border border-[#e5e5e3] rounded-xl p-1 overflow-x-auto">
                    @foreach ([['all', 'Semua'], ['unpaid', 'Belum Bayar'], ['process', 'Diproses'], ['shipped', 'Dikirim'], ['done', 'Selesai']] as [$k, $l])
                        <a href="{{ route('customer.orders', ['status' => $k]) }}"
                            :class="orderTab === '{{ $k }}' ? 'bg-[#111] text-white' : 'text-[#888] hover:text-[#111]'"
                            class="px-4 py-2 rounded-lg text-[11.5px] font-bold whitespace-nowrap transition-all">{{ $l }}</a>
                    @endforeach
                </div>

                {{-- Order Items --}}
                <div class="space-y-3">
                    @forelse($orders as $order)
                        <div class="bg-white rounded-2xl border border-[#e5e5e3] p-5">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <p class="text-[12px] font-bold text-[#111]">
                                        {{ $order->order_number ?? 'INV/' . $order->id }}</p>
                                    <p class="text-[11px] text-[#aaa] mt-0.5">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[10.5px] font-bold"
                                    style="background:{{ $order->status === 'Completed' ? '#e8f5e9' : (in_array($order->status, ['Shipped', 'Paid', 'Processing']) ? '#e3f2fd' : '#fff8e1') }};color:{{ $order->status === 'Completed' ? '#2e7d32' : (in_array($order->status, ['Shipped', 'Paid', 'Processing']) ? '#1565c0' : '#e65100') }};">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4">
                                @php
                                    $product = $order->items->first()?->product;
                                @endphp

                                @if ($product && $product->images->count())
                                    <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                        class="w-14 h-14 rounded-xl object-cover border border-[#e5e5e3]">
                                @else
                                    <div
                                        class="w-14 h-14 rounded-xl bg-[#f5f5f3] border border-[#e5e5e3] flex items-center justify-center">

                                        <svg class="w-6 h-6 text-[#ccc]">

                                        </svg>

                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-[13px] font-semibold text-[#111] truncate">
                                        {{ $product ? $product->name : 'Produk Order' }}
                                    </p>
                                    <p class="text-[13px] font-black text-[#111] mt-0.5">Rp
                                        {{ number_format($order->total ?? 0) }}</p>
                                </div>
                                <div class="flex flex-col gap-2 flex-shrink-0">
                                    <a href="{{ route('checkout.success', $order->id) }}?from=history"
                                        class="px-4 py-2 border border-[#e5e5e3] rounded-lg text-[11px] font-bold text-[#555] hover:bg-[#f5f5f3] transition-all text-center">Detail</a>
                                    @if ($order->status === 'Completed')
                                        <a href="{{ route('customer.reviews') }}"
                                            class="px-4 py-2 bg-[#111] text-white rounded-lg text-[11px] font-bold hover:bg-[#222] transition-all text-center">Tulis
                                            Ulasan</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-[#e5e5e3] p-10 text-center">
                            <svg class="w-14 h-14 text-[#ddd] mx-auto mb-4" fill="none" stroke="currentColor"
                                stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="text-[14px] font-bold text-[#aaa]">Belum ada pesanan</p>
                            <p class="text-[12.5px] text-[#ccc] mt-1">Mulai berbelanja sekarang.</p>
                        </div>
                    @endforelse
                </div>
        </div>
        </main>
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
@endsection
