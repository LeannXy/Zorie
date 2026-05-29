<section class="bg-[#f5f5f3] py-10">

    <div class="max-w-[1600px] mx-auto px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            @foreach ([
                ['Free Shipping','On all orders over $50'],
                ['Easy Returns','30-day return policy'],
                ['Secure Payment','100% secure checkout'],
                ['24/7 Support','We’re here to help']
            ] as $service)

                <div class="bg-white rounded-[24px] border border-[#ececec] px-8 py-7 flex items-center gap-5">

                    <div class="w-14 h-14 rounded-full border border-[#d9d9d9] flex items-center justify-center text-[24px]">

                        ⌁

                    </div>

                    <div>

                        <h3 class="text-[22px] font-semibold text-[#111]">

                            {{ $service[0] }}

                        </h3>

                        <p class="text-[16px] text-[#777] mt-1">

                            {{ $service[1] }}

                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>