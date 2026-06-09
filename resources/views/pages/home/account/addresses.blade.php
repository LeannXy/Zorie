{{--
    ZORIE — My Account Page
    Stack : Tailwind CSS + Alpine.js + Laravel Blade
    Font  : Plus Jakarta Sans (load in your layout)
    -------------------------------------------------------
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
--}}
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
            {{-- ════════════════════════════════════════
           TAB: ADDRESSES
             ════════════════════════════════════════ --}}

            <main class="flex-1 min-w-0" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

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
                                    <label
                                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Kecamatan</label>
                                    <input type="text" name="district" id="district" x-model="form.district"
                                        placeholder="masukan Kecamatan"
                                        class="w-full border p-3 rounded-xl border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                                </div>

                                <div>

                                    <label
                                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">

                                        Kode Pos

                                    </label>
                                    <input type="hidden" name="rajaongkir_city_id" id="rajaongkir_city_id"
                                        :value="form.rajaongkir_city_id">
                                    <input type="text" id="postal_code" x-model="form.postal_code" name="postal_code"
                                        maxlength="5" placeholder="Masukan 5 digit kode pos alamat anda"
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
                            <div id="postal-result" class="mt-4 space-y-3">
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
                                    <svg class="text-[#aaa] shrink-0" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 22s-8-4.5-8-11.8A8 8 0 0112 2a8 8 0 018 8.2c0 7.3-8 11.8-8 11.8z" />
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
    </div>
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
            } else {
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
