<section class="bg-white py-20" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    <div class="max-w-[1280px] mx-auto px-6">

        {{-- HEADER --}}
        <div class="text-center mb-12">
            <p class="text-[11px] font-bold tracking-[4px] uppercase text-[#000039]/40 mb-3">Testimonial</p>
            <h2 class="text-[36px] md:text-[44px] font-bold tracking-[-2px] text-[#111]">
                Pengalaman Pelanggan Kami
            </h2>
        </div>

        {{-- SLIDER --}}
        <div
            x-data="{
                current: 0,
                total: 0,
                init() {
                    this.total = Math.ceil(this.$refs.track.children.length / 3);
                },
                prev() { if (this.current > 0) this.current-- },
                next() { if (this.current < this.total - 1) this.current++ },
            }"
            x-init="init()"
            class="relative">

            {{-- TRACK --}}
            <div class="overflow-hidden">
                <div
                    x-ref="track"
                    class="flex gap-5 transition-transform duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"
                    :style="'transform: translateX(calc(-' + current + ' * (100% + 20px) / 1))'">

                    @php
                    $testimonials = [
                        [
                            'text'   => 'Produk yang sangat berkualitas! Sepatu Zorie yang saya beli terasa nyaman sejak hari pertama. Pengiriman cepat dan packaging rapi.',
                            'name'   => 'Budi Santoso',
                            'handle' => '@budisantoso',
                            'avatar' => 'https://i.pravatar.cc/100?img=11',
                        ],
                        [
                            'text'   => 'Pengalaman belanja yang sangat mulus dari awal hingga akhir. Sangat merekomendasikan!',
                            'name'   => 'Sari Dewi',
                            'handle' => '@saridewi',
                            'avatar' => 'https://i.pravatar.cc/100?img=5',
                        ],
                        [
                            'text'   => 'Terpercaya dan konsisten. Membuat hidup saya jauh lebih mudah dalam memilih sepatu yang tepat.',
                            'name'   => 'Andi Wijaya',
                            'handle' => '@andiwijaya',
                            'avatar' => 'https://i.pravatar.cc/100?img=15',
                        ],
                        [
                            'text'   => 'Kualitasnya luar biasa, harga sangat sepadan. Sudah beli 3 pasang dan tidak pernah kecewa.',
                            'name'   => 'Rina Kusuma',
                            'handle' => '@rinakusuma',
                            'avatar' => 'https://i.pravatar.cc/100?img=9',
                        ],
                        [
                            'text'   => 'Customer service sangat responsif. Ketika ada masalah ukuran, langsung dibantu dengan cepat dan ramah.',
                            'name'   => 'Dimas Pratama',
                            'handle' => '@dimaspratama',
                            'avatar' => 'https://i.pravatar.cc/100?img=18',
                        ],
                        [
                            'text'   => 'Desainnya keren dan modern. Banyak teman yang tanya beli dimana setelah lihat sepatu saya.',
                            'name'   => 'Maya Putri',
                            'handle' => '@mayaputri',
                            'avatar' => 'https://i.pravatar.cc/100?img=25',
                        ],
                    ];
                    @endphp

                    @foreach ($testimonials as $t)
                    <div class="min-w-[calc(33.333%-14px)] bg-[#f7f7f9] rounded-[20px] p-7 flex flex-col justify-between gap-8 border border-[#000039]/6 hover:border-[#000039]/15 hover:shadow-md transition-all duration-300">

                        {{-- QUOTE MARK --}}
                        <div>
                            <svg class="w-8 h-8 text-[#000039]/15 mb-4" viewBox="0 0 32 24" fill="currentColor">
                                <path d="M0 24V14.4C0 6.4 4.8 1.6 14.4 0l1.6 2.4C10.4 3.6 7.2 6.4 6.4 10.4H12V24H0zm20 0V14.4C20 6.4 24.8 1.6 34.4 0L36 2.4C30.4 3.6 27.2 6.4 26.4 10.4H32V24H20z"/>
                            </svg>

                            <p class="text-[15px] leading-[1.8] text-[#333]">
                                {{ $t['text'] }}
                            </p>
                        </div>

                        {{-- USER --}}
                        <div class="flex items-center gap-3 pt-5 border-t border-[#000039]/8">
                            <img src="{{ $t['avatar'] }}"
                                class="w-10 h-10 rounded-full object-cover shrink-0">
                            <div>
                                <p class="text-[13px] font-bold text-[#111]">{{ $t['name'] }}</p>
                                <p class="text-[12px] text-[#000039]/40">{{ $t['handle'] }}</p>
                            </div>
                        </div>

                    </div>
                    @endforeach

                </div>
            </div>

            {{-- DOTS + ARROWS --}}
            <div class="flex items-center justify-center gap-4 mt-10">

                {{-- Prev --}}
                <button @click="prev()"
                    :class="current === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-[#000039] hover:text-white hover:border-[#000039]'"
                    class="w-9 h-9 rounded-full border border-[#000039]/20 flex items-center justify-center text-[#000039]/50 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>

                {{-- Dots --}}
                <div class="flex gap-2">
                    <template x-for="i in total" :key="i">
                        <button @click="current = i - 1"
                            class="h-[6px] rounded-full transition-all duration-300 bg-[#000039]"
                            :class="current === i - 1 ? 'w-6 opacity-100' : 'w-[6px] opacity-20'">
                        </button>
                    </template>
                </div>

                {{-- Next --}}
                <button @click="next()"
                    :class="current === total - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-[#000039] hover:text-white hover:border-[#000039]'"
                    class="w-9 h-9 rounded-full border border-[#000039]/20 flex items-center justify-center text-[#000039]/50 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>

            </div>

        </div>

    </div>

</section>