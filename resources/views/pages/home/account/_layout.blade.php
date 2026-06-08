@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-[#f5f5f3] font-['Plus_Jakarta_Sans',sans-serif]" x-data="{
        mobileNav: false,
        logoutModal: false,

        user: {
            name: @js($customer->name),
            email: @js($customer->email),
            phone: @js($customer->phone),
            provider: @js($customer->provider),
            emailVerified: @js($customer->email_verified),
            phoneVerified: @js(!empty($customer->phone)),
            hasAddress: @js($addresses->count() > 0),
            hasPassword: @js(!empty($customer->password)),
        },
        get initials() {
            return this.user.name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
        },

        get isVerified() {
            return this.user.emailVerified && this.user.phoneVerified && this.user.hasAddress;
        },
    }">

        {{-- ═══════════════════════════════════════════════
       MOBILE TOP BAR
  ═══════════════════════════════════════════════ --}}
        <div class="lg:hidden flex items-center justify-between px-5 py-4 bg-white border-b border-[#e5e5e3] sticky top-0 z-30">
            <span class="text-[17px] font-black tracking-[-0.04em] text-[#111]">ZORIE</span>
            <div class="flex items-center gap-3">
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
                @foreach ([['customer.account', 'Dashboard'], ['customer.profile', 'Profile'], ['customer.orders', 'Orders'], ['customer.wishlist', 'Wishlist'], ['customer.reviews', 'Reviews'], ['customer.security', 'Security']] as [$route, $label])
                    <a href="{{ route($route) }}"
                        class="bg-white text-[#555] px-4 py-3.5 text-[12px] font-bold tracking-[0.06em] uppercase text-left transition-colors {{ Route::is($route) ? 'bg-[#111] text-white' : '' }}">{{ $label }}</a>
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
                {{ $slot }}
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
                        class="flex-1 px-4 py-3 border border-[#e5e5e3] text-[#111] rounded-xl text-[12px] font-bold hover:bg-[#f5f5f3] transition-all">
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
    </div>
@endsection
