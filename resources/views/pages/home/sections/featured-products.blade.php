<section class="bg-[#f5f5f3] pb-24">

    <div class="max-w-[1280px] mx-auto px-5">

        {{-- TOP PRODUCTS --}}
        <div class="grid grid-cols-4 gap-5">

            @php

            $featured = [

                [
                    'name' => 'FV-Ivy League',
                    'type' => 'Casual Sneakers',
                    'price' => 'Rs8,999',
                    'image' => 'https://freepngimg.com/save/10183-shoe-png-image/1200x900',
                ],

                [
                    'name' => 'CA Pro Lux',
                    'type' => 'Lace-Up Sneakers',
                    'price' => 'Rs6,799',
                    'image' => 'https://freepngimg.com/save/10177-shoe-png-image/1200x900',
                ],

                [
                    'name' => 'RS-X Brand',
                    'type' => 'Unisex Sneakers',
                    'price' => 'Rs10,999',
                    'image' => 'https://freepngimg.com/save/10190-shoe-png-image/1200x900',
                ],

                [
                    'name' => 'X-Cel Nova',
                    'type' => 'Running Shoes',
                    'price' => 'Rs12,999',
                    'image' => 'https://freepngimg.com/save/10191-shoe-png-image/1200x900',
                ],

            ];

        @endphp

            @foreach ($featured as $item)

                <div
                    class="group relative bg-white border border-[#ececec]
                    rounded-[28px] p-5 overflow-hidden
                    hover:border-[#dcdcdc]
                    hover:-translate-y-1
                    hover:shadow-[0_18px_40px_rgba(0,0,0,0.04)]
                    transition-all duration-500"
                >

                    {{-- SOFT BG --}}
                    <div
                        class="absolute inset-0
                        bg-gradient-to-b from-white to-[#fafafa]
                        opacity-0 group-hover:opacity-100
                        transition-all duration-500"
                    ></div>

                    <div class="relative z-10">

                        {{-- IMAGE --}}
                        <div
                            class="h-[170px]
                            flex items-center justify-center"
                        >

                            <img
                                src="{{ $item['image'] }}"
                                class="w-[220px]
                                object-contain
                                group-hover:scale-105
                                group-hover:rotate-[-4deg]
                                transition-all duration-700"
                            >

                        </div>

                        {{-- CONTENT --}}
                        <div class="mt-3">

                            {{-- BRAND --}}
                            <p
                                class="text-[11px]
                                tracking-[2px]
                                uppercase
                                text-[#9b9b9b]
                                font-semibold"
                            >
                                ZORIE
                            </p>

                            {{-- TITLE --}}
                            <h3
                                class="mt-2
                                text-[22px]
                                leading-[1]
                                tracking-[-1px]
                                font-semibold
                                text-[#111]"
                                style="font-family: 'Plus Jakarta Sans', sans-serif;"
                            >
                                {{ $item['name'] }}
                            </h3>

                            {{-- TYPE --}}
                            <p
                                class="mt-3
                                text-[15px]
                                leading-[1.6]
                                text-[#777]"
                            >
                                {{ $item['type'] }}
                            </p>

                            {{-- BOTTOM --}}
                            <div
                                class="mt-6
                                flex items-end justify-between"
                            >

                                {{-- PRICE --}}
                                <div>

                                    <p
                                        class="text-[26px]
                                        tracking-[-1px]
                                        font-bold
                                        text-[#111]"
                                    >
                                        {{ $item['price'] }}
                                    </p>

                                    {{-- STARS --}}
                                    <div class="flex items-center gap-1 mt-2">

                                        <span class="text-[#111] text-[12px]">★</span>
                                        <span class="text-[#111] text-[12px]">★</span>
                                        <span class="text-[#111] text-[12px]">★</span>
                                        <span class="text-[#111] text-[12px]">★</span>
                                        <span class="text-[#cfcfcf] text-[12px]">★</span>

                                    </div>

                                </div>

                                {{-- BUTTON --}}
                                <button
                                    class="w-[44px] h-[44px]
                                    rounded-full
                                    border border-[#d9d9d9]
                                    flex items-center justify-center
                                    hover:bg-black
                                    hover:border-black
                                    hover:text-white
                                    transition-all duration-300"
                                >

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M12 4v16m8-8H4"
                                        />

                                    </svg>

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>