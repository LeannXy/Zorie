<section class="bg-[#f5f5f3] py-16 overflow-hidden" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="max-w-[1280px] mx-auto px-5 space-y-16">

        {{-- ===== HEADER ===== --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            <div>
                <p class="text-[12px] tracking-[4px] uppercase text-[#000039]/50 font-semibold">Koleksi Trending</p>
                <h2 class="text-[48px] md:text-[58px] leading-none tracking-[-3px] font-black text-[#000039] mt-2">
                    Penjualan Terbaik</h2>
            </div>
            <a href="{{ route('all-products') }}"
                class="inline-flex items-center gap-2 px-6 py-3 border border-[#000039]/20 rounded-full text-[13px] font-semibold text-[#000039]/70 hover:bg-[#000039] hover:text-white hover:border-[#000039] transition-all duration-300">

                Lihat Semua

            </a>
        </div>

        @foreach ($featuredCategories as $category)
            @php

                $mainBanner = $category->banners->where('banner_type', 'main')->first();

                $secondaryBanners = $category->banners->where('banner_type', 'secondary')->take(2)->values();

                $banners = collect();

                if ($mainBanner) {
                    $banners->push($mainBanner);
                }

                foreach ($secondaryBanners as $banner) {
                    $banners->push($banner);
                }

            @endphp
            <div class="space-y-6">

                {{-- CATEGORY HEADING --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-1 h-8 bg-[#000039] rounded-full"></div>
                        <h3 class="text-[28px] font-black tracking-[-1.5px] text-[#000039]">{{ $category->name }}</h3>
                    </div>
                    <a href="{{ route('all-products', [
                        'category' => $category->slug,
                    ]) }}"
                        class="text-[12px] font-semibold text-[#000039]/50 hover:text-[#000039] transition-colors flex items-center gap-1.5">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                {{-- BANNERS --}}


                <div
                    class=" grid gap-4 @if (count($banners) === 3) grid-cols-[2fr_1fr_1fr] @elseif(count($banners) === 2)     grid-cols-[2fr_1fr] @else     grid-cols-1 @endif">

                    @foreach ($banners as $banner)
                        <a href="{{ route('all-products', [
                            'category' => $category->slug,
                        ]) }}"
                            class="block">

                            <div
                                class="relative bg-[#000039] rounded-[8px] overflow-hidden h-[160px] flex items-center px-7 hover:scale-[1.02] transition-all duration-300">

                                <div class="relative z-10 flex-1">

                                    <h4 class=" text-[20px] font-black text-white">

                                        {{ $banner->title }}

                                    </h4>

                                    <p class=" text-[11px] text-white/60 mt-2 mb-3">

                                        {{ $banner->subtitle }}

                                    </p>

                                    <span
                                        class=" inline-flex items-center gap-2 text-[11px] font-bold px-4 py-2 rounded-full bg-white   text-[#000039]">

                                        {{ $banner->button_text }}

                                    </span>

                                </div>

                                @if ($banner->image)
                                    <div class="  absolute  right-0  bottom-0  h-full  w-[160px]">

                                        <img src="{{ asset('storage/' . $banner->image) }}"
                                            class=" h-full w-full object-cover">

                                    </div>
                                @endif

                            </div>
                        </a>
                    @endforeach

                </div>

                {{-- PRODUCTS GRID --}}

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">


                    @foreach ($category->products->take(4) as $product)
                        <div
                            class="group bg-white border border-[#ececec] rounded-[12px] overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <a href="{{ route('product.show', $product->id) }}">
                                <div
                                    class="relative bg-[#fafafa] h-[220px] flex items-center justify-center overflow-hidden">

                                    <img src="{{ $product->images->first()
                                        ? asset('storage/' . $product->images->first()->image)
                                        : asset('images/no-image.png') }}"
                                        class="w-[180px] h-[160px] object-cover transition duration-300 group-hover:scale-105">

                                </div>
                            </a>
                            <a href="{{ route('product.show', $product->id) }}" class="block">
                                <div class="px-5 pb-5 pt-4">

                                    <p class="text-[10px] tracking-[2px] uppercase text-[#000039]/40 font-semibold">

                                        {{ $product->categories->first()?->name }}

                                    </p>

                                    <h3 class="mt-2 text-[17px] font-bold text-[#000039]">

                                        {{ $product->name }}

                                    </h3>

                                    <div class="flex items-center justify-between mt-4">

                                        <p class="text-[20px] font-black text-[#000039]">

                                            Rp {{ number_format($product->price, 0, ',', '.') }}

                                        </p>

                                        <a href="{{ route('product.show', $product->id) }}"
                                            class=" w-[42px] h-[42px] rounded-md bg-[#000039] flex items-center justify-center hover:bg-[#000039]/80 transition-all">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">

                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4" />

                                            </svg>

                                        </a>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endforeach


                </div>

            </div>
        @endforeach
    </div>



</section>
