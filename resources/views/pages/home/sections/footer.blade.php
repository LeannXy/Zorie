<footer class="bg-[#f5f5f3] pb-8">

    <div class="max-w-[1720px] mx-auto px-5">

        <div class="border border-[#e5e5e5] rounded-[36px] overflow-hidden bg-[#f7f7f5]">

            {{-- TOP --}}
            <div class="grid lg:grid-cols-12 border-b border-[#e5e5e5]">

                {{-- LOGO --}}
                <div class="lg:col-span-3 p-16 border-r border-[#e5e5e5]">

                    <h1 class="text-[82px] leading-none tracking-[-6px] font-medium text-[#111]">
                        ZORIE
                    </h1>

                </div>

                {{-- NEWSLETTER --}}
                <div class="lg:col-span-9 p-16">

                    <div class="flex flex-col lg:flex-row justify-between gap-16">

                        <div class="w-full max-w-3xl">

                            <h3 class="text-[54px] leading-[1.05] tracking-[-3px] font-normal text-[#111]">
                                Subscribe to be in touch*
                            </h3>

                            <div class="mt-20 border-b border-[#111] pb-6">

                                <input
                                    type="text"
                                    placeholder="Your e-mail"
                                    class="w-full bg-transparent outline-none text-[22px] placeholder:text-[#9c9c9c]"
                                >

                            </div>

                        </div>

                        <div class="flex flex-col justify-between items-start lg:items-end">

                            <p class="uppercase tracking-[3px] text-[11px] text-[#9a9a9a]">
                                *Only valuable resources
                            </p>

                            <button class="mt-10 lg:mt-0 bg-[#111] text-white px-12 py-5 rounded-[14px] text-[15px] hover:opacity-80 transition-all duration-300">
                                SUBSCRIBE
                            </button>

                        </div>

                    </div>

                </div>

            </div>

            {{-- LINKS --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 border-b border-[#e5e5e5]">

                {{-- ECOSYSTEM --}}
                <div class="p-16 border-r border-[#e5e5e5]">

                    <h4 class="uppercase text-[12px] tracking-[3px] text-[#999] mb-12">
                        Ecosystem
                    </h4>

                    <ul class="space-y-8 text-[22px] text-[#111]">

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Zorie AI
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Zorie Workspace
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Zorie Docs
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Zorie Pad
                        </li>

                    </ul>

                </div>

                {{-- QUICK LINKS --}}
                <div class="p-16 border-r border-[#e5e5e5]">

                    <h4 class="uppercase text-[12px] tracking-[3px] text-[#999] mb-12">
                        Quick Links
                    </h4>

                    <ul class="space-y-8 text-[22px] text-[#111]">

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Home
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Shop
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            About Us
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Contact
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            FAQs
                        </li>

                    </ul>

                </div>

                {{-- LEGAL --}}
                <div class="p-16 border-r border-[#e5e5e5]">

                    <h4 class="uppercase text-[12px] tracking-[3px] text-[#999] mb-12">
                        Legal
                    </h4>

                    <ul class="space-y-8 text-[22px] text-[#111]">

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Privacy Policy
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Cookie Policy
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Terms of Service
                        </li>

                        <li class="hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            Refund Policy
                        </li>

                    </ul>

                </div>

                {{-- SOCIAL --}}
                <div class="p-16">

                    <ul class="space-y-10 text-[22px] text-[#111]">

                        <li class="flex justify-between hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            INSTAGRAM
                            <span>↗</span>
                        </li>

                        <li class="flex justify-between hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            X / TWITTER
                            <span>↗</span>
                        </li>

                        <li class="flex justify-between hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            LINKEDIN
                            <span>↗</span>
                        </li>

                        <li class="flex justify-between hover:translate-x-1 transition-all duration-300 cursor-pointer">
                            YOUTUBE
                            <span>↗</span>
                        </li>

                    </ul>

                </div>

            </div>

            {{-- COPYRIGHT --}}
            <div class="px-16 py-10 border-b border-[#e5e5e5]">

                <p class="uppercase tracking-[2px] text-[12px] text-[#8f8f8f]">
                    © 2024 ZORIE. ALL RIGHTS RESERVED.
                </p>

            </div>

            {{-- BIG LOGO --}}
      {{-- BIG ZORIE --}}
<div
    x-data="{
        active: 0,

        startAnimation() {

            setInterval(() => {

                this.active++

                if(this.active > 4){
                    this.active = 0
                }

            }, 900)

        }
    }"

    x-init="startAnimation()"

    class="grid grid-cols-5 min-h-[520px]"
>

    @foreach (str_split('ZORIE') as $index => $letter)

        <div class="border-r border-[#e7e7e7] overflow-hidden">

            <div class="h-[360px] overflow-hidden flex items-start justify-center">

                <div
                    :class="active === {{ $index }}
                        ? '-translate-y-[360px]'
                        : 'translate-y-0'"
                    class="transition-all duration-700 ease-in-out"
                >

                    {{-- FIRST --}}
                    <div
                        class="h-[360px] flex items-center justify-center text-[360px] leading-none tracking-[-10px] font-medium text-[#111]"
                    >
                        {{ $letter }}
                    </div>

                    {{-- SECOND --}}
                    <div
                        class="h-[360px] flex items-center justify-center text-[360px] leading-none tracking-[-10px] font-medium text-[#111]"
                    >
                        {{ $letter }}
                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>

        </div>

    </div>

</footer>