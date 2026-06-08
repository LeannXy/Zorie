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
            name: @js($customer->name ?? ''),
            email: @js($customer->email ?? ''),
            phone: @js($customer->phone ?? ''),
            provider: @js($customer->provider ?? ''),
            dob: '1995-08-15',
            gender: 'male',
            dob: @js($customer->date_of_birth ?? ''),
            gender: @js($customer->gender ?? ''),
            avatar: null,
            emailVerified: @js(!empty($customer->email_verified) || !empty($customer->email_verified_at)),
            phoneVerified: @js(!empty($customer->phone)),
            hasAddress: @js($customer->addresses->count() > 0),
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
            if (!this.user.name) return '??';
            return this.user.name.split(' ').filter(Boolean).map(w => w[0]).join('').slice(0, 2).toUpperCase();
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
        <div x-show="mobileNav" 
            x-transition:enter="transition ease-out duration-150" 
            x-transition:enter-start="opacity-0 -translate-y-2" 
            x-transition:enter-end="opacity-100 translate-y-0" 
            x-transition:leave="transition ease-in duration-100" 
            x-transition:leave-end="opacity-0 -translate-y-2" 
            class="lg:hidden fixed top-[61px] left-0 right-0 z-20 bg-white border-b border-[#e5e5e3] shadow-lg" 
            style="display:none;">
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

            {{-- ════════════════════════════════════════
                 TAB: PROFILE
                 ════════════════════════════════════════ --}}
            <div class="flex-1"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" 
                x-transition:enter-end="opacity-100 translate-y-0">

                <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8">
                    <p class="text-[11px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-6">Profil & Data Diri</p>

                    {{-- Flash Success Message --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Avatar --}}
                        <div class="flex items-center gap-5 mb-8 pb-8 border-b border-[#f0f0ee]">
                            <div class="relative" x-data="{ preview: null }">
                                {{-- Preview foto baru --}}
                                <template x-if="preview">
                                    <img :src="preview" class="w-20 h-20 rounded-full object-cover border border-[#e5e5e3]">
                                </template>

                                {{-- Foto lama / inisial --}}
                                <template x-if="!preview">
                                    <div>
                                        @if ($customer && $customer->profile_photo)
                                            @if (str_starts_with($customer->profile_photo, 'http'))
                                                <img src="{{ $customer->profile_photo }}" class="w-20 h-20 rounded-full object-cover border border-[#e5e5e3]">
                                            @else
                                                <img src="{{ asset('storage/' . $customer->profile_photo) }}" class="w-20 h-20 rounded-full object-cover border border-[#e5e5e3]">
                                            @endif
                                        @else
                                            <div class="w-20 h-20 rounded-full bg-[#111] text-white flex items-center justify-center text-[20px] font-black tracking-wide" x-text="initials"></div>
                                        @endif
                                    </div>
                                </template>

                                <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden" @change="const file = $event.target.files[0]; if(file){ preview = URL.createObjectURL(file); }">
                                <label for="profile_photo" class="absolute -bottom-1 -right-1 w-7 h-7 bg-white border border-[#e5e5e3] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#f5f5f3] transition-colors shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-[#555]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </label>
                            </div>

                            <div>
                                <p class="text-[14px] font-bold text-[#111]" x-text="user.name"></p>
                                <p class="text-[12px] text-[#aaa] mt-0.5" x-text="user.email"></p>
                                <p class="text-[11px] text-[#aaa] mt-1">Format: IMG, JPG, PNG. Maks 2 MB.</p>
                            </div>
                        </div>

                        {{-- Form Inputs --}}
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]" placeholder="Nama lengkap Anda">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">
                                    Nomor Telepon
                                    <span x-show="!user.phoneVerified" class="ml-1.5 px-1.5 py-0.5 rounded bg-red-100 text-red-600 text-[9px] normal-case tracking-normal font-bold">Belum Terverifikasi</span>
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all placeholder:text-[#ccc]" placeholder="+62 812 3456 7890">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $customer->date_of_birth ?? '') }}" class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] focus:bg-white transition-all">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-2">Jenis Kelamin</label>
                                <select name="gender" class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none focus:border-[#111] transition-all">
                                    <option value="">Pilih...</option>
                                    <option value="Male" {{ isset($customer) && $customer->gender == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Female" {{ isset($customer) && $customer->gender == 'Female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="mt-6 px-8 py-3 bg-[#111] text-white rounded-xl text-[11px] font-bold tracking-[0.12em] uppercase hover:bg-[#222] hover:-translate-y-px hover:shadow-[0_6px_20px_rgba(0,0,0,0.15)] transition-all">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- Change email --}}
                <div class="bg-white rounded-2xl border border-[#e5e5e3] p-8 mt-4">
                    <p class="text-[11px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-1">Ubah Email</p>
                    <p class="text-[12.5px] text-[#aaa] mb-6">Email saat ini: <strong class="text-[#111]" x-text="user.email"></strong></p>

                    {{-- Step indicator --}}
                    <div class="flex items-center gap-2 mb-6">
                        @foreach (['Email Baru', 'OTP Lama', 'OTP Baru'] as $i => $s)
                            <div class="flex items-center gap-2">
                                <div :class="{{ $i }} <= changeEmailStep ? 'bg-[#111] text-white' : 'bg-[#f0f0ee] text-[#aaa]'" class="w-6 h-6 rounded-full text-[10px] font-black flex items-center justify-center">
                                    {{ $i + 1 }}
                                </div>
                                <span :class="{{ $i }} === changeEmailStep ? 'text-[#111]' : 'text-[#aaa]'" class="text-[11px] font-semibold hidden sm:block">{{ $s }}</span>
                            </div>
                            @if ($i < 2)
                                <div class="flex-1 h-px bg-[#e5e5e3] mx-1"></div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Step 0: Input Email Baru --}}
                    <div x-show="changeEmailStep === 0" style="display:none;">
                        <form action="{{ route('customer.email.send-old-otp') }}" method="POST">
                            @csrf
                            <input type="email" name="new_email" value="{{ old('new_email') }}" placeholder="email.baru@example.com" class="w-full px-4 py-3 border border-[#ebebea] rounded-xl bg-[#f8f8f6] mb-1">
                            @error('new_email')
                                <span class="block mb-4 text-[11px] text-red-500">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="px-6 py-3 bg-[#111] text-white rounded-xl">Kirim OTP ke Email Lama</button>
                        </form>
                    </div>

                    {{-- Step 1: Verifikasi OTP Email Lama --}}
                    <div x-show="changeEmailStep === 1" style="display:none;">
                        <form action="{{ route('customer.email.verify-old-otp') }}" method="POST">
                            @csrf
                            <input type="text" name="otp" maxlength="6" class="w-full px-4 py-3 border rounded-xl mb-4" placeholder="Masukkan OTP">
                            @error('otp')
                                <span class="block mb-4 text-[11px] text-red-500">{{ $message }}</span>
                            @enderror
                            <div class="flex gap-3">
                                <button type="submit" class="px-6 py-3 bg-[#111] text-white rounded-xl">Verifikasi</button>
                                <button type="button" @click="changeEmailStep = 0" class="px-4 py-2 border border-[#ddd] rounded-xl text-[13px]">Batalkan</button>
                            </div>
                        </form>
                    </div>

                    {{-- Step 2: Kirim OTP ke Email Baru --}}
                    <div x-show="changeEmailStep === 2" style="display:none;">
                        <form action="{{ route('customer.email.send-new-otp') }}" method="POST">
                            @csrf
                            <div class="flex gap-3">
                                <button type="submit" class="px-6 py-3 bg-[#111] text-white rounded-xl">Kirim OTP ke Email Baru</button>
                                <button type="button" @click="changeEmailStep = 0" class="px-4 py-2 border border-[#ddd] rounded-xl text-[13px]">Batalkan</button>
                            </div>
                        </form>
                    </div>

                    {{-- Step 3: Verifikasi OTP Email Baru --}}
                    <div x-show="changeEmailStep === 3" style="display:none;">
                        <p class="text-[12px] text-[#777] mb-4">Masukkan OTP yang dikirim ke email baru.</p>
                        <form action="{{ route('customer.email.verify-new-otp') }}" method="POST">
                            @csrf
                            <input type="text" name="otp" maxlength="6" placeholder="Masukkan OTP" class="w-full px-4 py-3 border rounded-xl mb-4">
                            @error('otp')
                                <span class="block mb-4 text-[11px] text-red-500">{{ $message }}</span>
                            @enderror
                            <div class="flex gap-3 items-center">
                                <button type="submit" class="px-6 py-3 bg-[#111] text-white rounded-xl">Aktifkan Email Baru</button>
                                <button type="button" @click="changeEmailStep = 0" class="px-4 py-2 border border-[#ddd] rounded-xl text-[13px]">Batalkan</button>
                                <button type="submit" class="text-sm text-blue-600 hover:underline ml-auto">Kirim Ulang OTP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        {{-- Logout Modal --}}
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
                <p class="text-[13px] text-[#aaa] leading-relaxed mb-6">Anda akan keluar dari sesi ini. Pastikan semua perubahan profil telah tersimpan.</p>
                <div class="flex gap-3">
                    <button @click="logoutModal = false"
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
        </div>
    </div>
@endsection