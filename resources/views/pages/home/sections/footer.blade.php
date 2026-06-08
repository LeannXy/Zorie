<footer class="bg-white border-t border-[#000039]/10" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    <div class="max-w-[1280px] mx-auto px-6">

        {{-- TOP: Newsletter --}}
        <div class="py-12 border-b border-[#000039]/8 flex flex-col md:flex-row md:items-center justify-between gap-8">

            {{-- Logo + tagline --}}
            <div>
                <h1 class="text-[54px] font-black tracking-[-3px] text-[#000039]">ZORIE</h1>
                <p class="text-[15px] text-[#000039]/45 mt-1">Temukan gaya, rasakan kenyamanan.</p>
            </div>

            {{-- Newsletter --}}
            <div class="flex items-center gap-3 w-full max-w-[480px]">
                <div class="flex-1 flex items-center h-[46px] bg-[#000039]/5 border border-[#000039]/12 rounded-full px-5 gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#000039]/30 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <input type="email" placeholder="Email Anda"
                        class="flex-1 bg-transparent outline-none text-[13px] text-[#000039] placeholder-[#000039]/30">
                </div>
                <button class="h-[46px] px-6 bg-[#000039] text-white text-[12px] font-bold rounded-full hover:bg-[#000039]/85 transition-all duration-300 whitespace-nowrap shrink-0">
                    Berlangganan
                </button>
            </div>

        </div>

        {{-- MIDDLE: Links --}}
        <div class="py-12 grid grid-cols-2 md:grid-cols-4 gap-10 border-b border-[#000039]/8">

            {{-- Kategori --}}
            <div>
                <h4 class="text-[10px] font-bold tracking-[3px] uppercase text-[#000039]/40 mb-5">Kategori</h4>
                <ul class="space-y-3">
                    @foreach(['Sneakers','Sports','Casual','Running'] as $item)
                    <li>
                        <a href="{{ route('all-products', ['filter' => $item]) }}"
                            class="text-[14px] text-[#000039]/65 hover:text-[#000039] transition-colors flex items-center gap-1.5 group">
                            <span class="w-0 group-hover:w-3 h-[1px] bg-[#000039] transition-all duration-300 overflow-hidden"></span>
                            {{ $item }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Link Cepat --}}
            <div>
                <h4 class="text-[10px] font-bold tracking-[3px] uppercase text-[#000039]/40 mb-5">Link Cepat</h4>
                <ul class="space-y-3">
                    @foreach([
                        ['label'=>'Beranda',      'url'=>'/'],
                        ['label'=>'Toko',         'url'=>route('all-products')],
                        ['label'=>'Tentang Kami', 'url'=>'/about'],
                        ['label'=>'Kontak',       'url'=>'/contact'],
                        ['label'=>'Tanya Jawab',  'url'=>'/faq'],
                    ] as $link)
                    <li>
                        <a href="{{ $link['url'] }}"
                            class="text-[14px] text-[#000039]/65 hover:text-[#000039] transition-colors flex items-center gap-1.5 group">
                            <span class="w-0 group-hover:w-3 h-[1px] bg-[#000039] transition-all duration-300 overflow-hidden"></span>
                            {{ $link['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Hukum --}}
            <div>
                <h4 class="text-[10px] font-bold tracking-[3px] uppercase text-[#000039]/40 mb-5">Legal</h4>
                <ul class="space-y-3">
                    @foreach(['Kebijakan Privasi','Kebijakan Cookie','Syarat Layanan','Kebijakan Pengembalian'] as $item)
                    <li>
                        <a href="#"
                            class="text-[14px] text-[#000039]/65 hover:text-[#000039] transition-colors flex items-center gap-1.5 group">
                            <span class="w-0 group-hover:w-3 h-[1px] bg-[#000039] transition-all duration-300 overflow-hidden"></span>
                            {{ $item }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Sosial --}}
            <div>
                <h4 class="text-[10px] font-bold tracking-[3px] uppercase text-[#000039]/40 mb-5">Ikuti Kami</h4>
                <ul class="space-y-3">
                    @foreach([
                        ['label'=>'Instagram', 'icon'=>'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z', 'url'=>'https://www.instagram.com/zorieshoes?igsh=cjhpZTJzaXNqaHZ2'],
                        ['label'=>'TikTok',    'icon'=>'M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.2 8.2 0 004.79 1.54V6.78a4.85 4.85 0 01-1.02-.09z'],
                        ['label'=>'YouTube',   'icon'=>'M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z'],
                    ] as $social)
                    <li>
                        <a href="{{ $social['url'] ?? '#' }}"
                            class="flex items-center gap-3 text-[14px] text-[#000039]/65 hover:text-[#000039] transition-colors group">
                            <div class="w-7 h-7 rounded-lg bg-[#000039]/6 flex items-center justify-center group-hover:bg-[#000039] transition-colors shrink-0">
                                <svg class="w-3.5 h-3.5 text-[#000039] group-hover:text-white transition-colors" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="{{ $social['icon'] }}"/>
                                </svg>
                            </div>
                            {{ $social['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>

        {{-- BOTTOM: Copyright --}}
        <div class="py-6 flex items-center justify-center md:justify-start">
            <p class="text-[12px] text-[#000039]/35 tracking-[1px] uppercase">
                © {{ date('Y') }} ZORIE. All Rights Reserved.
            </p>
        </div>

    </div>

</footer>