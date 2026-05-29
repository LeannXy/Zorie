<div class="min-h-screen grid grid-cols-1 lg:grid-cols-[1.05fr_1fr] font-['Plus_Jakarta_Sans',sans-serif] bg-[#f5f5f3]">

    {{-- ═══════════ LEFT PANEL ═══════════ --}}
    <div
        class="relative overflow-hidden flex flex-col justify-between px-10 py-14 border-r border-[#e5e5e3] hidden lg:flex">

        {{-- Background ZORIE --}}
        <span
            class="absolute -bottom-16 -left-7 text-[310px] font-black tracking-[-0.07em] text-[#eceae8] leading-none select-none pointer-events-none whitespace-nowrap z-0"
            style="font-family:'Plus Jakarta Sans',sans-serif;">ZORIE</span>

        {{-- Top text --}}
        <div class="relative z-10">
            <div
                class="flex items-center gap-2.5 text-[10px] font-bold tracking-[0.16em] uppercase text-[#bbb] mb-6 before:block before:w-5 before:h-px before:bg-[#bbb]">
                New Season 2024
            </div>
            <p class="text-[60px] font-light italic tracking-[-0.055em] text-[#111] leading-[0.9]">forever</p>
            <p class="text-[68px] font-black tracking-[-0.065em] text-[#111] leading-[0.86] mt-1">FASTER..</p>
            <p class="text-[12.5px] leading-[1.75] text-[#aaa] mt-5 max-w-[272px]">
                Premium footwear engineered for those who never slow down. Step into your next chapter.
            </p>
        </div>

        {{-- Shoe --}}
        <div class="relative z-10 flex justify-center items-end flex-1 py-5">
            <div
                class="absolute bottom-1 left-1/2 -translate-x-1/2 w-[230px] h-[18px] rounded-full bg-black/[0.07] blur-[10px]">
            </div>
            <img src="https://pngimg.com/d/running_shoes_PNG5823.png"
                class="w-[300px] object-contain -rotate-[10deg] relative z-10" draggable="false" alt="Zorie shoe">
        </div>

        {{-- Bottom dots --}}
        <div class="relative z-10 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-[38px] h-[1.5px] bg-[#ddd] rounded-full"></div>
                <div
                    class="w-[11px] h-[11px] rounded-full bg-[#111] border-[3px] border-[#f5f5f3] shadow-[0_0_0_1px_#ccc]">
                </div>
                <div class="w-[38px] h-[1.5px] bg-[#ddd] rounded-full"></div>
            </div>
            <span class="text-[10px] font-bold tracking-[0.14em] uppercase text-[#ccc]">SS / 24</span>
        </div>

    </div>

    {{-- ═══════════ RIGHT PANEL ═══════════ --}}
    <div class="bg-white flex flex-col justify-center px-8 py-12 sm:px-14 min-h-screen border-l border-[#e5e5e3]">

        {{-- ── FORM STATE ── --}}
        <div x-transition>

            {{-- Back link --}}
           <a href="{{ route('customer.password.cancel') }}"
                class="inline-flex items-center gap-2 text-[10.5px] font-bold tracking-[0.12em] uppercase text-[#bbb] hover:text-[#111] transition-colors mb-10 group">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                    class="group-hover:-translate-x-0.5 transition-transform">
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Back to sign in
            </a>

            {{-- Header --}}
            <div
                class="flex items-center gap-2 text-[10px] font-bold tracking-[0.16em] uppercase text-[#bbb] mb-2.5 before:block before:w-4 before:h-px before:bg-[#bbb]">
                Account recovery
            </div>
            <h1 class="text-[34px] font-black tracking-[-0.05em] text-[#111] leading-none mb-2">Forgot password.</h1>
            <p class="text-[12.5px] text-[#bbb] leading-[1.65] mb-8 max-w-[340px]">
                No worries. Enter your registered email and we'll send you a reset link right away.
            </p>

            {{-- Session Status --}}
            @if (session('status'))
                <div
                    class="mb-6 px-4 py-3 rounded-[10px] bg-[#f0faf4] border border-[#c6ead6] text-[12px] text-[#2d7a4f] font-semibold">
                    {{ session('status') }}
                </div>
            @endif

            @if (!session('showOtpForm') && !session('showPasswordForm'))
                <form method="POST" action="{{ route('customer.password.send') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-6">
                        <label for="email"
                            class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">
                            Email address
                        </label>

                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required autofocus
                            class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px]">
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#111] text-white rounded-[10px]">

                        Send OTP

                    </button>

                </form>
            @endif

            @if (session('showOtpForm'))
                <form method="POST" action="{{ route('customer.password.verify') }}">

                    @csrf

                    <div class="mb-6">

                        <input type="text" name="otp" placeholder="Enter OTP"
                            class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px]">
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#111] text-white rounded-[10px]">

                        Verify OTP

                    </button>

                </form>
            @endif
            @if (session('showPasswordForm'))
                <form method="POST" action="{{ route('customer.password.reset') }}">

                    @csrf
                    <div class="mb-6">
                        <input type="hidden" name="email" value="{{ session('reset_email') }}"
                            class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px]">
                    </div>
                    <div class="mb-6">
                        <input type="password" name="password" placeholder="New Password"
                            class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px]">
                    </div>
                    <div class="mb-6">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password"
                            class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px]">
                    </div>
                    <button type="submit" class="w-full py-4 bg-[#111] text-white rounded-[10px]">

                        Reset Password

                    </button>

                </form>
            @endif
            <p class="mt-6 text-[12px] text-[#bbb] text-center leading-[1.6]">
                Remember your password?
                <a href="{{ route('customer.login') }}"
                    class="text-[#111] font-bold underline underline-offset-[3px]">Sign in</a>
            </p>

        </div>



    </div>
</div>
