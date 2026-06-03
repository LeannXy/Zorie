<section class="bg-white py-12 border-y border-[#000039]/8" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    <div class="max-w-[1280px] mx-auto px-5">

        <p class="text-[11px] font-bold tracking-[4px] uppercase text-[#000039]/40 mb-10">Brand Pilihan</p>

        {{-- BARIS 1: Adidas saja (besar, centered) --}}
        <div class="flex justify-center mb-6">
            <div class="flex items-center justify-center bg-[#f8f8f8] border border-[#000039]/8 rounded-2xl px-16 py-8 hover:border-[#000039]/20 hover:bg-white hover:shadow-md transition-all duration-300 group w-full max-w-[400px]">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg"
                    alt="Adidas"
                    class="h-16 w-auto object-contain transition-all duration-300 group-hover:scale-110">
            </div>
        </div>

        {{-- BARIS 2: Nike, Puma, Asics --}}
        <div class="grid grid-cols-3 gap-4 mb-4">
            @php
            $row2 = [
                ['name' => 'Nike',  'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg'],
                ['name' => 'Puma',  'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fd/Puma_logo.svg'],
                ['name' => 'Asics', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/b1/Asics_Logo.svg'],
            ];
            @endphp
            @foreach ($row2 as $brand)
            <div class="flex items-center justify-center bg-[#f8f8f8] border border-[#000039]/8 rounded-2xl px-8 py-7 hover:border-[#000039]/20 hover:bg-white hover:shadow-md transition-all duration-300 group">
                <img src="{{ $brand['logo'] }}"
                    alt="{{ $brand['name'] }}"
                    class="h-14 w-auto object-contain transition-all duration-300 group-hover:scale-110">
            </div>
            @endforeach
        </div>

        {{-- BARIS 3: New Balance, Reebok, Ourtus, Converse --}}
        <div class="grid grid-cols-4 gap-4">
            @php
            $row3 = [
                ['name' => 'New Balance', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/New_Balance_logo.svg'],
                ['name' => 'Reebok',      'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/0f/Reebok_2019_logo.svg'],
                ['name' => 'Converse',    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/3/30/Converse_logo.svg'],
                ['name' => 'Ourtus',      'logo' => ''],
            ];
            @endphp
            @foreach ($row3 as $brand)
            <div class="flex flex-col items-center justify-center gap-3 bg-[#f8f8f8] border border-[#000039]/8 rounded-2xl px-6 py-7 hover:border-[#000039]/20 hover:bg-white hover:shadow-md transition-all duration-300 group">
                @if($brand['logo'])
                    <img src="{{ $brand['logo'] }}"
                        alt="{{ $brand['name'] }}"
                        class="h-12 w-auto object-contain transition-all duration-300 group-hover:scale-110">
                @else
                    <span class="text-[22px] font-black tracking-[-1px] text-[#000039] transition-colors">OURTUS</span>
                    <span class="text-[10px] font-semibold text-[#000039]/40">{{ $brand['name'] }}</span>
                @endif
            </div>
            @endforeach
        </div>

    </div>

</section>