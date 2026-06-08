{{-- Brand Pilihan Section --}}
<section class="bg-white py-16 border-y border-[#000039]/8" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    <div class="max-w-[1280px] mx-auto px-5">

        {{-- Section Header --}}
        <div class="flex items-center justify-between mb-10">
            <p class="text-[11px] font-bold tracking-[4px] uppercase text-[#000039]/40">Brand Pilihan</p>
            <a href="{{ route('all-products') }}"
               class="text-[11px] font-bold tracking-[3px] uppercase text-[#000039]/40 hover:text-[#000039] transition-colors duration-300 flex items-center gap-2 group">
                Lihat Semua
                <svg class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @php
        $brands = [
            ['name' => 'Adidas',      'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg'],
            ['name' => 'Nike',        'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg'],
            ['name' => 'Asics',       'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/b1/Asics_Logo.svg'],
            ['name' => 'Converse',    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/3/30/Converse_logo.svg'],
     
        ];
        @endphp

        {{-- Brand Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
            @foreach ($brands as $brand)
                <a href="{{ route('all-products', ['brand' => strtolower($brand['name'])]) }}"
                   class="group relative flex flex-col items-center justify-center gap-3
                          bg-[#f8f8f8] border border-[#000039]/8 rounded-2xl
                          px-6 py-8
                          hover:border-[#000039]/20 hover:bg-white hover:shadow-lg
                          transition-all duration-300 cursor-pointer overflow-hidden">

                    {{-- Hover background accent --}}
                    <span class="absolute inset-0 bg-gradient-to-br from-[#000039]/[0.02] to-transparent
                                 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></span>

                    @if ($brand['logo'])
                        <img src="{{ $brand['logo'] }}"
                             alt="{{ $brand['name'] }}"
                             class="h-10 w-auto object-contain grayscale opacity-60
                                    group-hover:grayscale-0 group-hover:opacity-100
                                    group-hover:scale-105
                                    transition-all duration-300 relative z-10">
                    @else
                        <span class="text-[20px] font-black tracking-[-1px] text-[#000039]/50
                                     group-hover:text-[#000039]
                                     transition-colors duration-300 relative z-10">
                            {{ strtoupper($brand['name']) }}
                        </span>
                    @endif

                    <span class="text-[10px] font-semibold tracking-[2px] uppercase
                                 text-[#000039]/30 group-hover:text-[#000039]/60
                                 transition-colors duration-300 relative z-10">
                        {{ $brand['name'] }}
                    </span>

                </a>
            @endforeach
        </div>

    </div>

</section>