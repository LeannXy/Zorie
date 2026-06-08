{{-- 
    SECTION: KALKULATOR & PANDUAN UKURAN SEPATU INTERAKTIF
    Cocok di-include pada home page menggunakan: @include('pages.home.sections.size-calculator')
--}}

<section class="bg-white py-16 md:py-24 border-t border-gray-100 overflow-hidden" 
         x-data="{
            footLength: 24.5,
            gender: 'unisex', // 'unisex' | 'men' | 'women'

            // Perhitungan Ukuran EUR berdasarkan Standar Internasional (Mondopoint/CM)
            get calculatedEUR() {
                const len = parseFloat(this.footLength);
                if (len < 22.0) return 35;
                if (len >= 22.0 && len < 22.7) return 36;
                if (len >= 22.7 && len < 23.4) return 37;
                if (len >= 23.4 && len < 24.1) return 38;
                if (len >= 24.1 && len < 24.7) return 39;
                if (len >= 24.7 && len < 25.4) return 40;
                if (len >= 25.4 && len < 26.1) return 41;
                if (len >= 26.1 && len < 26.7) return 42;
                if (len >= 26.7 && len < 27.4) return 43;
                if (len >= 27.4 && len < 28.1) return 44;
                if (len >= 28.1 && len < 28.7) return 45;
                return 46;
            },

            // Perhitungan Ukuran US berdasarkan Gender
            get calculatedUS() {
                const eur = this.calculatedEUR;
                if (this.gender === 'women') {
                    // Standar US Wanita biasanya EUR + 1.5 atau 2 tingkat
                    const map = { 35: '5', 36: '6', 37: '6.5', 38: '7.5', 39: '8.5', 40: '9', 41: '9.5', 42: '10.5', 43: '11.5', 44: '12', 45: '13', 46: '14' };
                    return map[eur] || '9';
                } else {
                    // Standar US Pria / Unisex
                    const map = { 35: '3.5', 36: '4.5', 37: '5', 38: '6', 39: '7', 40: '7.5', 41: '8', 42: '9', 43: '10', 44: '10.5', 45: '11.5', 46: '12' };
                    return map[eur] || '8.5';
                }
            },

            // Perhitungan Ukuran UK
            get calculatedUK() {
                const eur = this.calculatedEUR;
                const map = { 35: '2.5', 36: '3.5', 37: '4', 38: '5', 39: '6', 40: '6.5', 41: '7', 42: '8', 43: '9', 44: '9.5', 45: '10.5', 46: '11' };
                return map[eur] || '7.5';
            },

            // Data Tabel untuk Interaktivitas Row Highlight
            sizeChart: [
                { cm: '21.5 - 21.9', eur: 35, us_m: '3.5', us_w: '5', uk: '2.5' },
                { cm: '22.0 - 22.6', eur: 36, us_m: '4.5', us_w: '6', uk: '3.5' },
                { cm: '22.7 - 23.3', eur: 37, us_m: '5.0', us_w: '6.5', uk: '4.0' },
                { cm: '23.4 - 24.0', eur: 38, us_m: '6.0', us_w: '7.5', uk: '5.0' },
                { cm: '24.1 - 24.6', eur: 39, us_m: '7.0', us_w: '8.5', uk: '6.0' },
                { cm: '24.7 - 25.3', eur: 40, us_m: '7.5', us_w: '9.0', uk: '6.5' },
                { cm: '25.4 - 26.0', eur: 41, us_m: '8.0', us_w: '9.5', uk: '7.0' },
                { cm: '26.1 - 26.6', eur: 42, us_m: '9.0', us_w: '10.5', uk: '8.0' },
                { cm: '26.7 - 27.3', eur: 43, us_m: '10.0', us_w: '11.5', uk: '9.0' },
                { cm: '27.4 - 28.0', eur: 44, us_m: '10.5', us_w: '12.0', uk: '9.5' },
                { cm: '28.1 - 28.6', eur: 45, us_m: '11.5', us_w: '13.0', uk: '10.5' },
            ]
         }">
    
    <div class="max-w-[1280px] mx-auto px-5 lg:px-10">
        
        {{-- ===== HEADER SECTION ===== --}}
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                         border border-[#000039]/15 bg-[#000039]/5
                         text-[#000039]/60 font-semibold uppercase tracking-[3px] text-[10px]"
                  style="font-family:'Plus Jakarta Sans',sans-serif;">
                Panduan Fitting Presisi
            </span>
            <h2 class="text-[#000039] font-[900] text-3xl md:text-5xl tracking-tight mt-3 mb-4"
                style="font-family:'Plus Jakarta Sans',sans-serif; letter-spacing: -1px;">
                Cari Tahu Ukuran Sepatumu
            </h2>
            <p class="text-gray-500 text-sm md:text-base leading-relaxed">
                Menghindari kesalahan ukuran saat berbelanja online. Cukup ukur panjang kaki Anda dalam centimeter (cm), masukkan ke kalkulator di bawah, dan dapatkan ukuran paling pas untuk kaki Anda.
            </p>
        </div>

        {{-- ===== LAYOUT GRID ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            {{-- ── COL LEFT (5/12): INTERACTIVE CALCULATOR CARD ── --}}
            <div class="lg:col-span-5 bg-[#f5f5f3] rounded-3xl p-6 md:p-8 border border-[#000039]/5 shadow-sm sticky top-24">
                
                {{-- Gender Toggle --}}
                <div class="mb-8">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#000039]/55 mb-3"
                       style="font-family:'Plus Jakarta Sans',sans-serif;">
                        1. Pilih Kategori
                    </p>
                    <div class="grid grid-cols-3 gap-2 bg-white p-1 rounded-2xl border border-gray-100">
                        <button type="button" 
                                @click="gender = 'unisex'"
                                :class="gender === 'unisex' ? 'bg-[#000039] text-white' : 'text-[#000039]/60 hover:bg-[#000039]/5'"
                                class="py-2.5 rounded-xl text-xs font-bold transition-all border-none cursor-pointer">
                            Unisex
                        </button>
                        <button type="button" 
                                @click="gender = 'men'"
                                :class="gender === 'men' ? 'bg-[#000039] text-white' : 'text-[#000039]/60 hover:bg-[#000039]/5'"
                                class="py-2.5 rounded-xl text-xs font-bold transition-all border-none cursor-pointer">
                            Pria
                        </button>
                        <button type="button" 
                                @click="gender = 'women'"
                                :class="gender === 'women' ? 'bg-[#000039] text-white' : 'text-[#000039]/60 hover:bg-[#000039]/5'"
                                class="py-2.5 rounded-xl text-xs font-bold transition-all border-none cursor-pointer">
                            Wanita
                        </button>
                    </div>
                </div>

                {{-- Interactive Slider --}}
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#000039]/55"
                           style="font-family:'Plus Jakarta Sans',sans-serif;">
                            2. Geser Sesuai Panjang Kaki
                        </p>
                        <div class="flex items-baseline gap-1 bg-white px-3.5 py-1.5 rounded-xl border border-gray-200 shadow-sm">
                            <span class="text-2xl font-black text-[#000039]" x-text="parseFloat(footLength).toFixed(1)"></span>
                            <span class="text-xs font-bold text-gray-400">cm</span>
                        </div>
                    </div>
                    
                    {{-- Slider Input --}}
                    <div class="relative py-4">
                        <input type="range" min="21.5" max="28.6" step="0.1" x-model="footLength" 
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#000039]">
                        <div class="flex justify-between text-[10px] font-bold text-gray-400 mt-3"
                             style="font-family:'Plus Jakarta Sans',sans-serif;">
                            <span>21.5 cm</span>
                            <span>25.0 cm</span>
                            <span>28.6 cm</span>
                        </div>
                    </div>
                </div>

                {{-- Conversion Result --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#000039]/40 mb-1"
                       style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Rekomendasi Ukuran Anda
                    </p>
                    
                    {{-- EUR Size (Utama) --}}
                    <div class="flex items-center justify-center gap-1.5">
                        <span class="text-6xl font-black text-[#000039] tracking-tighter" x-text="calculatedEUR"></span>
                        <span class="text-xl font-bold text-[#000039]/60 self-end mb-1">EUR</span>
                    </div>

                    {{-- Divider --}}
                    <div class="my-5 border-t border-gray-100"></div>

                    {{-- Other Conversions --}}
                    <div class="grid grid-cols-2 divide-x divide-gray-100 text-center">
                        <div>
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">US Size</span>
                            <span class="text-lg font-black text-[#000039] mt-0.5 block" x-text="calculatedUS"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">UK Size</span>
                            <span class="text-lg font-black text-[#000039] mt-0.5 block" x-text="calculatedUK"></span>
                        </div>
                    </div>
                </div>

                {{-- Quick CTA --}}
                <div class="mt-6">
                    <a href="{{ route('all-products') }}" 
                       class="w-full py-4 bg-[#000039] hover:bg-[#000039]/90 text-white rounded-2xl font-bold text-sm tracking-wide transition-all shadow-md flex items-center justify-center gap-2 decoration-none"
                       style="font-family:'Plus Jakarta Sans',sans-serif;">
                        <span>Mulai Belanja Dengan Ukuran Ini</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

            </div>

            {{-- ── COL RIGHT (7/12): MEASUREMENT GUIDE & CHART ── --}}
            <div class="lg:col-span-7 space-y-12">
                
                {{-- Step-by-Step Interactive Guide --}}
                <div>
                    <h3 class="text-[#000039] font-[900] text-xl tracking-tight mb-6"
                        style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Cara Mengukur Kaki Anda di Rumah
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        {{-- Step 1 --}}
                        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:border-[#000039]/15 transition-all">
                            <div class="w-12 h-12 rounded-xl bg-[#000039]/5 flex items-center justify-center mb-4">
                                {{-- Icon Kertas & Kaki --}}
                                <svg class="w-6 h-6 text-[#000039]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#e63]" style="font-family:'Plus Jakarta Sans',sans-serif;">Langkah 1</span>
                            <h4 class="font-bold text-[#000039] text-sm mt-1 mb-2">Siapkan Kertas</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">Letakkan selembar kertas HVS kosong secara rata di atas lantai yang keras, tepat di samping tembok.</p>
                        </div>

                        {{-- Step 2 --}}
                        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:border-[#000039]/15 transition-all">
                            <div class="w-12 h-12 rounded-xl bg-[#000039]/5 flex items-center justify-center mb-4">
                                {{-- Icon Pensil --}}
                                <svg class="w-6 h-6 text-[#000039]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#e63]" style="font-family:'Plus Jakarta Sans',sans-serif;">Langkah 2</span>
                            <h4 class="font-bold text-[#000039] text-sm mt-1 mb-2">Tandai Tumit & Jari</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">Posisikan tumit Anda menempel rapat di dinding. Tandai titik terjauh jari kaki terpanjang Anda menggunakan pensil.</p>
                        </div>

                        {{-- Step 3 --}}
                        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:border-[#000039]/15 transition-all">
                            <div class="w-12 h-12 rounded-xl bg-[#000039]/5 flex items-center justify-center mb-4">
                                {{-- Icon Penggaris --}}
                                <svg class="w-6 h-6 text-[#000039]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 11-4.243-4.243 3 3 0 014.243 4.243z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#e63]" style="font-family:'Plus Jakarta Sans',sans-serif;">Langkah 3</span>
                            <h4 class="font-bold text-[#000039] text-sm mt-1 mb-2">Ukur dengan Penggaris</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">Gunakan penggaris untuk mengukur jarak lurus dari ujung kertas (posisi dinding) hingga titik tanda pensil.</p>
                        </div>

                    </div>
                </div>

                {{-- Interactive Size Chart Table --}}
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-[#000039] font-[900] text-xl tracking-tight"
                            style="font-family:'Plus Jakarta Sans',sans-serif;">
                            Tabel Konversi Ukuran
                        </h3>
                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Auto-Highlighting</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm divide-y divide-gray-100">
                            <thead>
                                <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 pl-4">Panjang Kaki (cm)</th>
                                    <th class="pb-3 text-center">EUR</th>
                                    <th class="pb-3 text-center" x-show="gender !== 'women'">US (Men)</th>
                                    <th class="pb-3 text-center" x-show="gender === 'women'">US (Women)</th>
                                    <th class="pb-3 text-center">UK</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 font-medium text-gray-600">
                                <template x-for="row in sizeChart" :key="row.eur">
                                    {{-- Menggunakan class bindings dinamis untuk menyorot baris yang aktif sesuai hasil kalkulasi slider --}}
                                    <tr class="transition-all duration-300 rounded-xl"
                                        :class="{ 
                                            'bg-[#000039] text-white font-bold shadow-md transform scale-[1.02]': calculatedEUR === row.eur 
                                        }">
                                        <td class="py-3.5 pl-4 rounded-l-xl text-xs" x-text="row.cm"></td>
                                        <td class="py-3.5 text-center text-sm font-black" x-text="row.eur"></td>
                                        <td class="py-3.5 text-center text-xs" x-show="gender !== 'women'" x-text="row.us_m"></td>
                                        <td class="py-3.5 text-center text-xs" x-show="gender === 'women'" x-text="row.us_w"></td>
                                        <td class="py-3.5 text-center text-xs rounded-r-xl" x-text="row.uk"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <p class="text-[11px] text-gray-400 mt-4 leading-relaxed italic text-center">
                        *Tips: Jika hasil pengukuran Anda berada di antara dua ukuran, disarankan untuk memilih 1 ukuran lebih besar jika tipe kaki Anda lebar atau tebal.
                    </p>
                </div>

            </div>

        </div>

    </div>
</section>