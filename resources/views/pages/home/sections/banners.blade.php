<section class="bg-[#f5f5f3] py-16">

    <div class="max-w-[1280px] mx-auto px-5">

        {{-- HEADER --}}
        <div class="mb-12">
            <p class="text-[12px] tracking-[4px] uppercase text-[#000039]/50 font-semibold">Video kampanye</p>
            <h2 class="text-[48px] md:text-[58px] leading-none tracking-[-3px] font-black text-[#000039] mt-2">Lihat Produk</h2>
        </div>

        <div x-data="carouselData()" class="relative">

            {{-- CAROUSEL CONTAINER --}}
            <div class="overflow-hidden">
                <div class="flex gap-6 transition-transform duration-500" :style="`transform: translateX(-${currentSlide * 100}%)`">

                    @php
                    $banners = [
                        ['title' => 'EcoHarvest Business Center', 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80'],
                        ['title' => 'AquaVista Marina Build', 'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=600&q=80'],
                        ['title' => 'BioUrban Living Complex', 'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=600&q=80'],
                        ['title' => 'TechHaven Residences', 'image' => 'https://images.unsplash.com/photo-1514996937319-344454492b37?w=600&q=80'],
                        ['title' => 'Urban Street Sneakers', 'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&q=80'],
                        ['title' => 'Classic Leather Premium', 'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=600&q=80'],
                        ['title' => 'Stride Performance', 'image' => 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=600&q=80'],
                        ['title' => 'Thrive Oxford Formal', 'image' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?w=600&q=80'],
                        ['title' => 'Air Flex Run', 'image' => 'https://images.unsplash.com/photo-1520099002821-a0acc8b5b774?w=600&q=80'],
                        ['title' => 'Zurik Sports Edition', 'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=600&q=80'],
                    ];
                    @endphp

                    @foreach ($banners as $banner)
                    <div class="flex-shrink-0 w-full sm:w-1/2 lg:w-1/3 xl:w-1/4">
                        <div class="relative h-[380px] rounded-[20px] overflow-hidden group">

                            {{-- VIDEO/IMAGE PLACEHOLDER --}}
                            <img
                                src="{{ $banner['image'] }}"
                                class="absolute inset-0 w-full h-full object-cover"
                                alt="{{ $banner['title'] }}"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                            {{-- LEARN DETAILS BUTTON --}}
                            <button class="absolute top-4 right-4 z-20 bg-white/90 hover:bg-white text-black text-[11px] font-bold px-4 py-2 rounded-full transition-all">
                                LEARN<br>DETAILS
                            </button>

                            {{-- TITLE --}}
                            <div class="absolute bottom-0 left-0 right-0 z-10 p-6">
                                <h3 class="text-white font-black text-[24px] leading-tight tracking-[-1px]">
                                    {{ $banner['title'] }}
                                </h3>
                            </div>

                            {{-- SIDE DOTS --}}
                            <div class="absolute right-4 bottom-6 z-20 flex flex-col gap-2">
                                <button class="w-2 h-2 rounded-full bg-white/60 hover:bg-white transition-all"></button>
                                <button class="w-2 h-2 rounded-full bg-white/60 hover:bg-white transition-all"></button>
                                <button class="w-2 h-2 rounded-full bg-white/60 hover:bg-white transition-all"></button>
                                <button class="w-2 h-2 rounded-full bg-white/60 hover:bg-white transition-all"></button>
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            {{-- NAVIGATION ARROWS --}}
            <button @click="prev()" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-6 lg:-translate-x-16 z-30 w-12 h-12 rounded-full bg-[#000039] text-white flex items-center justify-center hover:bg-[#000039]/80 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <button @click="next()" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-3 lg:translate-x-16 z-30 w-12 h-12 rounded-full bg-[#000039] text-white flex items-center justify-center hover:bg-[#000039]/80 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- BOTTOM DOTS --}}
            <div class="flex justify-center gap-3 mt-8 overflow-x-auto pb-2">
                <template x-for="(item, index) in 3" :key="index">
                    <button @click="currentSlide = index" :class="`min-w-max w-2 h-2 rounded-full transition-all ${currentSlide === index ? 'bg-[#000039] w-8' : 'bg-[#000039]/30'}`"></button>
                </template>
            </div>

        </div>

    </div>

    <script>
    function carouselData() {
        return {
            currentSlide: 0,
            totalSlides: 6,
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            },
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            }
        }
    }
    </script>

</section>