<header
    x-data="{ scrolled: false, cartCount: 0 }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 60);
             fetch('{{ route('cart.count') }}')
                .then(r => r.json())
                .then(d => cartCount = d.count);"
    class="fixed top-0 left-0 w-full z-50 pointer-events-none"
>

    {{-- CONTAINER --}}
    <div
        class="mx-auto mt-4 transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] pointer-events-auto"

        :class="scrolled
            ? 'max-w-[360px]'
            : 'max-w-[1280px]'"
    >

        {{-- NAVBAR --}}
        <div
            class="bg-white/80 backdrop-blur-2xl border border-[#ececec] shadow-[0_10px_40px_rgba(0,0,0,0.05)] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"

            :class="scrolled
                ? 'rounded-full h-[56px] px-3'
                : 'rounded-[30px] h-[88px] px-6'"
        >

            <div class="flex items-center justify-between h-full">

                {{-- LEFT --}}
                <div class="flex items-center">

                    {{-- LOGO --}}
                    <a href="/" class="shrink-0">

                        <h1
                            class="leading-none text-[#111] transition-all duration-500 font-[800] tracking-[-2px] uppercase"

                            style="font-family: 'Plus Jakarta Sans', sans-serif;"

                            :class="scrolled
                                ? 'text-[26px]'
                                : 'text-[48px]'"
                        >
                            ZORIE
                        </h1>

                    </a>

                    {{-- NAVIGATION --}}
                    <nav
                        class="hidden lg:flex items-center transition-all duration-300 overflow-hidden"

                        :class="scrolled
                            ? 'opacity-0 w-0 ml-0'
                            : 'opacity-100 w-auto ml-16 gap-10'"
                    >

                        <a href="#"
                            class="text-[15px] font-semibold tracking-[-0.2px] text-[#111] hover:opacity-50 transition-all">

                            MEN

                        </a>

                        <a href="#"
                            class="text-[15px] font-semibold tracking-[-0.2px] text-[#111] hover:opacity-50 transition-all">

                            WOMEN

                        </a>

                        <a href="#"
                            class="text-[15px] font-semibold tracking-[-0.2px] text-[#111] hover:opacity-50 transition-all">

                            KIDS

                        </a>

                        <a href="#"
                            class="text-[15px] font-semibold tracking-[-0.2px] text-[#111] hover:opacity-50 transition-all">

                            SALE

                        </a>

                        <a href="#"
                            class="text-[15px] font-semibold tracking-[-0.2px] text-[#111] hover:opacity-50 transition-all">

                            ABOUT

                        </a>

                    </nav>

                </div>

                {{-- RIGHT --}}
                <div
                    class="flex items-center transition-all duration-500"

                    :class="scrolled
                        ? 'gap-1.5'
                        : 'gap-3'"
                >

                    {{-- SEARCH --}}
                    <a 
                        href="{{ route('search') }}"
                        class="flex items-center justify-center rounded-full border border-[#ececec] bg-white transition-all duration-500 hover:bg-[#f8f8f8]"

                        :class="scrolled
                            ? 'w-[38px] h-[38px]'
                            : 'w-[46px] h-[46px]'"
                    >

                                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-[#777] transition-all duration-500"
                            :class="scrolled
                                ? 'w-[18px] h-[18px]'
                                : 'w-[22px] h-[22px]'">

                            <path d="m21 21-4.34-4.34"/>
                            <circle cx="11" cy="11" r="8"/>

                        </svg>

                                            </a>

                    {{-- WISHLIST --}}
                    <a 
                        href="{{ route('wishlist') }}"
                        class="flex items-center justify-center rounded-full border border-[#ececec] bg-white transition-all duration-500 hover:bg-[#f8f8f8]"

                        :class="scrolled
                            ? 'w-[38px] h-[38px]'
                            : 'w-[46px] h-[46px]'"
                    >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="text-[#777] transition-all duration-500"
                        :class="scrolled
                            ? 'w-[18px] h-[18px]'
                            : 'w-[22px] h-[22px]'">

                        <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"/>

                    </svg>
                    </a>

            {{-- CART --}}
            <a
                href="{{ route('cart') }}"
                class="relative rounded-full border border-[#ececec] bg-white flex items-center justify-center transition-all duration-500 hover:bg-[#f8f8f8]"

                :class="scrolled
                    ? 'w-[38px] h-[38px]'
                    : 'w-[46px] h-[46px]'"
            >

                <svg 
                    xmlns="http://www.w3.org/2000/svg"
                    class="text-[#777] transition-all duration-500"
                    :class="scrolled
                        ? 'w-[15px] h-[15px]'
                        : 'w-[17px] h-[17px]'"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <circle cx="8" cy="21" r="1"/>
                    <circle cx="19" cy="21" r="1"/>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M2.05 2H5l2.4 11.39A2 2 0 0 0 9.35 15h8.75a2 2 0 0 0 1.95-1.57L22 6H6"/>

                </svg>

                {{-- Badge --}}
                <span
                    x-show="cartCount > 0"
                    class="absolute bg-red-500 text-white rounded-full flex items-center justify-center font-medium"
                    :class="scrolled
                        ? '-top-1 -right-1 w-4 h-4 text-[9px]'
                        : '-top-1 -right-1 w-5 h-5 text-[10px]'"
                    x-text="cartCount">
                </span>

            </a>

            {{-- ACCOUNT --}}
            <a
                href="{{ route('account') }}"
                class="flex items-center justify-center rounded-full bg-black transition-all duration-500 hover:scale-105"

                :class="scrolled
                    ? 'w-[38px] h-[38px]'
                    : 'w-[46px] h-[46px]'"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="text-white transition-all duration-500"
                    :class="scrolled
                        ? 'w-[18px] h-[18px]'
                        : 'w-[22px] h-[22px]'">

                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>

                </svg>

            </a>

                </div>

            </div>

        </div>

    </div>

</header>