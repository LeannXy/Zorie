<section class="bg-[#f5f5f3] py-16 overflow-hidden" style="font-family: 'Plus Jakarta Sans', sans-serif;">
<div class="max-w-[1280px] mx-auto px-5 space-y-16">

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
        <div>
            <p class="text-[12px] tracking-[4px] uppercase text-[#000039]/50 font-semibold">Koleksi Trending</p>
            <h2 class="text-[48px] md:text-[58px] leading-none tracking-[-3px] font-black text-[#000039] mt-2">Penjualan Terbaik</h2>
        </div>
        <a href="{{ route('all-products') }}"
            class="inline-flex items-center gap-2 px-6 py-3 border border-[#000039]/20 rounded-full text-[13px] font-semibold text-[#000039]/70 hover:bg-[#000039] hover:text-white hover:border-[#000039] transition-all duration-300 self-start lg:self-auto">
            Lihat Semua
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
        </a>
    </div>

    @php
    $categories = [

        /* ===== SPORTS ===== */
        [
            'label' => 'Sports',
            'route' => route('all-products', ['filter' => 'Sport']),
            'banners' => [
                [
                    'bg'      => 'bg-[#000039]',
                    'tag'     => 'Koleksi Olahraga',
                    'title'   => 'Performa Tanpa Batas',
                    'desc'    => 'Diskon 20% untuk semua produk Sport',
                    'cta'     => 'Belanja Sekarang',
                    'img'     => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300&q=80',
                    'accent'  => 'bg-white text-[#000039]',
                    'text'    => 'text-white',
                    'subtxt'  => 'text-white/60',
                    'wide'    => true,
                ],
                [
                    'bg'      => 'bg-[#e8f0fe]',
                    'tag'     => 'Flash Sale',
                    'title'   => 'Gratis Ongkir',
                    'desc'    => 'Untuk semua produk Sport',
                    'cta'     => 'Klaim Sekarang',
                    'img'     => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=300&q=80',
                    'accent'  => 'bg-[#000039] text-white',
                    'text'    => 'text-[#000039]',
                    'subtxt'  => 'text-[#000039]/60',
                    'wide'    => false,
                ],
                [
                    'bg'      => 'bg-[#fff3e0]',
                    'tag'     => 'Member Only',
                    'title'   => 'Buy 1 Get 1',
                    'desc'    => 'Khusus member Sport Club',
                    'cta'     => 'Daftar Member',
                    'img'     => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=300&q=80',
                    'accent'  => 'bg-[#000039] text-white',
                    'text'    => 'text-[#000039]',
                    'subtxt'  => 'text-[#000039]/60',
                    'wide'    => false,
                ],
            ],
            'products' => [
                ['name'=>'Air Flex Run','category'=>'Performa','price'=>'Rp1.110.000','old'=>'Rp1.425.000','rating'=>'4.9','badge'=>'BEST','image'=>'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=400&q=80'],
                ['name'=>'Zurik Sports','category'=>'Olahraga','price'=>'Rp585.000','old'=>'Rp825.000','rating'=>'4.8','badge'=>'HOT','image'=>'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=400&q=80'],
                ['name'=>'Stride Runner','category'=>'Lari','price'=>'Rp735.000','old'=>'Rp975.000','rating'=>'4.8','badge'=>'SALE','image'=>'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=80'],
                ['name'=>'Neo Runner','category'=>'Lari','price'=>'Rp960.000','old'=>'Rp1.320.000','rating'=>'4.8','badge'=>'NEW','image'=>'https://images.unsplash.com/photo-1514996937319-344454492b37?w=400&q=80'],
            ],
        ],

        /* ===== SNEAKERS ===== */
        [
            'label' => 'Sneakers',
            'route' => route('all-products', ['filter' => 'Sneakers']),
            'banners' => [
                [
                    'bg'      => 'bg-[#1a1a2e]',
                    'tag'     => 'Street Style',
                    'title'   => 'Sneakers Pilihan',
                    'desc'    => 'Koleksi eksklusif sneakers terbaru',
                    'cta'     => 'Lihat Koleksi',
                    'img'     => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=300&q=80',
                    'accent'  => 'bg-white text-[#1a1a2e]',
                    'text'    => 'text-white',
                    'subtxt'  => 'text-white/60',
                    'wide'    => true,
                ],
                [
                    'bg'      => 'bg-[#fce4ec]',
                    'tag'     => 'Limited Edition',
                    'title'   => 'Stok Terbatas',
                    'desc'    => 'Hanya 200 pasang tersisa',
                    'cta'     => 'Beli Sekarang',
                    'img'     => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=300&q=80',
                    'accent'  => 'bg-[#000039] text-white',
                    'text'    => 'text-[#000039]',
                    'subtxt'  => 'text-[#000039]/60',
                    'wide'    => false,
                ],
            ],
            'products' => [
                ['name'=>'Urban Street','category'=>'Kasual','price'=>'Rp810.000','old'=>'Rp1.050.000','rating'=>'4.6','badge'=>'NEW','image'=>'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&q=80'],
                ['name'=>'Classic Leather','category'=>'Premium','price'=>'Rp1.485.000','old'=>'Rp1.800.000','rating'=>'5.0','badge'=>'LUX','image'=>'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=400&q=80'],
                ['name'=>'Stride Sneakers','category'=>'Streetwear','price'=>'Rp735.000','old'=>'Rp975.000','rating'=>'4.8','badge'=>'HOT','image'=>'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=80'],
                ['name'=>'Thrive Oxford','category'=>'Formal','price'=>'Rp1.035.000','old'=>'Rp1.275.000','rating'=>'4.7','badge'=>'TREND','image'=>'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?w=400&q=80'],
            ],
        ],

        /* ===== CASUAL ===== */
        [
            'label' => 'Casual',
            'route' => route('all-products', ['filter' => 'Casual']),
            'banners' => [
                [
                    'bg'      => 'bg-[#f3f0e8]',
                    'tag'     => 'Gaya Harian',
                    'title'   => 'Casual Every Day',
                    'desc'    => 'Nyaman dari pagi hingga malam',
                    'cta'     => 'Temukan Gayamu',
                    'img'     => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=300&q=80',
                    'accent'  => 'bg-[#000039] text-white',
                    'text'    => 'text-[#000039]',
                    'subtxt'  => 'text-[#000039]/60',
                    'wide'    => false,
                ],
                [
                    'bg'      => 'bg-[#000039]',
                    'tag'     => 'Promo Spesial',
                    'title'   => 'Diskon 30%',
                    'desc'    => 'Untuk semua koleksi Casual minggu ini',
                    'cta'     => 'Gunakan Promo',
                    'img'     => 'https://images.unsplash.com/photo-1514996937319-344454492b37?w=300&q=80',
                    'accent'  => 'bg-white text-[#000039]',
                    'text'    => 'text-white',
                    'subtxt'  => 'text-white/60',
                    'wide'    => true,
                ],
            ],
            'products' => [
                ['name'=>'Stalison Boot','category'=>'Winter','price'=>'Rp1.200.000','old'=>'Rp1.500.000','rating'=>'4.7','badge'=>'SALE','image'=>'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=400&q=80'],
                ['name'=>'Daily Comfort','category'=>'Kasual','price'=>'Rp620.000','old'=>'Rp850.000','rating'=>'4.6','badge'=>'NEW','image'=>'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=400&q=80'],
                ['name'=>'Thrive Slip-on','category'=>'Santai','price'=>'Rp490.000','old'=>'Rp680.000','rating'=>'4.5','badge'=>'HOT','image'=>'https://images.unsplash.com/photo-1514996937319-344454492b37?w=400&q=80'],
                ['name'=>'Weekend Walk','category'=>'Outdoor','price'=>'Rp875.000','old'=>'Rp1.100.000','rating'=>'4.7','badge'=>'BEST','image'=>'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=400&q=80'],
            ],
        ],

        /* ===== RUNNING ===== */
        [
            'label' => 'Running',
            'route' => route('all-products', ['filter' => 'Running']),
            'banners' => [
                [
                    'bg'      => 'bg-[#e8f5e9]',
                    'tag'     => 'Marathon Ready',
                    'title'   => 'Lari Lebih Jauh',
                    'desc'    => 'Teknologi sol terbaru untuk pelari sejati',
                    'cta'     => 'Mulai Berlari',
                    'img'     => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300&q=80',
                    'accent'  => 'bg-[#000039] text-white',
                    'text'    => 'text-[#000039]',
                    'subtxt'  => 'text-[#000039]/60',
                    'wide'    => false,
                ],
                [
                    'bg'      => 'bg-[#000039]',
                    'tag'     => 'Pro Series',
                    'title'   => 'Edisi Atlet',
                    'desc'    => 'Dipakai para juara lari nasional',
                    'cta'     => 'Lihat Seri Pro',
                    'img'     => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=300&q=80',
                    'accent'  => 'bg-white text-[#000039]',
                    'text'    => 'text-white',
                    'subtxt'  => 'text-white/60',
                    'wide'    => true,
                ],
            ],
            'products' => [
                ['name'=>'Speed Burst X','category'=>'Marathon','price'=>'Rp1.290.000','old'=>'Rp1.600.000','rating'=>'4.9','badge'=>'PRO','image'=>'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=80'],
                ['name'=>'Trail Master','category'=>'Trail Run','price'=>'Rp980.000','old'=>'Rp1.250.000','rating'=>'4.8','badge'=>'HOT','image'=>'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=400&q=80'],
                ['name'=>'Feather Light','category'=>'Ringan','price'=>'Rp860.000','old'=>'Rp1.100.000','rating'=>'4.8','badge'=>'NEW','image'=>'https://images.unsplash.com/photo-1514996937319-344454492b37?w=400&q=80'],
                ['name'=>'Enduro Pro','category'=>'Performa','price'=>'Rp1.150.000','old'=>'Rp1.450.000','rating'=>'5.0','badge'=>'BEST','image'=>'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=400&q=80'],
            ],
        ],
    ];
    @endphp

    @foreach ($categories as $cat)
    <div class="space-y-6">

        {{-- CATEGORY HEADING --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-1 h-8 bg-[#000039] rounded-full"></div>
                <h3 class="text-[28px] font-black tracking-[-1.5px] text-[#000039]">{{ $cat['label'] }}</h3>
            </div>
            <a href="{{ $cat['route'] }}"
                class="text-[12px] font-semibold text-[#000039]/50 hover:text-[#000039] transition-colors flex items-center gap-1.5">
                Lihat Semua {{ $cat['label'] }}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- BANNERS --}}
        @php
            $banners    = $cat['banners'];
            $wideFirst  = isset($banners[0]) && $banners[0]['wide'];
            $wideLast   = isset($banners[count($banners)-1]) && $banners[count($banners)-1]['wide'];
        @endphp

        <div class="grid gap-4
            @if(count($banners) === 3) grid-cols-[2fr_1fr_1fr]
            @elseif(count($banners) === 2 && $wideFirst) grid-cols-[2fr_1fr]
            @elseif(count($banners) === 2 && $wideLast) grid-cols-[1fr_2fr]
            @else grid-cols-{{ count($banners) }}
            @endif">

            @foreach ($banners as $banner)
            <div class="relative {{ $banner['bg'] }} rounded-[8px] overflow-hidden h-[160px] flex items-center px-7 group cursor-pointer">

                {{-- TEXT --}}
                <div class="relative z-10 flex-1">
                    <p class="text-[10px] font-bold tracking-[3px] uppercase {{ $banner['subtxt'] }} mb-1">{{ $banner['tag'] }}</p>
                    <h4 class="text-[20px] font-black leading-tight tracking-[-1px] {{ $banner['text'] }}">{{ $banner['title'] }}</h4>
                    <p class="text-[11px] {{ $banner['subtxt'] }} mt-1 mb-3 max-w-[180px]">{{ $banner['desc'] }}</p>
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-4 py-2 rounded-full {{ $banner['accent'] }} transition-all">
                        {{ $banner['cta'] }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                    </span>
                </div>

                {{-- IMAGE --}}
                <div class="absolute right-0 bottom-0 h-full flex items-end justify-end overflow-hidden w-[160px]">
                    <img src="{{ $banner['img'] }}" class="h-[140px] w-auto object-cover object-left opacity-80" draggable="false">
                </div>

            </div>
            @endforeach

        </div>

        {{-- PRODUCTS GRID --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

            @foreach ($cat['products'] as $product)
            <div class="group bg-white border border-[#ececec] rounded-[8px] overflow-hidden">

                {{-- IMAGE --}}
                <div class="relative bg-[#fafafa] h-[220px] flex items-center justify-center overflow-hidden">
                    <div class="absolute top-4 left-4 z-20 bg-[#000039] text-white text-[9px] tracking-[2px] font-bold px-3 py-1.5 rounded-md">
                        {{ $product['badge'] }}
                    </div>
                    <button class="absolute top-4 right-4 z-20 w-9 h-9 rounded-md bg-white border border-[#e7e7e7] flex items-center justify-center text-[#000039]/40 hover:bg-[#000039] hover:text-white transition-all duration-300 text-[14px]">
                        ♡
                    </button>
                    <img src="{{ $product['image'] }}"
                        class="w-[190px] h-[160px] object-cover">
                </div>

                {{-- CONTENT --}}
                <div class="px-5 pb-5 pt-4">
                    <p class="text-[10px] tracking-[2px] uppercase text-[#000039]/40 font-semibold">{{ $product['category'] }}</p>
                    <div class="flex items-start justify-between gap-2 mt-1.5">
                        <h3 class="text-[17px] leading-tight tracking-[-0.5px] font-bold text-[#000039]">{{ $product['name'] }}</h3>
                        <div class="flex items-center gap-1 shrink-0 mt-0.5">
                            <span class="text-amber-400 text-[11px]">★</span>
                            <span class="text-[12px] font-semibold text-[#000039]">{{ $product['rating'] }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <div>
                            <p class="text-[20px] tracking-[-1px] leading-none font-black text-[#000039]">{{ $product['price'] }}</p>
                            <p class="text-[12px] text-[#aaa] line-through mt-0.5">{{ $product['old'] }}</p>
                        </div>
                        <button class="w-[42px] h-[42px] rounded-md bg-[#000039] flex items-center justify-center hover:bg-[#000039]/80 transition-all duration-300 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
            @endforeach

        </div>

    </div>
    @endforeach

</div>
</section>