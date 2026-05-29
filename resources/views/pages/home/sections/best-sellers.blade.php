<section class="bg-[#f5f5f3] py-16 overflow-hidden">

    <div class="max-w-[1280px] mx-auto px-5">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-12">

            {{-- LEFT --}}
            <div>

                <p class="text-[13px] tracking-[4px] uppercase text-[#8d8d8d] font-semibold">

                    Trending Collection

                </p>

                <h2 class="text-[44px] md:text-[58px] leading-none tracking-[-3px] font-black text-[#111] mt-3">

                    Best Sellers

                </h2>

            </div>

            {{-- FILTERS --}}
            <div class="flex flex-wrap items-center gap-3">

                <button class="h-[48px] px-7 rounded-full bg-black text-white text-[15px] font-semibold">
                    All
                </button>

                <button class="h-[48px] px-7 rounded-full border border-[#dddddd] bg-white text-[#111] text-[15px] font-semibold hover:bg-black hover:text-white transition-all duration-300">
                    Sneakers
                </button>

                <button class="h-[48px] px-7 rounded-full border border-[#dddddd] bg-white text-[#111] text-[15px] font-semibold hover:bg-black hover:text-white transition-all duration-300">
                    Running
                </button>

                <button class="h-[48px] px-7 rounded-full border border-[#dddddd] bg-white text-[#111] text-[15px] font-semibold hover:bg-black hover:text-white transition-all duration-300">
                    Casual
                </button>

                <button class="h-[48px] px-7 rounded-full border border-[#dddddd] bg-white text-[#111] text-[15px] font-semibold hover:bg-black hover:text-white transition-all duration-300">
                    Sport
                </button>

            </div>

        </div>

        {{-- PRODUCTS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @php

                $products = [

                    [
                        'name' => 'Stride Sneakers',
                        'category' => 'Running Shoes',
                        'price' => '$49.00',
                        'old' => '$65.00',
                        'rating' => '4.8',
                        'badge' => 'HOT',
                        'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff'
                    ],

                    [
                        'name' => 'Thrive Oxford',
                        'category' => 'Formal Shoes',
                        'price' => '$69.00',
                        'old' => '$85.00',
                        'rating' => '4.7',
                        'badge' => 'NEW',
                        'image' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4'
                    ],

                    [
                        'name' => 'Stalison Boot',
                        'category' => 'Winter Collection',
                        'price' => '$80.00',
                        'old' => '$100.00',
                        'rating' => '4.7',
                        'badge' => 'SALE',
                        'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77'
                    ],

                    [
                        'name' => 'Zurik Sports',
                        'category' => 'Sport Edition',
                        'price' => '$39.00',
                        'old' => '$55.00',
                        'rating' => '4.8',
                        'badge' => 'TREND',
                        'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519'
                    ],

                    [
                        'name' => 'Air Flex Run',
                        'category' => 'Performance',
                        'price' => '$74.00',
                        'old' => '$95.00',
                        'rating' => '4.9',
                        'badge' => 'BEST',
                        'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'
                    ],

                    [
                        'name' => 'Urban Street',
                        'category' => 'Casual',
                        'price' => '$54.00',
                        'old' => '$70.00',
                        'rating' => '4.6',
                        'badge' => 'NEW',
                        'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772'
                    ],

                    [
                        'name' => 'Neo Runner',
                        'category' => 'Running',
                        'price' => '$64.00',
                        'old' => '$88.00',
                        'rating' => '4.8',
                        'badge' => 'HOT',
                        'image' => 'https://images.unsplash.com/photo-1514996937319-344454492b37'
                    ],

                    [
                        'name' => 'Classic Leather',
                        'category' => 'Premium',
                        'price' => '$99.00',
                        'old' => '$120.00',
                        'rating' => '5.0',
                        'badge' => 'LUX',
                        'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5'
                    ]

                ];

            @endphp

            @foreach ($products as $product)

                <div class="group bg-white border border-[#ececec] rounded-[30px] overflow-hidden hover:shadow-[0_20px_60px_rgba(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-500">

                    {{-- IMAGE --}}
                    <div class="relative bg-[#fafafa] h-[280px] flex items-center justify-center overflow-hidden">

                        {{-- BADGE --}}
                        <div class="absolute top-5 left-5 z-20 bg-black text-white text-[11px] tracking-[2px] font-bold px-4 py-2 rounded-full">

                            {{ $product['badge'] }}

                        </div>

                        {{-- WISHLIST --}}
                        <button class="absolute top-5 right-5 z-20 w-11 h-11 rounded-full bg-white border border-[#e7e7e7] flex items-center justify-center hover:bg-black hover:text-white transition-all duration-300">

                            ♡

                        </button>

                        {{-- PRODUCT IMAGE --}}
                        <img
                            src="{{ $product['image'] }}"
                            class="w-[240px] object-contain group-hover:scale-110 group-hover:rotate-[-8deg] transition-all duration-700"
                        >

                    </div>

                    {{-- CONTENT --}}
                    <div class="px-5 pb-5 pt-4">

                        {{-- TOP --}}
                        <div class="flex items-start justify-between gap-3">

                            <div>

                                {{-- CATEGORY --}}
                                <p class="text-[11px] tracking-[2px] uppercase text-[#9b9b9b] font-semibold">

                                    {{ $product['category'] }}

                                </p>

                                {{-- TITLE --}}
                                <h3 class="text-[22px] leading-[1.05] tracking-[-1px] font-semibold text-[#111] mt-2">

                                    {{ $product['name'] }}

                                </h3>

                            </div>

                            {{-- RATING --}}
                            <div class="flex items-center gap-1 mt-1 shrink-0">

                                <span class="text-[#ffb800] text-[12px]">★</span>

                                <span class="text-[14px] font-medium text-[#111]">

                                    {{ $product['rating'] }}

                                </span>

                            </div>

                        </div>

                        {{-- DESCRIPTION --}}
                        <p class="mt-4 text-[14px] leading-[1.7] text-[#7d7d7d]">

                            Premium comfort sneakers crafted for everyday movement and modern streetwear style.

                        </p>

                        {{-- BOTTOM --}}
                        <div class="flex items-center justify-between mt-6">

                            {{-- PRICE --}}
                            <div class="flex flex-col">

                                <div class="flex items-center gap-3">

                                    <p class="text-[30px] tracking-[-1px] leading-none font-bold text-[#111]">

                                        {{ $product['price'] }}

                                    </p>

                                    <p class="text-[16px] text-[#aaaaaa] line-through mt-[4px]">

                                        {{ $product['old'] }}

                                    </p>

                                </div>

                                {{-- STOCK --}}
                                <p class="text-[12px] text-[#8f8f8f] mt-2">

                                    In stock • Free shipping

                                </p>

                            </div>

                            {{-- ACTION --}}
                            <button class="group w-[52px] h-[52px] rounded-full bg-black flex items-center justify-center hover:scale-110 transition-all duration-300">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-white group-hover:rotate-90 transition-all duration-300"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4v16m8-8H4"
                                    />

                                </svg>

                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>