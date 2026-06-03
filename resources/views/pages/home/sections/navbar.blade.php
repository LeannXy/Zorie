@php
    $routeAllProducts = route('all-products');
    $routeSport       = route('all-products', ['filter' => 'Sport']);
    $routeSneakers    = route('all-products', ['filter' => 'Sneakers']);
    $routeCasual      = route('all-products', ['filter' => 'Casual']);
    $routeRunning     = route('all-products', ['filter' => 'Running']);
    $routeCartCount   = route('cart.count');

    $navLinks = [
        ['label' => 'Beranda',      'url' => '/'],
        ['label' => 'Toko',         'url' => $routeAllProducts],
        ['label' => 'Tentang Kami', 'url' => '/about'],
        ['label' => 'Contact',      'url' => '/contact'],
        ['label' => 'Tanya Jawab',  'url' => '/faq'],
    ];
@endphp

<header x-cloak
    x-data="{
        scrolled: false,
        cartCount: 0,
        categoryOpen: false,
        genderOpen: false,
        langOpen: false,
        categories: [
            { label: 'Sneakers', route: '{{ $routeSneakers }}' },
            { label: 'Sports',   route: '{{ $routeSport }}' },
            { label: 'Casual',   route: '{{ $routeCasual }}' },
            { label: 'Running',  route: '{{ $routeRunning }}' },
        ],
        genders: [
            { label: 'Pria',   route: '{{ route('all-products', ['gender' => 'Pria']) }}' },
            { label: 'Wanita', route: '{{ route('all-products', ['gender' => 'Wanita']) }}' },
            { label: 'Remaja', route: '{{ route('all-products', ['gender' => 'Remaja']) }}' },
            { label: 'Anak',   route: '{{ route('all-products', ['gender' => 'Anak']) }}' },
        ],
        selectedCategory: 'Kategori',
        selectedRoute: '{{ $routeAllProducts }}',
        selectedGender: 'Kategori Usia',
        selectedLang: 'ID',
        switchLang(lang) {
            this.selectedLang = lang;
            this.langOpen = false;
            if (lang === 'EN') {
                const url = new URL(window.location.href);
                url.searchParams.set('lang', 'en');
                window.location.href = url.toString();
            } else {
                const url = new URL(window.location.href);
                url.searchParams.set('lang', 'id');
                window.location.href = url.toString();
            }
        }
    }"
    x-init="
        fetch('{{ $routeCartCount }}')
            .then(r => r.json())
            .then(d => cartCount = d.count);

        // Deteksi lang dari URL
        const params = new URLSearchParams(window.location.search);
        const lang = params.get('lang');
        if (lang === 'en') selectedLang = 'EN';
        else selectedLang = 'ID';
    "
    @scroll.window="scrolled = window.scrollY > 60"
    @click.outside="categoryOpen = false; genderOpen = false; langOpen = false"
    class="fixed top-0 left-0 w-full z-[100] pointer-events-none">

    {{-- ===== WRAPPER ===== --}}
    <div class="transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] pointer-events-auto overflow-visible"
        :class="scrolled ? 'mx-auto mt-3 max-w-[500px]' : 'mx-0 mt-0 max-w-full'">

        {{-- ===== TOP BAR ===== --}}
        <div class="backdrop-blur-2xl transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] overflow-visible"
            :class="scrolled
                ? 'bg-white/95 rounded-full border border-[#000039]/15 px-4 h-[54px]'
                : 'bg-white/95 rounded-none border-b border-[#000039]/15 px-6 h-[68px]'">

            <div class="flex items-center justify-between h-full gap-4 max-w-[1280px] mx-auto overflow-visible">

                {{-- LOGO --}}
                <a href="/" class="shrink-0">
                    <h1 class="text-[#000039] font-[800] tracking-[-2px] uppercase leading-none transition-all duration-500"
                        style="font-family: 'Plus Jakarta Sans', sans-serif;"
                        :class="scrolled ? 'text-[20px]' : 'text-[28px]'">
                        ZORIE
                    </h1>
                </a>

                {{-- SEARCH BAR --}}
                <div class="flex-1 max-w-[700px] transition-all duration-300 overflow-visible"
                    :class="scrolled ? 'opacity-0 w-0 overflow-hidden pointer-events-none' : 'opacity-100'">
                    <form action="{{ route('search') }}" method="GET"
                        class="flex items-center h-[40px] bg-[#000039]/8 border border-[#000039]/20 rounded-full relative" style="overflow:visible !important;">

                        {{-- Dropdown Kategori --}}
                        <div class="relative h-full shrink-0" @click.outside="categoryOpen = false">
                            <button type="button"
                                x-ref="catBtn"
                                @click.stop="
                                    categoryOpen = !categoryOpen;
                                    genderOpen = false;
                                    langOpen = false;
                                    if (categoryOpen) {
                                        const r = $refs.catBtn.getBoundingClientRect();
                                        $refs.catDropdown.style.top = (r.bottom + 8) + 'px';
                                        $refs.catDropdown.style.left = r.left + 'px';
                                    }
                                "
                                class="h-full flex items-center gap-1.5 pl-4 pr-3 text-[12px] font-semibold text-[#000039]/70 border-r border-[#000039]/20 hover:text-[#000039] transition whitespace-nowrap"
                                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <span x-text="selectedCategory"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 transition-transform duration-200"
                                    :class="categoryOpen ? 'rotate-180' : ''"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                        </div>

                        {{-- Input --}}
                        <input type="text" name="q"
                            placeholder="Cari produk sepatu..."
                            class="flex-1 h-full px-3 text-[12px] text-[#000039] bg-transparent outline-none placeholder-[#000039]/30"
                            style="font-family: 'Plus Jakarta Sans', sans-serif;" />

                        <input type="hidden" name="filter" :value="selectedCategory !== 'Semua' ? selectedCategory : ''" />

                        {{-- Tombol Cari --}}
                        <button type="submit"
                            class="h-full px-5 text-[12px] font-bold text-white bg-[#000039] rounded-full transition-all hover:bg-[#000039]/85 active:scale-95 shrink-0"
                            style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Cari
                        </button>

                    </form>
                </div>

                {{-- ACTION ICONS --}}
                <div class="flex items-center gap-2 shrink-0">

                    {{-- Icon Search (saat scrolled) --}}
                    <a x-show="scrolled"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-75"
                        x-transition:enter-end="opacity-100 scale-100"
                        href="{{ route('search') }}"
                        class="w-[38px] h-[38px] flex items-center justify-center rounded-full border border-[#000039]/20 bg-[#000039]/8 text-[#000039]/70 hover:text-[#000039] hover:bg-[#000039]/15 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[16px] h-[16px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </a>

                    {{-- Wishlist --}}
                    <a href="{{ route('wishlist') }}"
                        class="flex items-center justify-center rounded-full border border-[#000039]/20 bg-[#000039]/8 text-[#000039]/70 hover:text-[#000039] hover:bg-[#000039]/15 transition-all duration-300"
                        :class="scrolled ? 'w-[38px] h-[38px]' : 'w-[44px] h-[44px]'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                            :class="scrolled ? 'w-[16px] h-[16px]' : 'w-[20px] h-[20px]'">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                        </svg>
                    </a>

                    {{-- Cart --}}
                    <a href="{{ route('cart') }}"
                        class="relative flex items-center justify-center rounded-full border border-[#000039]/20 bg-[#000039]/8 text-[#000039]/70 hover:text-[#000039] hover:bg-[#000039]/15 transition-all duration-300"
                        :class="scrolled ? 'w-[38px] h-[38px]' : 'w-[44px] h-[44px]'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            :class="scrolled ? 'w-[15px] h-[15px]' : 'w-[18px] h-[18px]'">
                            <circle cx="8" cy="21" r="1" />
                            <circle cx="19" cy="21" r="1" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M2.05 2H5l2.4 11.39A2 2 0 0 0 9.35 15h8.75a2 2 0 0 0 1.95-1.57L22 6H6" />
                        </svg>
                        <span x-show="cartCount > 0"
                            class="absolute -top-1 -right-1 bg-red-500 text-white font-bold rounded-full flex items-center justify-center"
                            :class="scrolled ? 'w-[14px] h-[14px] text-[8px]' : 'w-[16px] h-[16px] text-[9px]'"
                            x-text="cartCount > 99 ? '99+' : cartCount">
                        </span>
                    </a>

                    {{-- Akun --}}
                    @if (session('customer_id'))
                        <a href="{{ route('account') }}"
                            class="flex items-center justify-center rounded-full bg-[#000039] text-white transition-all duration-300 hover:scale-105 hover:bg-[#000039]/85"
                            :class="scrolled ? 'w-[38px] h-[38px]' : 'w-[44px] h-[44px]'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                :class="scrolled ? 'w-[16px] h-[16px]' : 'w-[20px] h-[20px]'">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('customer.login') }}"
                            class="flex items-center justify-center rounded-full bg-[#000039] text-white transition-all duration-300 hover:scale-105 hover:bg-[#000039]/85"
                            :class="scrolled ? 'w-[38px] h-[38px]' : 'w-[44px] h-[44px]'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                :class="scrolled ? 'w-[16px] h-[16px]' : 'w-[20px] h-[20px]'">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </a>
                    @endif

                </div>
                {{-- /ACTION ICONS --}}

            </div>
        </div>

        {{-- ===== SECONDARY NAV ===== --}}
        <div class="transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"
            :class="scrolled ? 'max-h-0 opacity-0 overflow-hidden' : 'max-h-[300px] opacity-100 overflow-visible'">
            <div class="bg-white/90 backdrop-blur-xl border-b border-[#000039]/10 max-w-full overflow-visible">
                <div class="max-w-[1280px] mx-auto px-6 flex items-center justify-between scrollbar-hide overflow-visible">

                    {{-- KIRI: Nav Links --}}
                    <div class="flex items-center">
                        @foreach ($navLinks as $link)
                            <a href="{{ $link['url'] }}"
                                class="flex items-center px-4 py-2.5 text-[12px] font-semibold text-[#000039]/45 hover:text-[#000039]/90 transition-all whitespace-nowrap border-b-2 border-transparent hover:border-[#000039]/30"
                                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>

                    {{-- KANAN: Gender + Language --}}
                    <div class="flex items-center gap-1.5 shrink-0 py-1">

                        {{-- GENDER DROPDOWN --}}
                        <div class="relative" @click.outside="genderOpen = false">
                            <button type="button"
                                @click.stop="genderOpen = !genderOpen; langOpen = false; categoryOpen = false"
                                class="h-[30px] flex items-center gap-1.5 px-3 text-[11px] font-semibold text-[#000039]/60 border border-[#000039]/20 bg-[#000039]/5 rounded-full hover:text-[#000039] hover:bg-[#000039]/10 transition whitespace-nowrap"
                                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <span x-text="selectedGender"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 transition-transform duration-200"
                                    :class="genderOpen ? 'rotate-180' : ''"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            {{-- Dropdown ke BAWAH --}}
                            <div x-show="genderOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-1"
                                class="absolute top-full right-0 mt-2 w-36 bg-white border border-[#000039]/15 rounded-xl overflow-hidden z-[200] shadow-lg shadow-[#000039]/10">

                                <button type="button"
                                    @click="selectedGender = 'Kategori Usia'; genderOpen = false"
                                    class="w-full text-left px-4 py-2.5 text-[12px] font-medium hover:bg-[#000039]/10 hover:text-[#000039] transition-colors duration-100 cursor-pointer"
                                    :class="selectedGender === 'Kategori Usia' ? 'bg-[#000039]/8 text-[#000039] font-semibold' : 'text-[#000039]/60'"
                                    style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    Semua Usia
                                </button>

                                <template x-for="g in genders" :key="g.label">
                                    <a :href="g.route"
                                        @click="selectedGender = g.label; genderOpen = false"
                                        class="block px-4 py-2.5 text-[12px] font-medium hover:bg-[#000039]/10 hover:text-[#000039] transition-colors duration-100 cursor-pointer"
                                        :class="selectedGender === g.label ? 'bg-[#000039]/8 text-[#000039] font-semibold' : 'text-[#000039]/60'"
                                        style="font-family: 'Plus Jakarta Sans', sans-serif;"
                                        x-text="g.label">
                                    </a>
                                </template>

                            </div>
                        </div>

                        {{-- LANGUAGE DROPDOWN --}}
                        <div class="relative" @click.outside="langOpen = false">
                            <button type="button"
                                x-ref="langBtn"
                                @click.stop="
                                    langOpen = !langOpen;
                                    genderOpen = false;
                                    categoryOpen = false;
                                    if (langOpen) {
                                        const r = $refs.langBtn.getBoundingClientRect();
                                        $refs.langDropdown.style.top = (r.bottom + 8) + 'px';
                                        $refs.langDropdown.style.left = (r.right - 160) + 'px';
                                    }
                                "
                                class="h-[30px] flex items-center gap-1.5 px-3 text-[11px] font-semibold text-[#000039]/60 border border-[#000039]/20 bg-[#000039]/5 rounded-full hover:text-[#000039] hover:bg-[#000039]/10 transition whitespace-nowrap"
                                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[13px] h-[13px] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                </svg>
                                <span x-text="selectedLang"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 transition-transform duration-200"
                                    :class="langOpen ? 'rotate-180' : ''"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                        </div>

                    </div>
                    {{-- /KANAN --}}

                </div>
            </div>
        </div>

    </div>


    {{-- Dropdown Kategori TELEPORTED — fixed position, di luar semua stacking context --}}
    <div x-ref="catDropdown"
        x-show="categoryOpen"
        @click.outside="categoryOpen = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        style="position:fixed; z-index:9999;"
        class="w-44 bg-white border border-[#000039]/15 rounded-xl overflow-hidden shadow-lg shadow-[#000039]/10">

        <button type="button"
            @click="selectedCategory = 'Kategori'; selectedRoute = '{{ $routeAllProducts }}'; categoryOpen = false"
            class="w-full text-left px-4 py-2.5 text-[12px] font-medium hover:bg-[#000039]/10 hover:text-[#000039] transition-colors duration-100 cursor-pointer"
            :class="selectedCategory === 'Kategori' ? 'bg-[#000039]/8 text-[#000039] font-semibold' : 'text-[#000039]/60'"
            style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Semua Kategori
        </button>

        <template x-for="cat in categories" :key="cat.label">
            <button type="button"
                @click="selectedCategory = cat.label; selectedRoute = cat.route; categoryOpen = false; window.location.href = cat.route"
                class="w-full text-left px-4 py-2.5 text-[12px] font-medium hover:bg-[#000039]/10 hover:text-[#000039] transition-colors duration-100 cursor-pointer"
                :class="selectedCategory === cat.label ? 'bg-[#000039]/8 text-[#000039] font-semibold' : 'text-[#000039]/60'"
                style="font-family: 'Plus Jakarta Sans', sans-serif;"
                x-text="cat.label">
            </button>
        </template>

    </div>


    {{-- Language Dropdown TELEPORTED --}}
    <div x-ref="langDropdown"
        x-show="langOpen"
        @click.outside="langOpen = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        style="position:fixed; z-index:9999;"
        class="w-40 bg-white border border-[#000039]/15 rounded-xl overflow-hidden shadow-lg shadow-[#000039]/10">

        <button type="button"
            @click="switchLang('ID')"
            class="w-full text-left px-4 py-2.5 text-[12px] font-medium hover:bg-[#000039]/10 hover:text-[#000039] transition-colors duration-100 cursor-pointer flex items-center gap-2"
            :class="selectedLang === 'ID' ? 'bg-[#000039]/8 text-[#000039] font-semibold' : 'text-[#000039]/60'"
            style="font-family: 'Plus Jakarta Sans', sans-serif;">
            <span>🇮🇩</span> Indonesia
        </button>

        <button type="button"
            @click="switchLang('EN')"
            class="w-full text-left px-4 py-2.5 text-[12px] font-medium hover:bg-[#000039]/10 hover:text-[#000039] transition-colors duration-100 cursor-pointer flex items-center gap-2"
            :class="selectedLang === 'EN' ? 'bg-[#000039]/8 text-[#000039] font-semibold' : 'text-[#000039]/60'"
            style="font-family: 'Plus Jakarta Sans', sans-serif;">
            <span>🇬🇧</span> English
        </button>

    </div>

</header>

{{-- Spacer --}}
<div class="h-[112px]"></div>