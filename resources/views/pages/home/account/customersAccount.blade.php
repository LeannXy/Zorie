{{--
    ZORIE — My Account Page
    Stack : Tailwind CSS + Alpine.js + Laravel Blade
    Font  : Plus Jakarta Sans (load in your layout)
    -------------------------------------------------------
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
--}}
@extends('layouts.app')
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
        hasAddress: @js($addresses->count() > 0),
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

    {{-- ═══════════════════════════════════════════════
       MOBILE TOP BAR
  ═══════════════════════════════════════════════ --}}
    <div
        class="lg:hidden flex items-center justify-between px-5 py-4 bg-white border-b border-[#e5e5e3] sticky top-0 z-30">
        <span class="text-[17px] font-black tracking-[-0.04em] text-[#111]">ZORIE</span>
        <div class="flex items-center gap-3">
            <span class="text-[13px] font-semibold text-[#111] capitalize" x-text="tab"></span>
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
    </div>

    {{-- Mobile nav dropdown --}}
    <div x-show="mobileNav" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden fixed top-[61px] left-0 right-0 z-20 bg-white border-b border-[#e5e5e3] shadow-lg"
        style="display:none;">
        <div class="grid grid-cols-2 gap-px bg-[#e5e5e3] border-t border-[#e5e5e3]">
            @foreach ([['dashboard', 'Dashboard'], ['profile', 'Profile'], ['orders', 'Orders'], ['wishlist', 'Wishlist'], ['reviews', 'Reviews'], ['addresses', 'Addresses'], ['security', 'Security']] as [$key, $label])
                <button @click="switchTab('{{ $key }}')"
                    :class="tab === '{{ $key }}' ? 'bg-[#111] text-white' : 'bg-white text-[#555]'"
                    class="px-4 py-3.5 text-[12px] font-bold tracking-[0.06em] uppercase text-left transition-colors">{{ $label }}</button>
            @endforeach
            <button @click="logoutModal = true; mobileNav = false"
                class="bg-white text-red-500 px-4 py-3.5 text-[12px] font-bold tracking-[0.06em] uppercase text-left">Logout</button>
        </div>
    </div>

    <div class="max-w-[1280px] mx-auto px-5 py-8 lg:py-12 flex gap-8">

        {{-- ═══════════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════════ --}}

       <aside class="hidden lg:flex flex-col w-[240px] flex-shrink-0 gap-2">
    <a href="{{ url('/') }}"
        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-black transition mb-6">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

        </svg>

        Kembali ke Beranda

    </a>
    {{-- User card --}}
    <div class="bg-white rounded-2xl border border-[#e5e5e3] p-5 mb-2">
        <div class="flex items-center gap-3">
            @if ($customer->profile_photo)

                @if (Str::startsWith($customer->profile_photo, 'http'))
                    <img src="{{ $customer->profile_photo }}" class="w-20 h-20 rounded-full object-cover">
                @else
                    <img src="{{ asset('storage/' . $customer->profile_photo) }}"
                        class="w-20 h-20 rounded-full object-cover">
                @endif
            @else
                <div class="w-20 h-20 rounded-full bg-[#111] text-white flex items-center justify-center text-[20px] font-black"
                    x-text="initials">
                </div>

            @endif
            <div class="min-w-0">
                <p class="text-[13px] font-bold text-[#111] truncate" x-text="user.name"></p>
                <p class="text-[11px] text-[#aaa] truncate" x-text="user.email"></p>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-[#f0f0ee]">
            <span :class="isVerified ? 'bg-[#111] text-white' : 'bg-[#fff3cd] text-[#856404]'"
                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-[0.06em] uppercase">
                <span x-text="isVerified ? '✓' : '!'"></span>
                <span
                    x-text="isVerified ? 'Verified' : 'Belum Diverifikasi'"></span>
            </span>
        </div>
    </div>

    {{-- Nav (Diubah menjadi elemen <a> dan menggunakan fungsi route() Laravel) --}}
    @foreach ([
        ['customer.account', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'Dashboard'],
        ['customer.profile', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'Profile'],
        ['customer.orders', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'Orders'],
        ['customer.wishlist', 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'Wishlist'],
        ['customer.reviews', 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'Reviews'],
        ['customer.addresses', 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'Addresses'],
        ['customer.security', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'Security'],
    ] as [$route, $icon, $label])
        <a href="{{ route($route) }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl border {{ Route::is($route) ? 'bg-[#111] text-white border-[#111]' : 'bg-white text-[#555] hover:bg-[#f5f5f3] border-[#e5e5e3]' }} text-[12.5px] font-semibold tracking-[0.02em] transition-all w-full text-left">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
            </svg>
            {{ $label }}
        </a>
    @endforeach

    {{-- Logout --}}
    <button @click="logoutModal = true"
        class="flex items-center gap-3 px-4 py-3 rounded-xl border border-red-100 text-red-500 bg-white hover:bg-red-50 text-[12.5px] font-semibold tracking-[0.02em] transition-all w-full text-left mt-1">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        Logout
    </button>
</aside>
        {{-- ═══════════════════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════════════════ --}}
        <main class="flex-1 min-w-0">

            {{-- ── INCOMPLETE ALERT ── --}}
            <div x-show="needsAlert && !needsAlertDismissed && (tab === 'dashboard')" x-transition
                class="mb-6 flex items-start gap-3 bg-[#fff9e6] border border-[#fde68a] rounded-xl px-5 py-4"
                style="display:none;">
                <svg class="w-5 h-5 text-[#d97706] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <p class="text-[13px] font-bold text-[#92400e]">Lengkapi profil Anda</p>
                    <p class="text-[12px] text-[#b45309] mt-0.5">
                        <span x-show="!user.phoneVerified">Nomor telepon belum diisi. </span>
                        <span x-show="!user.hasAddress">Alamat pengiriman belum ditambahkan.</span>
                        Lengkapi sekarang untuk mendapatkan badge Verified.
                    </p>
                    <div class="flex gap-2 mt-2">
                        <button @click="tab='profile'"
                            class="text-[11px] font-bold text-[#92400e] underline underline-offset-2">Lengkapi
                            Profil</button>
                        <span class="text-[#d97706]">·</span>
                        <button @click="tab='addresses'"
                            class="text-[11px] font-bold text-[#92400e] underline underline-offset-2">Tambah
                            Alamat</button>
                    </div>
                </div>
                <button @click="needsAlertDismissed = true" class="ml-auto text-[#d97706]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            {{-- <div class="fixed top-0 right-0 bg-red-500 text-white p-2 z-50"
     x-text="addressPage"></div> --}}
            {{-- ════════════════════════════════════════
           TAB: DASHBOARD
      ════════════════════════════════════════ --}}
            <div x-show="tab === 'dashboard'" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="display:none;">

                {{-- Welcome banner --}}
                <div class="relative overflow-hidden rounded-2xl bg-[#111] px-8 py-8 mb-6">
                    <div
                        class="absolute right-0 top-0 bottom-0 w-[280px] flex items-center justify-end pr-8 opacity-10 select-none pointer-events-none">
                        <span class="text-[120px] font-black tracking-[-0.07em] text-white leading-none">ZR</span>
                    </div>
                    <p class="text-[11px] font-bold tracking-[0.16em] uppercase text-[#888] mb-2">My Account</p>
                    <h2 class="text-[26px] font-black tracking-[-0.04em] text-white leading-tight"
                        x-text="'Halo, ' + user.name.split(' ')[0] + '!'"></h2>
                    <p class="text-[13px] text-[#888] mt-1">Selamat datang kembali di Zorie.</p>
                    <div class="mt-4">
                        <span :class="isVerified ? 'bg-white text-[#111]' : 'bg-[#fff3cd] text-[#856404]'"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10.5px] font-bold tracking-[0.06em] uppercase">
                            <span
                                x-text="isVerified ? '✓' : @if ($customer->email_verified) '✓' @else '!' @endif"></span>
                            <span
                                x-text="isVerified ? 'Verified' : @if ($customer->email_verified) 'Verified' @else 'Belum Diverifikasi' @endif"></span>
                        </span>
                    </div>
                </div>

                {{-- Stat widgets --}}
                <div class="grid grid-cols-3 gap-4 mb-6">

                    {{-- Total Pesanan --}}
                    <div class="bg-white rounded-2xl border border-[#e5e5e3] px-5 py-5">
                        <div class="flex items-start justify-between">
                            <p class="text-[11px] font-bold tracking-[0.08em] uppercase text-[#aaa]">
                                Total Pesanan
                            </p>

                            <div class="w-10 h-10 rounded-xl bg-[#f5f5f3] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#111]" fill="none" stroke="currentColor"
                                    stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-[28px] font-black tracking-[-0.04em] text-[#111]">
                            {{ $totalOrders }}
                        </p>
                    </div>

                    {{-- Ulasan --}}
                    <div class="bg-white rounded-2xl border border-[#e5e5e3] px-5 py-5">
                        <div class="flex items-start justify-between">
                            <p class="text-[11px] font-bold tracking-[0.08em] uppercase text-[#aaa]">
                                Ulasan
                            </p>
                            <div class="w-10 h-10 rounded-xl bg-[#fff8e1] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#f59e0b]" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-[28px] font-black tracking-[-0.04em] text-[#111]">
                            {{ $totalReviews }}
                        </p>
                    </div>

                    {{-- Kelengkapan Akun --}}
                    <div class="bg-white rounded-2xl border border-[#e5e5e3] px-5 py-5">
                        <div class="flex items-start justify-between">
                            <p class="text-[11px] font-bold tracking-[0.08em] uppercase text-[#aaa]">
                                Kelengkapan Akun
                            </p>
                            <div class="w-10 h-10 rounded-xl bg-[#eef6ff] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#2563eb]" fill="none" stroke="currentColor"
                                    stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        @php
                            $profileCompletion = 0;

                            if ($customer->name) {
                                $profileCompletion += 25;
                            }
                            if ($customer->email_verified) {
                                $profileCompletion += 25;
                            }
                            if ($customer->phone) {
                                $profileCompletion += 25;
                            }
                            if ($addresses->count() > 0) {
                                $profileCompletion += 25;
                            }
                        @endphp

                        <p class="mt-3 text-[28px] font-black tracking-[-0.04em] text-[#111]">
                            {{ $profileCompletion }}%
                        </p>

                        <div class="mt-3 h-2 bg-[#ececec] rounded-full overflow-hidden">
                            <div class="h-full bg-[#111] rounded-full" style="width: {{ $profileCompletion }}%">
                            </div>
                        </div>

                    </div>

                </div>

                {{-- Last order + address row --}}
                <div class="grid lg:grid-cols-2 gap-4">

                    {{-- Last order --}}
                    <div class="bg-white rounded-2xl border border-[#e5e5e3] p-6">
                        <p class="text-[11px] font-bold tracking-[0.1em] uppercase text-[#aaa] mb-4">
                            Pesanan Terakhir
                        </p>

                        @if ($orders->count())
                            @php
                                $lastOrder = $orders->first();
                            @endphp

                            <div class="flex items-center gap-4">

                                <div
                                    class="w-14 h-14 rounded-xl bg-[#f5f5f3] border border-[#e5e5e3] flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#aaa]" fill="none" stroke="currentColor"
                                        stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="text-[13px] font-bold text-[#111]">
                                        Order #{{ $lastOrder->id }}
                                    </p>

                                    <p class="text-[12px] text-[#888] mt-1">
                                        Status: {{ ucfirst($lastOrder->status ?? 'Pending') }}
                                    </p>
                                </div>

                                <span
                                    class="flex-shrink-0 px-2.5 py-1 rounded-full bg-[#e8f5e9] text-[#2e7d32] text-[10.5px] font-bold">
                                    {{ ucfirst($lastOrder->status ?? 'Pending') }}
                                </span>

                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10">

                                <svg class="w-12 h-12 text-[#d0d0d0]" fill="none" stroke="currentColor"
                                    stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>

                                <p class="mt-4 text-sm text-[#999]">
                                    Belum ada pesanan
                                </p>

                                <p class="text-xs text-[#bbb] mt-1">
                                    Mulai belanja untuk membuat pesanan pertama Anda
                                </p>

                            </div>
                        @endif

                        <button @click="tab='orders'"
                            class="mt-4 w-full py-2.5 border border-[#e5e5e3] rounded-xl text-[12px] font-bold text-[#555] hover:bg-[#f5f5f3] transition-colors">

                            Lihat Semua Pesanan

                        </button>
                    </div>

                    {{-- Primary address --}}
                    <div class="bg-white rounded-2xl border border-[#e5e5e3] p-6">
                        <p class="text-[11px] font-bold tracking-[0.1em] uppercase text-[#aaa] mb-4">Alamat Utama</p>
                        @php
                            $defaultAddress = $addresses->where('is_default', true)->first();
                        @endphp

                        @if ($defaultAddress)
                            <div>
                                <p class="text-[13px] font-bold text-[#111]">
                                    {{ $defaultAddress->recipient_name }}
                                </p>

                                <p class="text-[12.5px] text-[#666] mt-1 leading-relaxed">
                                    {{ $defaultAddress->address }}
                                </p>

                                <p class="text-[12px] text-[#999] mt-2">
                                    {{ $defaultAddress->district }},
                                    {{ $defaultAddress->city }},
                                    {{ $defaultAddress->province }}
                                    {{ $defaultAddress->postal_code }}
                                </p>
                            </div>
                        @else
                            <div class="text-center py-4">
                                Belum ada alamat utama
                            </div>
                        @endif
                        <template x-if="!user.hasAddress">
                            <div class="flex flex-col items-center justify-center py-4 text-center">
                                <svg class="w-10 h-10 text-[#ddd] mb-3" fill="none" stroke="currentColor"
                                    stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-[12.5px] text-[#aaa]">Belum ada alamat tersimpan.</p>
                                <button @click="tab='addresses'"
                                    class="mt-3 px-4 py-2 bg-[#111] text-white rounded-lg text-[11.5px] font-bold">+
                                    Tambah Alamat</button>
                            </div>
                        </template>
                    </div>

                </div>
            </div>

            {{-- ════════════════════════════════════════
           TAB: PROFILE
      ════════════════════════════════════════ --}}

            <div x-show="tab === 'profile'" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="display:none;">

                <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8">
                    <p class="text-[11px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-6">Profil & Data Diri
                    </p>

                    {{-- Avatar --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700">

                            {{ session('success') }}

                        </div>
                    @endif
                    <form action="{{ route('customer.profile.update') }}" method="POST"
                        enctype="multipart/form-data">

                        <div class="flex items-center gap-5 mb-8 pb-8 border-b border-[#f0f0ee]">

                            <div class="relative" x-data="{ preview: null }">

                                {{-- Preview foto baru --}}
                                <template x-if="preview">
                                    <img :src="preview"
                                        class="w-20 h-20 rounded-full object-cover border border-[#e5e5e3]">
                                </template>

                                {{-- Foto lama / inisial --}}
                                <template x-if="!preview">

                                    <div>

                                        @if ($customer->profile_photo)

                                            @if (str_starts_with($customer->profile_photo, 'http'))
                                                <img src="{{ $customer->profile_photo }}"
                                                    class="w-20 h-20 rounded-full object-cover border border-[#e5e5e3]">
                                            @else
                                                <img src="{{ asset('storage/' . $customer->profile_photo) }}"
                                                    class="w-20 h-20 rounded-full object-cover border border-[#e5e5e3]">
                                            @endif
                                        @else
                                            <div class="w-20 h-20 rounded-full bg-[#111] text-white flex items-center justify-center text-[20px] font-black tracking-wide"
                                                x-text="initials">
                                            </div>

                                        @endif

                                    </div>

                                </template>

                                <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                    class="hidden"
                                    @change=" const file = $event.target.files[0]; if(file){ preview = URL.createObjectURL(file); }">
                                <label for="profile_photo"
                                    class="absolute -bottom-1 -right-1 w-7 h-7 bg-white border border-[#e5e5e3] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#f5f5f3] transition-colors shadow-sm">

                                    <svg class="w-3.5 h-3.5 text-[#555]" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />

                                    </svg>

                                </label>

                            </div>

                            <div>
                                <p class="text-[14px] font-bold text-[#111]" x-text="user.name"></p>
                                <p class="text-[12px] text-[#aaa] mt-0.5" x-text="user.email"></p>
                                <p class="text-[11px] text-[#aaa] mt-1">Format: IMG, JPG, PNG. Maks 2 MB.</p>
                            </div>
                        </div>

                        {{-- Form --}}
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label
                                    class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">Nama
                                    Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                                    class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]"
                                    placeholder="Nama lengkap Anda">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">
                                    Nomor Telepon
                                    <span x-show="!user.phoneVerified"
                                        class="ml-1.5 px-1.5 py-0.5 rounded bg-red-100 text-red-600 text-[9px] normal-case tracking-normal font-bold">Belum
                                        Terverifikasi</span>
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}"
                                    class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]"
                                    placeholder="+62 812 3456 7890">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">Tanggal
                                    Lahir</label>
                                <input type="date" name="date_of_birth"
                                    value="{{ old('date_of_birth', $customer->date_of_birth) }}"
                                    class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white transition-all">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">Jenis
                                    Kelamin</label>
                                <select name="gender"
                                    class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] transition-all">
                                    <option value="">Pilih...</option>

                                    <option value="Male" {{ $customer->gender == 'Male' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>

                                    <option value="Female" {{ $customer->gender == 'Female' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-6 px-8 py-3 bg-[#111] text-white rounded-xl text-[11px] font-bold tracking-[0.12em] uppercase hover:bg-[#222] hover:-translate-y-px hover:shadow-[0_6px_20px_rgba(0,0,0,0.15)] transition-all">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- Change email --}}
                <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8 mt-4">
                    <p class="text-[11px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-1">Ubah Email</p>
                    <p class="text-[12.5px] text-[#aaa] mb-6">Email saat ini: <strong class="text-[#111]"
                            x-text="user.email"></strong></p>

                    {{-- Step indicator --}}
                    <div class="flex items-center gap-2 mb-6">
                        @foreach (['Email Baru', 'OTP Lama', 'OTP Baru'] as $i => $s)
                            <div class="flex items-center gap-2">
                                <div :class="{{ $i }} <= changeEmailStep ?
                                    'bg-[#111] text-white' :
                                    'bg-[#f0f0ee] text-[#aaa]'"
                                    class="w-6 h-6 rounded-full text-[10px] font-black flex items-center justify-center">
                                    {{ $i + 1 }}</div>
                                <span :class="{{ $i }} === changeEmailStep ? 'text-[#111]' : 'text-[#aaa]'"
                                    class="text-[11px] font-semibold hidden sm:block">{{ $s }}</span>
                            </div>
                            @if ($i < 2)
                                <div class="flex-1 h-px bg-[#e5e5e3] mx-1"></div>
                            @endif
                        @endforeach
                    </div>

                    <div x-show="changeEmailStep  === 0" style="display:none;">
                        <form action="{{ route('customer.email.send-old-otp') }}" method="POST">

                            @csrf

                            <input type="email" name="new_email" placeholder="email.baru@example.com"
                                class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] mb-4">

                            <button type="submit" class="px-6 py-3 bg-[#111] text-white rounded-xl">

                                Kirim OTP ke Email Lama

                            </button>

                        </form>
                    </div>
                    <div x-show="changeEmailStep  === 1" style="display:none;">
                        <form action="{{ route('customer.email.verify-old-otp') }}" method="POST">

                            @csrf

                            <input type="text" name="otp" maxlength="6"
                                class="w-full px-4 py-3 border rounded-xl">

                            <button class="mt-3 px-6 py-3 bg-[#111] text-white rounded-xl">

                                Verifikasi

                            </button>

                            <button type="button" @click="changeEmailStep = 0"
                                class="px-4 py-2 border border-[#ddd] rounded-xl">

                                Batalkan ganti email
                            </button>

                            {{-- <button type="submit" class="ml-4 text-sm text-blue-600 hover:underline">

                            Kirim Ulang OTP

                        </button> --}}

                        </form>
                    </div>

                    <div x-show="changeEmailStep  === 2" style="display:none;">
                        <form action="{{ route('customer.email.send-new-otp') }}" method="POST">

                            @csrf

                            <button type="submit" class="px-6 py-3 bg-[#111] text-white rounded-xl">

                                Kirim OTP ke Email Baru

                            </button>


                            <button type="button" @click="changeEmailStep = 0"
                                class="px-4 py-2 border border-[#ddd] rounded-xl">

                                Batalkan ganti email
                            </button>

                        </form>
                    </div>

                    <div x-show="changeEmailStep === 3">

                        <p class="text-[12px] text-[#777] mb-4">
                            Masukkan OTP yang dikirim ke email baru.
                        </p>

                        <form action="{{ route('customer.email.verify-new-otp') }}" method="POST">

                            @csrf

                            <input type="text" name="otp" maxlength="6" placeholder="Masukkan OTP"
                                class="w-full px-4 py-3 border rounded-xl mb-4">

                            <button type="submit" class="px-6 py-3 bg-[#111] text-white rounded-xl">

                                Aktifkan Email Baru

                            </button>

                            <button type="button" @click="changeEmailStep = 0"
                                class="px-4 py-2 border border-[#ddd] rounded-xl">

                                Batalkan ganti email
                            </button>

                            <button type="submit" class="text-sm text-blue-600 hover:underline">

                                Kirim Ulang OTP

                            </button>

                        </form>

                    </div>
                </div>
            </div>


            {{-- ════════════════════════════════════════
           TAB: ORDERS
      ════════════════════════════════════════ --}}
            <div x-show="tab === 'orders'" x-data="{ orderTab: 'all' }"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="display:none;">

                {{-- Filter tabs --}}
                <div class="flex gap-1 mb-5 bg-white border border-[#e5e5e3] rounded-xl p-1 overflow-x-auto">
                    @foreach ([['all', 'Semua'], ['unpaid', 'Belum Bayar'], ['process', 'Diproses'], ['shipped', 'Dikirim'], ['done', 'Selesai']] as [$k, $l])
                        <button @click="orderTab='{{ $k }}'"
                            :class="orderTab === '{{ $k }}' ? 'bg-[#111] text-white' :
                                'text-[#888] hover:text-[#111]'"
                            class="px-4 py-2 rounded-lg text-[11.5px] font-bold whitespace-nowrap transition-all">{{ $l }}</button>
                    @endforeach
                </div>

                {{-- Order items --}}
                <div class="space-y-3">
                    @foreach ([['INV/2024/06/00123', '15 Jun 2024', 'Exotek NITRO Running Shoes', 'Rp 1.299.000', 'done', 'Selesai', '#e8f5e9', '#2e7d32'], ['INV/2024/05/00089', '2 Mei 2024', 'Zorie Casual Slip-On', 'Rp 799.000', 'shipped', 'Dikirim', '#e3f2fd', '#1565c0'], ['INV/2024/04/00045', '10 Apr 2024', 'Classic Canvas Low', 'Rp 599.000', 'unpaid', 'Belum Bayar', '#fff8e1', '#e65100']] as [$inv, $date, $prod, $total, $status, $label, $bg, $tc])
                        <div class="bg-white rounded-2xl border border-[#e5e5e3] p-5">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <p class="text-[12px] font-bold text-[#111]">{{ $inv }}</p>
                                    <p class="text-[11px] text-[#aaa] mt-0.5">{{ $date }}</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[10.5px] font-bold"
                                    style="background:{{ $bg }};color:{{ $tc }};">{{ $label }}</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-14 h-14 rounded-xl bg-[#f5f5f3] border border-[#e5e5e3] flex-shrink-0 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#ccc]" fill="none" stroke="currentColor"
                                        stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[13px] font-semibold text-[#111] truncate">{{ $prod }}</p>
                                    <p class="text-[13px] font-black text-[#111] mt-0.5">{{ $total }}</p>
                                </div>
                                <div class="flex flex-col gap-2 flex-shrink-0">
                                    <button
                                        class="px-4 py-2 border border-[#e5e5e3] rounded-lg text-[11px] font-bold text-[#555] hover:bg-[#f5f5f3] transition-all">Detail</button>
                                    @if ($status === 'done')
                                        <button @click="tab='reviews'"
                                            class="px-4 py-2 bg-[#111] text-white rounded-lg text-[11px] font-bold hover:bg-[#222] transition-all">Tulis
                                            Ulasan</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ════════════════════════════════════════
           TAB: WISHLIST
      ════════════════════════════════════════ --}}
            <div x-show="tab === 'wishlist'" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="display:none;">

                {{-- Empty state example — replace with @forelse --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse([
            ['Exotek NITRO','Rp 1.299.000'],
            ['Zorie Casual Slip-On','Rp 799.000'],
            ['Classic Canvas Low','Rp 599.000'],
            ['Trail Blazer Pro','Rp 1.499.000'],
            ['Urban Runner X','Rp 999.000'],
          ] as [$name,$price])
                        <div class="bg-white rounded-2xl border border-[#e5e5e3] overflow-hidden group">
                            <div class="aspect-square bg-[#f5f5f3] flex items-center justify-center relative">
                                <svg class="w-16 h-16 text-[#ddd]" fill="none" stroke="currentColor"
                                    stroke-width="1" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <button
                                    class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full border border-[#e5e5e3] flex items-center justify-center text-red-400 hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-[13px] font-bold text-[#111]">{{ $name }}</p>
                                <p class="text-[13px] font-black text-[#111] mt-0.5">{{ $price }}</p>
                                <button
                                    class="mt-3 w-full py-2.5 bg-[#111] text-white rounded-lg text-[11px] font-bold tracking-[0.06em] uppercase hover:bg-[#222] transition-all">
                                    + Keranjang
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 py-20 text-center">
                            <svg class="w-14 h-14 text-[#ddd] mx-auto mb-4" fill="none" stroke="currentColor"
                                stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <p class="text-[14px] font-bold text-[#aaa]">Wishlist masih kosong</p>
                            <p class="text-[12.5px] text-[#ccc] mt-1">Tambahkan produk favorit Anda ke sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ════════════════════════════════════════
           TAB: REVIEWS
      ════════════════════════════════════════ --}}
            <div x-show="tab === 'reviews'" x-data="{ revTab: 'pending' }"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="display:none;">

                <div class="flex gap-1 mb-5 bg-white border border-[#e5e5e3] rounded-xl p-1">
                    <button @click="revTab='pending'"
                        :class="revTab === 'pending' ? 'bg-[#111] text-white' : 'text-[#888]'"
                        class="flex-1 py-2 rounded-lg text-[11.5px] font-bold transition-all">Menunggu Ulasan</button>
                    <button @click="revTab='done'"
                        :class="revTab === 'done' ? 'bg-[#111] text-white' : 'text-[#888]'"
                        class="flex-1 py-2 rounded-lg text-[11.5px] font-bold transition-all">Ulasan Saya</button>
                </div>

                <div x-show="revTab==='pending'" class="space-y-3">
                    <div class="bg-white rounded-2xl border border-[#e5e5e3] p-5 flex items-center gap-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-[#f5f5f3] border border-[#e5e5e3] flex-shrink-0 flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#ccc]" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-[13px] font-bold text-[#111]">Exotek NITRO Running Shoes</p>
                            <p class="text-[11px] text-[#aaa] mt-0.5">Dibeli 15 Jun 2024</p>
                        </div>
                        <button
                            class="px-4 py-2 bg-[#111] text-white rounded-lg text-[11px] font-bold hover:bg-[#222] transition-all flex-shrink-0">Tulis
                            Ulasan</button>
                    </div>
                </div>

                <div x-show="revTab==='done'" class="space-y-3" style="display:none;">
                    <div class="bg-white rounded-2xl border border-[#e5e5e3] p-5">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-14 h-14 rounded-xl bg-[#f5f5f3] border border-[#e5e5e3] flex-shrink-0 flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#ccc]" fill="none" stroke="currentColor"
                                    stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-[13px] font-bold text-[#111]">Zorie Casual Slip-On</p>
                                <div class="flex gap-0.5 my-1.5">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i < 4 ? 'text-[#f59e0b]' : 'text-[#e5e5e3]' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-[12.5px] text-[#555] leading-relaxed">Nyaman dipakai, kualitas bahan
                                    bagus. Ukuran sesuai chart. Recommended!</p>
                                <p class="text-[11px] text-[#aaa] mt-1.5">Ditulis 3 Mei 2024</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════
           TAB: ADDRESSES
             ════════════════════════════════════════ --}}
            <div x-show="tab === 'addresses'" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="display:none;">

                <div class="flex justify-end mb-4">
                    <button
                        @click=" addressPage='create';
                        console.log(addressPage);
                                form = {
                                         recipient_name:'',
                                         phone:'',
                                         province:'',
                                         city:'',
                                         district:'',
                                         postal_code:'',
                                          address:'',
                                            rajaongkir_city_id:'',
                                         is_default:false
                                        };"
                        class="px-5 py-2.5 bg-[#111] text-white rounded-xl text-[11px] font-bold tracking-[0.08em] uppercase hover:bg-[#222] hover:-translate-y-px transition-all">
                        + Tambah Alamat Baru
                    </button>
                </div>
                <div x-show="addressPage === 'list'">
                    <div class="space-y-3">
                        @forelse($addresses as $address)
                            <div class="bg-white rounded-2xl border border-[#e5e5e3] mb-2 p-6">

                                <div class="flex items-start justify-between gap-4">

                                    <div class="flex-1">

                                        <div class="flex items-center gap-2 mb-2">

                                            <p class="text-[13px] font-bold text-[#111]">
                                                {{ $address->recipient_name }}
                                            </p>

                                            @if ($address->is_default)
                                                <span
                                                    class="px-2 py-0.5 rounded-full bg-[#111] text-white text-[9.5px] font-bold">
                                                    Utama
                                                </span>
                                            @endif

                                        </div>

                                        <p class="text-[12.5px] text-[#666]">
                                            {{ $address->phone }}
                                        </p>

                                        <p class="text-[12.5px] text-[#666] mt-1">
                                            {{ $address->address }}
                                        </p>

                                        <p class="text-[12px] text-[#999] mt-2">

                                            {{ $address->district }},
                                            {{ $address->city }},
                                            {{ $address->province }}

                                            {{ $address->postal_code }}

                                        </p>

                                    </div>

                                    <div class="flex flex-col gap-2">

                                        <button
                                            @click="
                                        addressPage='edit';
                                        form.recipient_name='{{ addslashes($address->recipient_name) }}';
                                        form.phone='{{ $address->phone }}';
                                        form.province='{{ addslashes($address->province) }}';
                                        form.city='{{ addslashes($address->city) }}';
                                        form.district='{{ addslashes($address->district) }}';
                                        form.postal_code='{{ $address->postal_code }}';
                                        form.address='{{ addslashes($address->address) }}';
                                        form.rajaongkir_city_id='{{ $address->rajaongkir_city_id }}';
                                        selectedLocationId = '{{ $address->rajaongkir_city_id }}';
                                        editingAddressId={{ $address->id }};
                                        form.is_default = {{ $address->is_default ? 'true' : 'false' }}; "
                                            class="px-3 py-1.5 border border-[#e5e5e3] rounded-lg text-[11px] font-bold">
                                            Edit
                                        </button>

                                        @if (!$address->is_default)
                                            <form action="{{ route('address.default', $address) }}" method="POST">

                                                @csrf

                                                <button class="px-3 py-1.5 border rounded-lg text-[11px] font-bold">

                                                    Jadikan Utama

                                                </button>

                                            </form>
                                        @endif

                                        <form action="{{ route('address.destroy', $address) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Hapus alamat?')"
                                                class="px-3 py-1.5 border border-red-100 text-red-500 rounded-lg text-[11px] font-bold">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </div>
                            </div>



                        @empty

                            <div class="bg-white rounded-2xl border border-[#e5e5e3] p-10 text-center">

                                <p class="text-gray-500">
                                    Belum ada alamat tersimpan
                                </p>

                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ================
                 tambah/edit address 
                 =================== --}}
                <div x-show="addressPage === 'create' || addressPage === 'edit'" style="display:none;">

                    {{-- Back Button --}}
                    <button @click="addressPage = 'list'"
                        class="inline-flex items-center gap-2 text-[10.5px] font-bold tracking-[0.13em] uppercase text-[#bbb] hover:text-[#111] transition-colors mb-7 bg-transparent border-0 cursor-pointer group"
                        style="font-family:'Plus Jakarta Sans',sans-serif;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                            class="group-hover:-translate-x-0.5 transition-transform">
                            <path d="M19 12H5M12 5l-7 7 7 7" />
                        </svg>
                        Kembali ke Daftar Alamat
                    </button>

                    {{-- Tab Switcher --}}
                    <div class="flex gap-0 mb-7 border border-[#e5e5e3] rounded-[12px] p-1 bg-[#f5f5f3]">
                        <button @click="addressPage = 'create'"
                            :class="addressPage === 'create'
                                ?
                                'bg-[#111] text-[#f5f5f3] shadow-[0_2px_8px_rgba(0,0,0,0.14)]' :
                                'bg-transparent text-[#bbb]'"
                            class="flex-1 py-2.5 px-3 rounded-[9px] text-[10.5px] font-bold tracking-[0.13em] uppercase transition-all duration-200 border-0 cursor-pointer"
                            style="font-family:'Plus Jakarta Sans',sans-serif;">Tambah Alamat</button>
                        <button @click="addressPage = 'edit'"
                            :class="addressPage === 'edit'
                                ?
                                'bg-[#111] text-[#f5f5f3] shadow-[0_2px_8px_rgba(0,0,0,0.14)]' :
                                'bg-transparent text-[#bbb]'"
                            class="flex-1 py-2.5 px-3 rounded-[9px] text-[10.5px] font-bold tracking-[0.13em] uppercase transition-all duration-200 border-0 cursor-pointer"
                            style="font-family:'Plus Jakarta Sans',sans-serif;">Edit Alamat</button>
                    </div>

                    {{-- Card --}}
                    <div class="bg-white rounded-[18px] border border-[#e5e5e3] p-9">

                        {{-- Header --}}
                        <div class="mb-7">
                            <div
                                class="flex items-center gap-2 text-[10px] font-bold tracking-[0.16em] uppercase text-[#bbb] mb-2.5 before:block before:w-4 before:h-px before:bg-[#bbb]">
                                <span x-text="addressPage === 'create' ? 'Pengiriman Baru' : 'Perbarui Data'"></span>
                            </div>
                            <h2 class="text-[30px] font-black tracking-[-0.05em] text-[#111] leading-none mb-2"
                                x-text="addressPage === 'create' ? 'Tambah Alamat.' : 'Edit Alamat.'"></h2>
                            <p class="text-[12.5px] text-[#bbb] leading-[1.65]"
                                x-text="addressPage === 'create'
                    ? 'Isi detail alamat pengiriman kamu di bawah ini dengan lengkap.'
                    : 'Ubah detail alamat pengiriman yang sudah tersimpan.'">
                            </p>
                        </div>

                        <div class="h-px bg-[#ebebea] mb-6"></div>

                        <form
                            x-bind:action="addressPage === 'create' ? '{{ route('address.store') }}' : '/customer/address/' +
                                editingAddressId"
                            method="POST">
                            @csrf

                            <template x-if="addressPage === 'edit'">
                                <input type="hidden" name="_method" value="PUT">
                            </template>


                            {{-- ── SECTION: Informasi Penerima ── --}}
                            <p class="text-[10px] font-bold tracking-[0.14em] uppercase text-[#ccc] mb-3.5">Informasi
                                Penerima</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3.5">
                                {{-- Nama Penerima --}}
                                <div>
                                    <label
                                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Nama
                                        Penerima</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="12" cy="8" r="4" />
                                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                                            </svg>
                                        </span>
                                        <input type="text" name="recipient_name" x-model="form.recipient_name"
                                            placeholder="Alex Cruz"
                                            class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                                    </div>
                                    @error('recipient_name')
                                        <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Nomor Telepon --}}
                                <div>
                                    <label
                                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Nomor
                                        Telepon</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.63 19.79 19.79 0 012 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z" />
                                            </svg>
                                        </span>
                                        <input type="tel" name="phone" x-model="form.phone"
                                            placeholder="+62 812 3456 7890"
                                            class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                                    </div>
                                    @error('phone')
                                        <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="rajaongkir_city_id" id="rajaongkir_city_id">
                            <input type="hidden" name="city" id="city_name">

                            {{-- ── SECTION: Lokasi ── --}}
                            {{-- <p class="text-[10px] font-bold tracking-[0.14em] uppercase text-[#ccc] mb-3.5 mt-5">Lokasi
                            </p> --}}

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3.5">
                                {{-- Provinsi --}}
                                <div>
                                    <label
                                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Provinsi</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                                <circle cx="12" cy="10" r="3" />
                                            </svg>
                                        </span>
                                        <input type="text" name="province" x-model="form.province"
                                            placeholder="Masukan provinsi"
                                            class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                                    </div>
                                    @error('province')
                                        <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Kota --}}
                                <div>
                                    <label
                                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Kota
                                        / Kabupaten</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <rect x="2" y="3" width="20" height="14" rx="2" />
                                                <line x1="8" y1="21" x2="16" y2="21" />
                                                <line x1="12" y1="17" x2="12" y2="21" />
                                            </svg>
                                        </span>
                                         <input type="text" name="city" id="city" x-model="form.city" 
                                            placeholder="masukan kota atau kabupaten"
                                            class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                                    </div>
                                    @error('city')
                                        <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div>
                                    <label  class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Kecamatan</label>
                                    <input type="text" name="district" id="district" x-model="form.district" placeholder="masukan Kecamatan"
                                        class="w-full border p-3 rounded-xl border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                                </div>
                    
                                <div>

                                    <label  class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">

                                        Kode Pos

                                    </label>

                                    <input type="text" id="postal_code" x-model="form.postal_code" name="postal_code" maxlength="5" placeholder="Masukan 5 digit kode pos alamat anda"
                                         class="w-full border p-3 rounded-xl border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                                </div>
                            </div>

                             <div class="mb-4 p-4 rounded-xl bg-amber-50 border border-amber-200">
                                        <div class="flex gap-3">
                                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z" />
                                            </svg>

                                            <div>
                                                <p class="text-sm font-semibold text-amber-800">
                                                    Periksa Kode Pos Anda
                                                </p>

                                                <p class="text-xs text-amber-700 mt-1">
                                                    Jika alamat tidak ditemukan, coba periksa kembali kode pos yang
                                                    dimasukkan.
                                                    Pastikan kode pos sesuai dengan wilayah tujuan pengiriman.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                            <div class="mb-4">
                                <h3 class="text-sm font-bold text-[#111]">
                                    Pilih Alamat Pengiriman
                                </h3>

                                <p class="text-xs text-gray-500 mt-1">
                                    Pilih alamat yang ditemukan dengan benar.
                                </p>
                            </div>
                            <div id="postal-result" class="mt-4 space-y-3" >
                            </div>
                            {{-- Alamat Lengkap --}}

                            <div class="mb-5">
                                <label
                                    class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Alamat
                                    Lengkap</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-3.5 pointer-events-none text-[#ccc]">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                            <polyline points="9 22 9 12 15 12 15 22" />
                                        </svg>
                                    </span>
                                    <textarea name="address" x-model="form.address" placeholder="Jl. Pandanaran No. 10, RT 03/RW 07, Kel. Mugassari..."
                                        rows="3"
                                        class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all resize-none leading-relaxed"></textarea>
                                </div>
                                @error('address')
                                    <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Toggle Alamat Utama --}}
                            <div class="flex items-center justify-between px-4 py-3.5 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] mb-7 cursor-pointer hover:border-[#ccc] hover:bg-[#f3f3f1] transition-all"
                                @click="form.is_default = !form.is_default">
                                <div class="flex items-center gap-3">
                                    <svg class="text-[#aaa] shrink-0" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M12 22s-8-4.5-8-11.8A8 8 0 0112 2a8 8 0 018 8.2c0 7.3-8 11.8-8 11.8z" />
                                        <circle cx="12" cy="10" r="2.5" />
                                    </svg>
                                    <div>
                                        <p class="text-[12.5px] font-semibold text-[#555]">Jadikan alamat utama</p>
                                        <p class="text-[11px] text-[#bbb] mt-0.5">Digunakan sebagai alamat
                                            pengiriman
                                            default</p>
                                    </div>
                                </div>
                                {{-- Toggle Switch --}}
                                <div :class="form.is_default ? 'bg-[#111]' : 'bg-[#ddd]'"
                                    class="relative w-9 h-5 rounded-full transition-colors duration-200 shrink-0">
                                    <div :class="form.is_default ? 'translate-x-4' : 'translate-x-0'"
                                        class="absolute top-[3px] left-[3px] w-3.5 h-3.5 rounded-full bg-white transition-transform duration-200">
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-2.5">
                                <button type="button" @click="addressPage = 'list'"
                                    class="px-5 py-4 border border-[#e5e5e3] rounded-[10px] text-[10.5px] font-bold tracking-[0.14em] uppercase text-[#888] bg-transparent hover:border-[#bbb] hover:text-[#333] hover:bg-[#f8f8f6] transition-all cursor-pointer"
                                    style="font-family:'Plus Jakarta Sans',sans-serif;">Batal</button>

                                <button type="submit" id="save-address-btn"
                                    class="flex-1 py-4 bg-[#111] text-[#f5f5f3] rounded-[10px] text-[10.5px] font-bold tracking-[0.18em] uppercase hover:bg-[#1a1a1a] hover:-translate-y-px hover:shadow-[0_8px_24px_rgba(0,0,0,0.16)] active:translate-y-0 active:shadow-none transition-all cursor-pointer"
                                    style="font-family:'Plus Jakarta Sans',sans-serif;"
                                    x-text="addressPage === 'create' ? 'Simpan Alamat' : 'Perbarui Alamat'"></button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════
           TAB: SECURITY
            ════════════════════════════════════════ --}}

            <div x-show="tab === 'security'" x-data="{ newPass: '' }"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="display:none;">

                @if (!$customer->email_verified && $customer->provider !== 'google')
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-5">

                        <h3 class="font-semibold text-amber-700">
                            Email Belum Diverifikasi
                        </h3>

                        <p class="text-sm text-amber-600 mt-1">
                            Verifikasi email untuk mengamankan akun.
                        </p>

                        <form action="{{ route('customer.email.send-otp') }}" method="POST">

                            @csrf

                            <button class="mt-3 px-4 py-2 bg-[#111] text-white rounded-lg text-sm">

                                Kirim OTP Verifikasi

                            </button>

                        </form>

                    </div>
                @endif

                @if (!$customer->email_verified && $customer->provider !== 'google' && session('showEmailOtpForm'))
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-5">
                        <form action="{{ route('customer.email.verify') }}" method="POST" class="mt-4">

                            @csrf

                            <input type="text" name="otp" maxlength="6" placeholder="Masukkan OTP"
                                class="w-full px-4 py-3 border rounded-xl">

                            <button class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg">

                                Verifikasi Email

                            </button>

                        </form>
                    </div>
                @endif

                @if ($customer->provider === 'local')

                    {{-- ── Form Ganti Password ── --}}
                    <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8 max-w-lg">

                        <div
                            class="flex items-center gap-2 text-[10px] font-bold tracking-[0.16em] uppercase text-[#bbb] mb-6 before:block before:w-4 before:h-px before:bg-[#bbb]">
                            Ganti Password
                        </div>

                        <form action="{{ route('customer.password.change') }}" method="POST" class="space-y-4">
                            @csrf

                            {{-- Password Saat Ini --}}
                            <div>
                                <label
                                    class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">
                                    Password Saat Ini
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="3" y="11" width="18" height="11" rx="2" />
                                            <path d="M7 11V7a5 5 0 0110 0v4" />
                                        </svg>
                                    </span>
                                    <input type="password" name="current_password" placeholder="••••••••"
                                        class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]">
                                </div>
                                @error('current_password')
                                    <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label
                                    class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">
                                    Password Baru
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M12 22s-8-4.5-8-11.8A8 8 0 0112 2a8 8 0 018 8.2c0 7.3-8 11.8-8 11.8z" />
                                            <circle cx="12" cy="10" r="2.5" />
                                        </svg>
                                    </span>
                                    <input type="password" name="new_password" x-model="newPass"
                                        @input="checkPassword($event.target.value)" placeholder="Min. 8 karakter"
                                        class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]">
                                </div>

                                {{-- Strength Meter --}}
                                <div class="mt-2.5 flex gap-1.5" x-show="newPass.length > 0">
                                    @for ($i = 0; $i < 4; $i++)
                                        <div :class="{
                                            'bg-red-400': passwordStrength === 1 && {{ $i }} === 0,
                                            'bg-orange-400': passwordStrength === 2 && {{ $i }} < 2,
                                            'bg-yellow-400': passwordStrength === 3 && {{ $i }} < 3,
                                            'bg-green-500': passwordStrength >= 4,
                                            'bg-[#e5e5e3]': passwordStrength <= {{ $i }}
                                        }"
                                            class="h-1 flex-1 rounded-full transition-all duration-300"></div>
                                    @endfor
                                </div>
                                <p class="text-[11px] mt-1.5 transition-colors" x-show="newPass.length > 0"
                                    :class="{
                                        'text-red-500': passwordStrength === 1,
                                        'text-orange-500': passwordStrength === 2,
                                        'text-yellow-600': passwordStrength === 3,
                                        'text-green-600': passwordStrength >= 4,
                                    }"
                                    x-text="['','Lemah — tambahkan huruf besar & angka','Sedang — tambahkan karakter spesial','Kuat — hampir sempurna','Sangat Kuat'][passwordStrength]">
                                </p>
                                @error('new_password')
                                    <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label
                                    class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M9 12l2 2 4-4" />
                                            <rect x="3" y="11" width="18" height="11" rx="2" />
                                            <path d="M7 11V7a5 5 0 0110 0v4" />
                                        </svg>
                                    </span>
                                    <input type="password" name="new_password_confirmation"
                                        placeholder="Ulangi password baru"
                                        class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full py-3.5 bg-[#111] text-white rounded-xl text-[11px] font-bold tracking-[0.12em] uppercase hover:bg-[#222] hover:-translate-y-px hover:shadow-[0_6px_20px_rgba(0,0,0,0.15)] transition-all mt-2 cursor-pointer">
                                Simpan Password Baru
                            </button>

                        </form>
                    </div>
                @else
                    {{-- ── Info: Akun Google (tidak bisa ganti password) ── --}}
                    <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8 max-w-lg">

                        <div
                            class="flex items-center gap-2 text-[10px] font-bold tracking-[0.16em] uppercase text-[#bbb] mb-6 before:block before:w-4 before:h-px before:bg-[#bbb]">
                            Keamanan Akun
                        </div>

                        {{-- Google Badge --}}
                        <div
                            class="flex items-center gap-3.5 p-4 border border-[#e5e5e3] rounded-[12px] bg-[#f8f8f6] mb-6">
                            <div
                                class="w-10 h-10 rounded-full bg-white border border-[#e5e5e3] flex items-center justify-center shrink-0">
                                <svg width="18" height="18" viewBox="0 0 24 24">
                                    <path
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                        fill="#4285F4" />
                                    <path
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                        fill="#34A853" />
                                    <path
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                                        fill="#FBBC05" />
                                    <path
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                        fill="#EA4335" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-[#111] leading-none mb-1">Masuk dengan
                                    Google
                                </p>
                                <p class="text-[11.5px] text-[#aaa]">{{ $customer->email }}</p>
                            </div>
                            <span
                                class="ml-auto text-[10px] font-bold tracking-[0.1em] uppercase text-[#888] bg-[#ebebea] px-2.5 py-1 rounded-full">Terhubung</span>
                        </div>

                        {{-- Info Box --}}
                        <div class="flex gap-3 p-4 rounded-[12px] bg-[#fffbeb] border border-[#fde68a]">
                            <svg class="shrink-0 mt-0.5 text-[#d97706]" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            <div>
                                <p class="text-[12px] font-bold text-[#92400e] mb-1">Password tidak tersedia
                                </p>
                                <p class="text-[12px] text-[#b45309] leading-[1.65]">
                                    Akun kamu terhubung melalui Google. Keamanan login dikelola langsung oleh
                                    Google
                                    — kamu tidak perlu mengatur password di sini.
                                </p>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="h-px bg-[#ebebea] my-6"></div>

                        {{-- Tips --}}
                        <p class="text-[10px] font-bold tracking-[0.14em] uppercase text-[#ccc] mb-4">Tips
                            Keamanan
                        </p>
                        <div class="space-y-3">
                            @foreach ([['Aktifkan 2FA di akun Google kamu untuk keamanan ekstra.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'], ['Jangan bagikan akses Google kamu ke orang lain.', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'], ['Pantau aktivitas login di pengaturan akun Google.', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z']] as [$tip, $path])
                                <div class="flex items-start gap-3">
                                    <svg class="shrink-0 mt-0.5 text-[#bbb]" width="15" height="15"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="{{ $path }}" />
                                    </svg>
                                    <p class="text-[12px] text-[#888] leading-[1.6]">{{ $tip }}</p>
                                </div>
                            @endforeach
                        </div>

                    </div>

                @endif

            </div>
    </div>





    {{-- ═══════════════════════════════════════════════
       LOGOUT MODAL
  ═══════════════════════════════════════════════ --}}
    <div x-show="logoutModal" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-5" style="display:none;">
        <div @click.away="logoutModal=false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="bg-white rounded-2xl border border-[#e5e5e3] p-8 w-full max-w-sm shadow-2xl">
            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center mb-5">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            <h3 class="text-[18px] font-black tracking-[-0.03em] text-[#111] mb-2">Keluar dari akun?</h3>
            <p class="text-[13px] text-[#aaa] leading-relaxed mb-6">Anda akan keluar dari sesi ini.
                Pastikan
                semua
                pekerjaan sudah tersimpan.</p>
            <div class="flex gap-3">
                <button @click="logoutModal=false"
                    class="flex-1 py-3 border border-[#e5e5e3] rounded-xl text-[12px] font-bold text-[#555] hover:bg-[#f5f5f3] transition-all">
                    Batal
                </button>
                <form method="POST" action="{{ route('customer.logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 bg-red-500 text-white rounded-xl text-[12px] font-bold hover:bg-red-600 transition-all">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
    </main>


    <script>
        // Pencarian kode pos
        document.getElementById('postal_code').addEventListener('keyup', async function() {
            if (this.value.length < 5) return;

            const response = await fetch('/search-postal-code?postal_code=' + this.value);
            const data = await response.json();
            let html = '';

            if (data.data) {
                data.data.forEach(location => {
                    html += `
            <div class="location-card border rounded-xl p-4 cursor-pointer hover:border-blue-500 transition"
                data-id="${location.id}"
                data-province="${location.province_name}"
                data-city="${location.city_name}"
                data-district="${location.district_name}">
                <h4 class="font-bold">${location.subdistrict_name}</h4>
                <p class="text-sm text-gray-500">${location.district_name}, ${location.city_name}</p>
                <p class="text-xs text-gray-400">${location.province_name}</p>
            </div>`;
                });
            }
             else {
        html = `
        <div class="flex items-center gap-3 p-4 rounded-xl border border-red-100 bg-red-50">
            <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-red-700">Alamat tidak ditemukan</p>
                <p class="text-xs text-red-500 mt-0.5">Kode pos <strong>${this.value}</strong> tidak ditemukan. Periksa kembali atau coba kode pos lain.</p>
            </div>
        </div>`;
    }
            document.getElementById('postal-result').innerHTML = html;
        });

      


        // Klik kartu hasil
        document.addEventListener('click', function(e) {
            const card = e.target.closest('.location-card');
            if (!card) return;

            // Ambil Alpine component dan update state-nya
            const alpineRoot = document.querySelector('[x-data]');
            const alpineData = Alpine.$data(alpineRoot);

            alpineData.form.province = card.dataset.province;
            alpineData.form.city = card.dataset.city;
            alpineData.form.district = card.dataset.district;
            alpineData.form.rajaongkir_city_id = card.dataset.id;

            // Update hidden field rajaongkir_city_id juga (untuk jaga-jaga)
            document.getElementById('rajaongkir_city_id').value = card.dataset.id;

            // Highlight kartu yang dipilih
            document.querySelectorAll('.location-card').forEach(item =>
                item.classList.remove('border-blue-600', 'bg-blue-50')
            );
            card.classList.add('border-blue-600', 'bg-blue-50');
        });



    </script>
</div>
@endsection