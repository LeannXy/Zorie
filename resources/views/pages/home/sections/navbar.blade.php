<header
    x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 60)"
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
                    <button
                        class="flex items-center justify-center rounded-full border border-[#ececec] bg-white transition-all duration-500 hover:bg-[#f8f8f8]"

                        :class="scrolled
                            ? 'w-[38px] h-[38px]'
                            : 'w-[46px] h-[46px]'"
                    >

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="text-[#777] transition-all duration-500"

                            :class="scrolled
                                ? 'w-[15px] h-[15px]'
                                : 'w-[17px] h-[17px]'"

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"
                            />

                        </svg>

                    </button>

                    {{-- MENU --}}
                    <button
                        class="rounded-full bg-black flex items-center justify-center transition-all duration-500 hover:scale-105"

                        :class="scrolled
                            ? 'w-[38px] h-[38px]'
                            : 'w-[46px] h-[46px]'"
                    >

                        <div class="relative flex flex-col items-center justify-center">

                            <span
                                class="bg-white rounded-full transition-all duration-500"

                                :class="scrolled
                                    ? 'w-[13px] h-[1.5px]'
                                    : 'w-[15px] h-[1.7px]'"
                            ></span>

                            <span
                                class="bg-white rounded-full transition-all duration-500 mt-[4px]"

                                :class="scrolled
                                    ? 'w-[13px] h-[1.5px]'
                                    : 'w-[15px] h-[1.7px]'"
                            ></span>

                        </div>

                    </button>

                </div>

            </div>

        </div>

    </div>

</header>