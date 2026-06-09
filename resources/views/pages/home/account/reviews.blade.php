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
        revTab: 'pending',
        rating: 5,
        isLoggedIn: @js(session()->has('customer_id')),
    
    
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
            hasAddress: @js($customer->addresses->count() > 0),
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
        },
    
        toggleWishlist(productId, isAdding) {
            fetch(isAdding ? `/wishlist/add/${productId}` : `/wishlist/remove/${productId}`, {
                    method: isAdding ? ' POST' : 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(res => res.json())
                .then(data => {
                    if (data.wishlistCount !== undefined) {
                        const el = document.getElementById('wishlist-count');
                        if (el) el.innerText = data.wishlistCount;
                    }
                }).catch(err => console.error('Error toggling wishlist:', err));
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
            <main class="flex-1 min-w-0">
                {{-- Filter Tabs --}}
                <div class="flex gap-1 mb-5 bg-white border border-[#e5e5e3] rounded-xl p-1">
                    <button @click="revTab='pending'"
                        :class="revTab === 'pending' ? 'bg-[#111] text-white' : 'text-[#888]'"
                        class="flex-1 py-2 rounded-lg text-[11.5px] font-bold transition-all">Menunggu Ulasan</button>
                    <button @click="revTab='done'" :class="revTab === 'done' ? 'bg-[#111] text-white' : 'text-[#888]'"
                        class="flex-1 py-2 rounded-lg text-[11.5px] font-bold transition-all">Ulasan Saya</button>
                </div>

                {{-- Pending Reviews --}}
                <div x-show="revTab==='pending'" class="space-y-3">
                    @forelse($itemsToReview as $item)
                        <div class="bg-white rounded-2xl border border-[#e5e5e3] p-5 flex items-center gap-4">
                            <div
                                class="w-14 h-14 rounded-xl bg-[#f5f5f3] border border-[#e5e5e3] flex-shrink-0 overflow-hidden">
                                @if ($item->product->images->count())
                                    <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-[#ccc]" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-[13px] font-bold text-[#111]">{{ $item->product->name }}</p>
                                <p class="text-[11px] text-[#aaa] mt-0.5">Order #{{ $item->order->order_number }} ·
                                    {{ $item->created_at->format('d M Y') }}</p>
                            </div>
                            <button type="button"
                                @click="
        selectedReviewItem = {
            id: {{ $item->id }},
            name: '{{ addslashes($item->product->name) }}'
        };
        rating = 5;
        reviewModal = true;
    "
                                class="px-4 py-2 bg-[#111] text-white rounded-lg text-sm">
                                Tulis Ulasan
                            </button>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-[#e5e5e3] p-10 text-center">
                            <p class="text-[13px] font-bold text-[#aaa]">Tidak ada produk untuk diulas.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Completed Reviews --}}
                <div x-show="revTab==='done'" class="space-y-3" style="display:none;">
                    @forelse($myReviews as $review)
                        <div class="bg-white rounded-2xl border border-[#e5e5e3] p-5">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-14 h-14 rounded-xl bg-[#f5f5f3] border border-[#e5e5e3] flex-shrink-0 overflow-hidden">
                                    @if ($review->product->images->count())
                                        <img src="{{ asset('storage/' . $review->product->images->first()->image) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-[#ccc]" fill="none" stroke="currentColor"
                                                stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-[13px] font-bold text-[#111]">{{ $review->product->name }}</p>
                                    <div class="flex gap-0.5 my-1.5">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-[#f59e0b]' : 'text-[#e5e5e3]' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-[12.5px] text-[#555] leading-relaxed">{{ $review->comment }}</p>
                                    <p class="text-[11px] text-[#aaa] mt-1.5">Ditulis pada
                                        {{ $review->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-[#e5e5e3] p-10 text-center">
                            <p class="text-[13px] font-bold text-[#aaa]">Belum ada ulasan yang Anda tulis.</p>
                        </div>
                    @endforelse
                </div>
        </div>
        </main>


        {{-- Review Modal --}}
        <div x-show="reviewModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 px-5" style="display:none;" x-cloak>

            <div @click.away="reviewModal = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="bg-white rounded-[1.75rem] p-8 w-full max-w-md relative"
                style="border: 0.5px solid rgba(0,0,57,0.1);">

                {{-- Close Button --}}
                <button @click="reviewModal = false"
                    class="absolute top-5 right-5 w-8 h-8 rounded-full bg-[#f5f5f5] flex items-center justify-center text-[#888] hover:bg-[#eee] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- Header --}}
                <div class="mb-6">
                    <p class="text-[10px] font-bold tracking-[3px] uppercase text-[#000039]/40 mb-1.5">Ulasan Produk</p>
                    <h3 class="text-[20px] font-medium text-[#111] leading-snug"
                        x-text="selectedReviewItem?.name ?? 'Produk'"></h3>
                </div>

                <div class="border-t border-[#000039]/8 pt-6">
                    <form action="{{ route('reviews.store') }}" method="POST" x-ref="reviewForm">
                        @csrf
                        <input type="hidden" name="order_item_id" :value="selectedReviewItem?.order_item_id ?? ''">
                        <input type="hidden" name="rating" x-model="reviewRating">

                        {{-- Star Rating --}}
                        <div class="mb-5">
                            <label class="block text-[11px] font-bold tracking-[2px] uppercase text-[#000039]/40 mb-3">
                                Rating
                            </label>
                            <div class="flex items-center gap-1.5">
                                <template x-for="star in [1,2,3,4,5]" :key="star">
                                    <button type="button" @click="reviewRating = star" @mouseover="reviewHover = star"
                                        @mouseleave="reviewHover = 0"
                                        class="text-[2rem] leading-none transition-all duration-150 focus:outline-none"
                                        :class="(reviewHover || reviewRating) >= star
                                            ?
                                            'opacity-100' :
                                            'opacity-20'"
                                        :style="(reviewHover || reviewRating) >= star
                                            ?
                                            'color: #f59e0b;' :
                                            'color: #9ca3af;'">
                                        ★
                                    </button>
                                </template>
                            </div>
                            <p class="text-[12px] text-[#000039]/40 mt-1.5 min-h-[16px]"
                                x-text="['','Sangat buruk','Buruk','Cukup','Bagus','Sangat bagus'][reviewRating] ?? ''">
                            </p>
                        </div>

                        {{-- Komentar --}}
                        <div class="mb-6">
                            <label class="block text-[11px] font-bold tracking-[2px] uppercase text-[#000039]/40 mb-2.5">
                                Komentar
                            </label>
                            <textarea name="comment" rows="4" required minlength="5"
                                placeholder="Ceritakan pengalaman kamu dengan produk ini..."
                                class="w-full bg-[#f8f8f8] border border-[#000039]/8 rounded-xl px-4 py-3
                               text-[14px] text-[#111] placeholder-[#000039]/25
                               focus:outline-none focus:border-[#000039]/30 focus:bg-white
                               transition-all duration-200 resize-none leading-relaxed
                               font-[Plus_Jakarta_Sans,sans-serif]"></textarea>
                            <p class="text-[11px] text-[#000039]/30 mt-1.5">Minimal 5 karakter</p>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full bg-[#000039] text-white rounded-xl py-3.5
                           text-[14px] font-medium tracking-wide
                           hover:bg-[#000039]/90 active:scale-[0.99]
                           transition-all duration-200">
                            Kirim Ulasan
                        </button>

                    </form>
                </div>

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
@endsection
