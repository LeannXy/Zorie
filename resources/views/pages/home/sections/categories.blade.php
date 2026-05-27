<section class="bg-[#f5f5f3] py-14">

    <div class="max-w-[1600px] mx-auto px-8">

        <div class="flex items-center justify-between mb-14">

            <h2 class="text-[56px] leading-none tracking-[-3px] font-bold">

                ↗ Buka situs

            </h2>

            <button class="w-16 h-16 rounded-full border border-[#d9d9d9] text-[30px] hover:bg-black hover:text-white transition-all">

                ⟳

            </button>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

            @foreach (['Casual Sneakers','Running Shoes','Sports Shoes','Formal Shoes'] as $item)

                <div>

                    <div class="bg-white rounded-[28px] overflow-hidden border border-[#ececec] h-[220px] flex items-center justify-center">

                        <img
                            src="https://images.unsplash.com/photo-1542291026-7eec264c27ff"
                            class="w-[240px] object-contain hover:scale-110 transition-all duration-500"
                        >

                    </div>

                    <div class="mt-5">

                        <h3 class="text-[28px] font-semibold text-[#111]">

                            {{ $item }}

                        </h3>

                        <p class="text-[18px] text-[#666] mt-2">

                            Shop Now →

                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>