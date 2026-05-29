<section class="bg-[#f5f5f3] py-24 overflow-hidden">

    <div class="max-w-[1500px] mx-auto px-6">

        {{-- CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

            @for ($i = 0; $i < 5; $i++)

                <div
                    x-data="{ hover:false }"
                    @mouseenter="hover=true"
                    @mouseleave="hover=false"
                    class="relative overflow-hidden rounded-[28px] border border-[#e7e7e7] bg-[#fafafa] min-h-[420px] p-8 flex flex-col gap-10 transition-all duration-500"
                >

                    {{-- GLOW --}}
                    <div
                        :class="hover
                            ? 'opacity-100'
                            : 'opacity-0'"
                        class="absolute inset-0 bg-gradient-to-b from-[#eef5ff] to-[#dde9ff] transition-all duration-500"
                    ></div>

                    {{-- CONTENT --}}
                    <div class="relative z-10">

                        <h3 class="text-[clamp(28px,2.2vw,42px)] leading-[0.95] tracking-[-2px] font-normal text-[#111]">

                            Zorie is a
                            game changer
                            for us.

                        </h3>

                        <p class="mt-12 text-[15px] leading-[2.1] text-[#747474]">

                            It helps us turn ideas into actionable plans
                            and designs in record time.

                        </p>

                    </div>

                    {{-- USER --}}
                    <div class="relative z-10 flex items-center gap-4">

                        <img
                            src="https://i.pravatar.cc/100?img=12"
                            class="w-12 h-12 rounded-full object-cover"
                        >

                        <div>

                            <h4 class="text-[15px] font-medium text-[#111]">

                                Sofia Kim

                            </h4>

                            <p class="text-[13px] leading-[1.7] text-[#8e8e8e] mt-1">

                                Creative Director at Inno Labs

                            </p>

                        </div>

                    </div>

                </div>

            @endfor

        </div>

    </div>

</section>