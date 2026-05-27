<section class="bg-[#f5f5f3] pb-16">

    <div class="max-w-[1280px] mx-auto px-5">

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

            @php

                $features = [

                    [
                        'title' => 'Sustainable Materials',
                        'desc' => 'We believe great style shouldn’t come at the planet’s expense.'
                    ],

                    [
                        'title' => 'Warranty Included',
                        'desc' => 'Every pair comes with a hassle-free 6-month warranty.'
                    ],

                    [
                        'title' => 'Delivery & Shipping',
                        'desc' => 'Your shoes will be dispatched within 1-2 business days.'
                    ],

                    [
                        'title' => 'Eco-Friendly Fabrics',
                        'desc' => 'Crafted with sustainability in mind, our shoes feature eco-friendly fabrics.'
                    ]

                ];

            @endphp

            @foreach ($features as $feature)

                <div>

                    <div class="w-16 h-16 rounded-2xl border border-[#e2e2e2] flex items-center justify-center text-[28px] mb-6">

                        ✦

                    </div>

                    <h3 class="text-[24px] md:text-[28px] leading-[1.1] tracking-[-1px] font-semibold text-[#111]">

                        {{ $feature['title'] }}

                    </h3>

                    <p class="mt-4 text-[16px] md:text-[18px] leading-[1.9] text-[#727272]">

                        {{ $feature['desc'] }}

                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>