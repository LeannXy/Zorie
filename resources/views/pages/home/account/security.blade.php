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
        <div class="lg:hidden flex items-center justify-between px-5 py-4 bg-white border-b border-[#e5e5e3] sticky top-0 z-30">
            <span class="text-[17px] font-black tracking-[-0.04em] text-[#111]">ZORIE</span>
            <button @click="mobileNav = !mobileNav" class="w-9 h-9 flex items-center justify-center rounded-full border border-[#e5e5e3] bg-[#f5f5f3]">
                <svg x-show="!mobileNav" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
                <svg x-show="mobileNav" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        {{-- MOBILE NAV DROPDOWN --}}
        <div x-show="mobileNav" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden fixed top-[61px] left-0 right-0 z-20 bg-white border-b border-[#e5e5e3] shadow-lg" style="display:none;">
            <div class="grid grid-cols-2 gap-px bg-[#e5e5e3] border-t border-[#e5e5e3]">
                @foreach ([['customer.account', 'Dashboard'], ['customer.profile', 'Profile'], ['customer.orders', 'Orders'], ['customer.wishlist', 'Wishlist'], ['customer.reviews', 'Reviews'], ['customer.security', 'Security']] as [$route, $label])
                    <a href="{{ route($route) }}" class="bg-white text-[#555] px-4 py-3.5 text-[12px] font-bold tracking-[0.06em] uppercase text-left transition-colors {{ Route::is($route) ? 'bg-[#111] text-white' : '' }}">{{ $label }}</a>
                @endforeach
                <button @click="logoutModal = true; mobileNav = false" class="bg-white text-red-500 px-4 py-3.5 text-[12px] font-bold tracking-[0.06em] uppercase text-left">Logout</button>
            </div>
        </div>

        <div class="max-w-[1280px] mx-auto px-5 py-8 lg:py-12 flex gap-8">
            {{-- SIDEBAR --}}
            @include('pages.home.account._sidebar')

            {{-- MAIN CONTENT --}}
            <main class="flex-1 min-w-0">
            {{-- Email Verification Alert --}}
            @if (!$customer->email_verified && $customer->provider !== 'google')
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-5">
                    <h3 class="font-semibold text-amber-700">Email Belum Diverifikasi</h3>
                    <p class="text-sm text-amber-600 mt-1">Verifikasi email untuk mengamankan akun.</p>
                    <form action="{{ route('customer.email.send-otp') }}" method="POST">
                        @csrf
                        <button class="mt-3 px-4 py-2 bg-[#111] text-white rounded-lg text-sm">Kirim OTP Verifikasi</button>
                    </form>
                </div>
            @endif

            @if (!$customer->email_verified && $customer->provider !== 'google' && session('showEmailOtpForm'))
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-5">
                    <form action="{{ route('customer.email.verify') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="text" name="otp" maxlength="6" placeholder="Masukkan OTP" class="w-full px-4 py-3 border rounded-xl">
                        <button class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg">Verifikasi Email</button>
                    </form>
                </div>
            @endif

            {{-- Change Password Section --}}
            @if ($customer->provider === 'local')
                <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8">
                    <div class="flex items-center gap-2 text-[10px] font-bold tracking-[0.16em] uppercase text-[#bbb] mb-6 before:block before:w-4 before:h-px before:bg-[#bbb]">
                        Ganti Password
                    </div>

                    <form action="{{ route('customer.password.change') }}" method="POST" class="space-y-4">
                        @csrf

                        {{-- Current Password --}}
                        <div>
                            <label class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">
                                Password Saat Ini
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" />
                                    </svg>
                                </span>
                                <input type="password" name="current_password" placeholder="••••••••" class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]">
                            </div>
                            @error('current_password')
                                <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">
                                Password Baru
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22s-8-4.5-8-11.8A8 8 0 0112 2a8 8 0 018 8.2c0 7.3-8 11.8-8 11.8z" />
                                        <circle cx="12" cy="10" r="2.5" />
                                    </svg>
                                </span>
                                <input type="password" name="new_password" placeholder="••••••••" class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]">
                            </div>
                            @error('new_password')
                                <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#ccc]">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" />
                                    </svg>
                                </span>
                                <input type="password" name="new_password_confirmation" placeholder="••••••••" class="w-full pl-10 pr-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]">
                            </div>
                        </div>

                        <button type="submit" class="mt-6 px-8 py-3 bg-[#111] text-white rounded-xl text-[11px] font-bold tracking-[0.12em] uppercase hover:bg-[#222] hover:-translate-y-px hover:shadow-[0_6px_20px_rgba(0,0,0,0.15)] transition-all">
                            Ubah Password
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8">
                    <p class="text-[12px] text-[#aaa]">Akun Anda terkoneksi dengan {{ ucfirst($customer->provider) }}. Kelola password di {{ ucfirst($customer->provider) }}.</p>
                </div>
            @endif
            </main>
        </div>

        {{-- Logout Modal --}}
        <div x-show="logoutModal" x-transition class="fixed inset-0 z-40 bg-black/50 flex items-center justify-center" style="display:none;">
            <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8 max-w-sm">
                <h3 class="text-[16px] font-bold text-[#111] mb-2">Yakin ingin keluar?</h3>
                <p class="text-[13px] text-[#666] mb-6">Anda akan keluar dari akun Anda.</p>
                <div class="flex gap-3">
                    <button @click="logoutModal = false" class="flex-1 px-4 py-3 border border-[#e5e5e3] text-[#111] rounded-xl text-[12px] font-bold hover:bg-[#f5f5f3] transition-all">Batal</button>
                    <form method="POST" action="{{ route('customer.logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-xl text-[12px] font-bold hover:bg-red-600 transition-all">Ya, Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
