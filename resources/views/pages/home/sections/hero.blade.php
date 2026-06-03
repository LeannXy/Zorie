<section class="bg-[#f5f5f3] overflow-hidden"
    style="padding-top: clamp(16px, 3vw, 32px); padding-bottom: clamp(32px, 5vw, 56px);">

    <div class="max-w-[1280px] mx-auto px-5 lg:px-10">

        {{-- ===== HERO CONTAINER ===== --}}
        <div class="relative flex items-center justify-center border-y border-[#000039]/10"
            style="min-height: clamp(320px, 65vw, 560px);">

            {{-- BG TEXT --}}
            <h1 aria-hidden="true"
                class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2
                       font-black text-[#000039]/[0.05] select-none pointer-events-none whitespace-nowrap"
                style="font-family:'Plus Jakarta Sans',sans-serif;
                       font-size: clamp(72px, 18vw, 260px);
                       letter-spacing: clamp(-4px, -1.2vw, -14px);
                       line-height: 1;">
                ZORIE
            </h1>

            {{-- ===== LAYOUT GRID ===== --}}
            {{-- Desktop: 3-col (left | center | right) | Mobile: stacked --}}
            <div class="relative z-10 w-full grid items-center gap-y-6
                        grid-cols-1
                        md:grid-cols-[1fr_auto_1fr]
                        py-8 md:py-10 lg:py-14">

                {{-- ── LEFT: Headline ── --}}
                <div class="flex flex-col gap-0 md:gap-1 text-center md:text-left order-1">

                    <p class="text-[#000039]/40 font-semibold tracking-[4px] uppercase mb-3 md:mb-4"
                       style="font-family:'Plus Jakarta Sans',sans-serif;
                              font-size: clamp(9px, 1.1vw, 12px);">
                        New Arrival 2025
                    </p>

                    <h2 class="text-[#000039] font-[300] leading-[0.92]"
                        style="font-family:'Plus Jakarta Sans',sans-serif;
                               font-size: clamp(36px, 6.5vw, 78px);
                               letter-spacing: clamp(-2px, -0.5vw, -4px);">
                        FOREVER
                    </h2>

                    <h2 class="text-[#000039] font-[900] leading-[0.88]"
                        style="font-family:'Plus Jakarta Sans',sans-serif;
                               font-size: clamp(42px, 7.5vw, 90px);
                               letter-spacing: clamp(-3px, -0.7vw, -6px);">
                        FASTER..
                    </h2>

                    {{-- CTA — tampil di mobile di sini --}}
                    <div class="flex items-center gap-3 mt-6 justify-center md:justify-start md:hidden">
                        <a href="{{ route('all-products') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full
                                  bg-[#000039] text-white font-semibold text-[12px]
                                  hover:bg-[#000039]/85 active:scale-95 transition-all"
                           style="font-family:'Plus Jakarta Sans',sans-serif;">
                            Beli Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <span class="text-[#000039]/40 text-[12px] font-medium"
                              style="font-family:'Plus Jakarta Sans',sans-serif;">
                            Rp129.990
                        </span>
                    </div>

                </div>

                {{-- ── CENTER: 3D Shoe ── --}}
                <div class="order-2 flex items-center justify-center relative
                            w-full md:w-auto
                            mx-auto"
                     style="min-width: clamp(220px, 40vw, 560px);">

                    {{-- Shadow --}}
                    <div class="absolute bottom-[8%] left-1/2 -translate-x-1/2
                                rounded-full bg-[#000039]/10 blur-[32px]"
                         style="width: clamp(160px, 30vw, 420px);
                                height: clamp(28px, 4vw, 56px);">
                    </div>

                    {{-- 3D Model --}}
                    <model-viewer
                        src="/shoe/source/Sneakers.glb"
                        auto-rotate
                        camera-controls
                        disable-pan
                        shadow-intensity="1.2"
                        exposure="1.05"
                        camera-target="0m 0m 0m"
                        min-camera-orbit="auto auto 80%"
                        max-camera-orbit="auto auto 140%"
                        camera-orbit="0deg 72deg 110%"
                        interaction-prompt="none"
                        style="width: clamp(240px, 44vw, 640px);
                               height: clamp(200px, 38vw, 520px);">
                    </model-viewer>

                </div>

                {{-- ── RIGHT: Product Info ── --}}
                <div class="order-3 flex flex-col items-center md:items-end gap-4 text-center md:text-right">

                    {{-- Badge --}}
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                 border border-[#000039]/15 bg-[#000039]/5
                                 text-[#000039]/60 font-semibold uppercase tracking-[3px]"
                          style="font-family:'Plus Jakarta Sans',sans-serif;
                                 font-size: clamp(8px, 0.9vw, 10px);">
                        Sneakers Unisex
                    </span>

                    {{-- Product Name --}}
                    <h3 class="text-[#000039] font-[900] leading-[0.95]"
                        style="font-family:'Plus Jakarta Sans',sans-serif;
                               font-size: clamp(26px, 3.8vw, 50px);
                               letter-spacing: clamp(-1px, -0.2vw, -2px);">
                        Exotek<br>NITRO
                    </h3>

                    {{-- Divider --}}
                    <div class="w-8 h-[1px] bg-[#000039]/20"></div>

                    {{-- Price --}}
                    <p class="text-[#000039] font-[800]"
                       style="font-family:'Plus Jakarta Sans',sans-serif;
                              font-size: clamp(18px, 2.4vw, 32px);
                              letter-spacing: -1px;">
                        Rp129.990
                    </p>

                    {{-- Energi label --}}
                    <p class="text-[#000039]/45 font-medium"
                       style="font-family:'Plus Jakarta Sans',sans-serif;
                              font-size: clamp(11px, 1.3vw, 15px);">
                        Energi Maksimal, Bobot Minimal
                    </p>

                    {{-- CTA — hanya muncul di desktop --}}
                    <a href="{{ route('all-products') }}"
                       class="hidden md:inline-flex items-center gap-2 mt-2 px-5 py-2.5 rounded-full
                              bg-[#000039] text-white font-semibold
                              hover:bg-[#000039]/85 active:scale-95 transition-all"
                       style="font-family:'Plus Jakarta Sans',sans-serif;
                              font-size: clamp(11px, 1.1vw, 13px);">
                        Beli Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>

                </div>

            </div>

            {{-- ===== BOTTOM SLIDER INDICATOR ===== --}}
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-10
                        flex items-center gap-4" aria-hidden="true">
                <div class="h-[1.5px] bg-[#000039]/15 rounded-full"
                     style="width: clamp(60px, 12vw, 160px);"></div>
                <div class="rounded-full bg-[#000039] border-[4px] border-[#f5f5f3]"
                     style="width: clamp(12px, 1.4vw, 16px); height: clamp(12px, 1.4vw, 16px);
                            box-shadow: 0 0 0 1px rgba(0,0,57,0.15);"></div>
                <div class="h-[1.5px] bg-[#000039]/15 rounded-full"
                     style="width: clamp(60px, 12vw, 160px);"></div>
            </div>

        </div>

        {{-- ===== BOTTOM STRIP: Stats ===== --}}
        <div class="mt-5 md:mt-7 grid grid-cols-3 divide-x divide-[#000039]/10
                    border border-[#000039]/10 rounded-2xl overflow-hidden bg-white/50">
            @foreach([
                ['val' => '2.000+', 'label' => 'Produk Tersedia'],
                ['val' => '50.000+', 'label' => 'Pelanggan Puas'],
                ['val' => '4.9★',   'label' => 'Rating Rata-rata'],
            ] as $stat)
            <div class="flex flex-col items-center justify-center gap-0.5
                        py-4 md:py-5 px-2">
                <span class="text-[#000039] font-[900]"
                      style="font-family:'Plus Jakarta Sans',sans-serif;
                             font-size: clamp(16px, 2.5vw, 26px);
                             letter-spacing: -0.5px;">
                    {{ $stat['val'] }}
                </span>
                <span class="text-[#000039]/45 font-medium text-center"
                      style="font-family:'Plus Jakarta Sans',sans-serif;
                             font-size: clamp(9px, 1vw, 12px);">
                    {{ $stat['label'] }}
                </span>
            </div>
            @endforeach
        </div>

    </div>

</section>

<script type="module"
    src="https://ajax.googleapis.com/ajax/libs/model-viewer/4.0.0/model-viewer.min.js">
</script>