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
        reviewModal: false,
        selectedReviewItem: null,
    
        user: {
            name: @js($customer->name),
            email: @js($customer->email),
            phone: @js($customer->phone),
            provider: @js($customer->provider),
            dob: @js($customer->date_of_birth ?? ''),
            gender: @js($customer->gender ?? ''),
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

            @include('pages.home.account._sidebar')
            {{-- ═══════════════════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════════════════ --}}
            <main class="flex-1 min-w-0">

                {{-- ── INCOMPLETE ALERT ── --}}
                <div x-transition
                    class="mb-6 flex items-start gap-3 bg-[#fff9e6] border border-[#fde68a] rounded-xl px-5 py-4">
                        <svg class="w-5 h-5 text-[#d97706] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d=" M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732
                    4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
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
        <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0">

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
                        <span x-text="isVerified ? '✓' : @if ($customer->email_verified) '✓' @else '!' @endif"></span>
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
                            <svg class="w-5 h-5 text-[#111]" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
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
                            <svg class="w-5 h-5 text-[#2563eb]" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
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

                            @php
                                $product = $lastOrder->items->first()?->product;
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

                    <button @click="tab='Orders'"
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

            {{-- ════════════════════════════════════════
               TAB: REVIEWS
            ════════════════════════════════════════ --}}
            <div x-show="tab === 'reviews'" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="display:none;">
                <div class="bg-white rounded-2xl border border-[#e5e5e3] p-6 lg:p-8">
                    <h3 class="text-[18px] font-black tracking-[-0.03em] text-[#111] mb-6">Ulasan Produk</h3>

                    @php
                        $itemsToReview = collect();
                        foreach($orders->where('status', 'Completed') as $order) {
                            foreach($order->items as $item) {
                                if (!$item->testimonial) { $itemsToReview->push($item); }
                            }
                        }
                    @endphp

                    @if($itemsToReview->count() > 0)
                        <div class="grid gap-4">
                            @foreach($itemsToReview as $item)
                                <div class="flex items-center justify-between p-5 border border-[#e5e5e3] rounded-2xl bg-white hover:border-[#111] transition-all group">
                                    <div class="flex items-center gap-4">
                                        @if($item->product->images->count())
                                            <img src="{{ asset('storage/' . $item->product->images->first()->image) }}" class="w-14 h-14 rounded-xl object-cover border border-[#e5e5e3]">
                                        @endif
                                        <div>
                                            <p class="text-[13px] font-bold text-[#111]">{{ $item->product->name }}</p>
                                            <p class="text-[11px] text-[#888] mt-0.5">Ukuran: {{ $item->size }} · Order #{{ $item->order->order_number }}</p>
                                        </div>
                                    </div>
                                    <button @click="selectedReviewItem = { id: {{ $item->id }}, name: '{{ addslashes($item->product->name) }}' }; reviewModal = true" 
                                        class="px-5 py-2.5 bg-[#111] text-white rounded-xl text-[11px] font-bold uppercase tracking-wider hover:bg-[#333] transition-all">
                                        Beri Ulasan
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-16 text-center">
                            <div class="w-16 h-16 bg-[#f5f5f3] rounded-full flex items-center justify-center mx-auto mb-4 text-[#ccc]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z"/></svg>
                            </div>
                            <p class="text-[14px] font-bold text-[#111]">Semua pesanan sudah diulas</p>
                            <p class="text-[12px] text-[#888] mt-1">Terima kasih telah berbagi pengalaman Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>





    {{-- ═══════════════════════════════════════════════
       LOGOUT MODAL
  ═══════════════════════════════════════════════ --}}
    <div x-show="logoutModal" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-5"
        style="display:none;">
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

    {{-- ═══════════════════════════════════════════════
       REVIEW MODAL
  ═══════════════════════════════════════════════ --}}
    <div x-show="reviewModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm px-5"
        style="display:none;" x-cloak>
        <div @click.away="reviewModal=false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="bg-white rounded-[2rem] p-8 w-full max-w-md shadow-2xl relative overflow-hidden" x-data="{ rating: 5 }">
            
            <h3 class="text-[20px] font-black tracking-[-0.04em] text-[#111] mb-1">Berikan Ulasan</h3>
            <p class="text-[13px] text-[#888] mb-8" x-text="'Produk: ' + selectedReviewItem?.name"></p>
            
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="order_item_id" :value="selectedReviewItem?.id">
                <input type="hidden" name="rating" x-model="rating">

                <div class="mb-8">
                    <div class="flex justify-center gap-2">
                        <template x-for="i in 5">
                            <button type="button" @click="rating = i" class="transition-all hover:scale-110 active:scale-95">
                                <svg class="w-10 h-10" :class="i <= rating ? 'text-[#f5a623]' : 'text-[#e5e5e3]'" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-[#aaa] mb-2 block">Komentar Anda</label>
                    <textarea name="comment" required minlength="5" rows="4" 
                        class="w-full bg-[#f5f5f3] border border-[#e5e5e3] rounded-2xl px-5 py-4 text-[13px] text-[#111] focus:ring-2 focus:ring-[#111]/10 focus:border-[#111] outline-none transition-all resize-none"
                        placeholder="Ceritakan pengalaman Anda menggunakan produk ini..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" @click="reviewModal=false" class="flex-1 py-4 border border-[#e5e5e3] rounded-2xl text-[12px] font-bold text-[#555] hover:bg-[#f5f5f3] transition-all">Batal</button>
                    <button type="submit" class="flex-1 py-4 bg-[#111] text-white rounded-2xl text-[12px] font-bold hover:bg-[#222] transition-all">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
    </main>
    </div>

@endsection
