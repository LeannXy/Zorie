<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,700;0,900;1,300&display=swap"
    rel="stylesheet">
<div class="min-h-screen grid grid-cols-1 lg:grid-cols-[1.05fr_1fr] font-['Plus_Jakarta_Sans',sans-serif] bg-[#f5f5f3]"
    x-data="{ tab: 'in' }">

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

        {{-- Tabs --}}
        <div class="flex border-b border-[#ececea] mb-10">

            <button @click="tab = 'in'"
                :class="tab === 'in'
                    ?
                    'text-[#111] border-b-2 border-[#111]' :
                    'text-[#ccc] border-b-2 border-transparent'"
                class="pb-4 mr-8 text-[10.5px] font-bold tracking-[0.14em] uppercase bg-transparent border-0 -mb-px cursor-pointer transition-colors duration-200 font-['Plus_Jakarta_Sans',sans-serif]">Sign
                in</button>

            <button @click="tab = 'up'"
                :class="tab === 'up'
                    ?
                    'text-[#111] border-b-2 border-[#111]' :
                    'text-[#ccc] border-b-2 border-transparent'"
                class="pb-4 text-[10.5px] font-bold tracking-[0.14em] uppercase bg-transparent border-0 -mb-px cursor-pointer transition-colors duration-200 font-['Plus_Jakarta_Sans',sans-serif]">Create
                account</button>

        </div>

        {{-- ── LOGIN ── --}}
        <div x-show="tab === 'in'" x-transition>

            <div
                class="flex items-center gap-2 text-[10px] font-bold tracking-[0.16em] uppercase text-[#bbb] mb-2.5 before:block before:w-4 before:h-px before:bg-[#bbb]">
                Welcome back
            </div>
            <h1 class="text-[34px] font-black tracking-[-0.05em] text-[#111] leading-none mb-2">Sign in.</h1>
            <p class="text-[12.5px] text-[#bbb] leading-[1.65] mb-8">
                Enter your credentials to access your Zorie account and continue your journey.
            </p>

            <form method="POST" action="{{ route('customer.login.post') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label for="login-email"
                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Email
                        address</label>
                    <input id="login-email" type="email" name="email" value="{{ old('email') }}"
                        placeholder="you@example.com" required autofocus
                        class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                    @error('email')
                        <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-2">
                    <label for="login-password"
                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Password</label>
                    <input id="login-password" type="password" name="password" placeholder="••••••••" required
                        class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                    @error('password')
                        <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Forgot --}}
                <div class="flex justify-end mb-6">
                    @if (Route::has('customer.password.request'))
                        <a href="{{ route('customer.password.request') }}"
                            class="text-[11px] font-bold text-[#bbb] underline underline-offset-[3px] decoration-[#ddd] hover:text-[#111] hover:decoration-[#111] transition-colors">Forgot
                            password?</a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full py-4 bg-[#111] text-[#f5f5f3] rounded-[10px] text-[10.5px] font-bold tracking-[0.18em] uppercase hover:bg-[#1a1a1a] hover:-translate-y-px hover:shadow-[0_8px_24px_rgba(0,0,0,0.16)] active:translate-y-0 active:shadow-none transition-all cursor-pointer">Sign
                    in to Zorie</button>

            </form>

            {{-- Or --}}
            <div class="flex items-center gap-3.5 my-5">
                <div class="flex-1 h-px bg-[#ebebea]"></div>
                <span class="text-[11px] text-[#ccc] font-semibold tracking-[0.06em]">or</span>
                <div class="flex-1 h-px bg-[#ebebea]"></div>
            </div>

            {{-- Google --}}
            <button type="button"
                class="w-full py-3 border border-[#e5e5e3] rounded-[10px] bg-transparent text-[12px] font-semibold text-[#555] flex items-center justify-center gap-2.5 hover:border-[#aaa] hover:bg-[#f8f8f6] transition-all cursor-pointer tracking-[0.02em]">
                <svg width="15" height="15" viewBox="0 0 24 24">
                    <path
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                        fill="#4285F4" />
                    <path
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                        fill="#34A853" />
                    <path
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                        fill="#FBBC05" />
                    <path
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                        fill="#EA4335" />
                </svg>
                Continue with Google
            </button>

            <p class="mt-6 text-[12px] text-[#bbb] text-center leading-[1.6]">
                New to Zorie?
                <button @click="tab = 'up'"
                    class="text-[#111] font-bold underline underline-offset-[3px] cursor-pointer bg-transparent border-0">Create
                    a free account</button>
            </p>

        </div>

        {{-- ── REGISTER ── --}}
        <div x-show="tab === 'up'" x-transition style="display:none;">

            <div
                class="flex items-center gap-2 text-[10px] font-bold tracking-[0.16em] uppercase text-[#bbb] mb-2.5 before:block before:w-4 before:h-px before:bg-[#bbb]">
                Get started
            </div>
            <h1 class="text-[34px] font-black tracking-[-0.05em] text-[#111] leading-none mb-2">Create account.</h1>
            <p class="text-[12.5px] text-[#bbb] leading-[1.65] mb-8">
                Join Zorie today. Fill in your details below to get started in seconds.
            </p>

            <form method="POST" action="{{ route('customer.register') }}">
                @csrf

                {{-- Name row --}}
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label for="reg-fname"
                            class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">First
                            name</label>
                        <input id="reg-fname" type="text" name="first_name" value="{{ old('first_name') }}"
                            placeholder="Alex" required
                            class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                    </div>
                    <div>
                        <label for="reg-lname"
                            class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Last
                            name</label>
                        <input id="reg-lname" type="text" name="last_name" value="{{ old('last_name') }}"
                            placeholder="Cruz" required
                            class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="reg-email"
                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Email
                        address</label>
                    <input id="reg-email" type="email" name="email" value="{{ old('email') }}"
                        placeholder="you@example.com" required
                        class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                    @error('email')
                        <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="reg-pass"
                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Password</label>
                    <input id="reg-pass" type="password" name="password" placeholder="Minimum 8 characters"
                        required
                        class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                    @error('password')
                        <span class="block mt-1.5 text-[11px] text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm --}}
                <div class="mb-4">
                    <label for="reg-confirm"
                        class="block text-[10px] font-bold tracking-[0.14em] uppercase text-[#aaa] mb-2">Confirm
                        password</label>
                    <input id="reg-confirm" type="password" name="password_confirmation"
                        placeholder="Repeat password" required
                        class="w-full px-4 py-3 border border-[#ebebea] rounded-[10px] bg-[#f8f8f6] text-[13.5px] text-[#111] outline-none placeholder:text-[#ccc] focus:border-[#111] focus:bg-white focus:ring-[3px] focus:ring-black/[0.06] transition-all">
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full mt-1 py-4 bg-[#111] text-[#f5f5f3] rounded-[10px] text-[10.5px] font-bold tracking-[0.18em] uppercase hover:bg-[#1a1a1a] hover:-translate-y-px hover:shadow-[0_8px_24px_rgba(0,0,0,0.16)] active:translate-y-0 active:shadow-none transition-all cursor-pointer">Create
                    my account</button>

            </form>

            <p class="mt-3.5 text-[10.5px] text-[#ccc] text-center leading-[1.65]">
                By continuing you agree to our
                <a href="#" class="text-[#aaa] underline underline-offset-[2px]">Terms of Service</a>
                and
                <a href="#" class="text-[#aaa] underline underline-offset-[2px]">Privacy Policy</a>.
            </p>

            <p class="mt-4 text-[12px] text-[#bbb] text-center leading-[1.6]">
                Already have an account?
                <button @click="tab = 'in'"
                    class="text-[#111] font-bold underline underline-offset-[3px] cursor-pointer bg-transparent border-0">Sign
                    in</button>
            </p>

        </div>

    </div>
</div>
