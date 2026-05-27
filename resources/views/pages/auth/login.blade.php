<x-layouts::auth :title="__('Log in')">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    :root {
        --brand: #2B7FFF;
        --brand-glow: rgba(43, 127, 255, 0.18);
        --brand-subtle: rgba(43, 127, 255, 0.08);
        --brand-dim: rgba(43, 127, 255, 0.35);
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Animated grid background ── */
    .zorie-bg {
        position: fixed;
        inset: 0;
        z-index: 0;
        overflow: hidden;
        background: #f5f6fa;
        transition: background 0.4s;
    }
    .dark .zorie-bg {
        background: #0a0b0f;
    }

    .grid-canvas {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(43,127,255,0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(43,127,255,0.06) 1px, transparent 1px);
        background-size: 48px 48px;
        animation: grid-drift 20s linear infinite;
        mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
    }
    .dark .grid-canvas {
        background-image:
            linear-gradient(rgba(43,127,255,0.08) 1px, transparent 1px),
            linear-gradient(90deg, rgba(43,127,255,0.08) 1px, transparent 1px);
    }

    @keyframes grid-drift {
        0%   { transform: translateY(0); }
        100% { transform: translateY(48px); }
    }

    /* Floating orbs */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0;
        animation: orb-float 8s ease-in-out infinite;
    }
    .orb-1 {
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(43,127,255,0.22), transparent 70%);
        top: -100px; left: -100px;
        animation-delay: 0s;
    }
    .orb-2 {
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(43,127,255,0.15), transparent 70%);
        bottom: -80px; right: -80px;
        animation-delay: -4s;
    }
    .dark .orb-1 { opacity: 1; }
    .dark .orb-2 { opacity: 1; }
    .orb-1-light {
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(43,127,255,0.10), transparent 70%);
        top: -80px; right: 20%;
        opacity: 1;
        animation-delay: -2s;
    }

    @keyframes orb-float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33%       { transform: translate(20px, -20px) scale(1.05); }
        66%       { transform: translate(-15px, 15px) scale(0.97); }
    }

    /* ── Login wrapper ── */
    .zorie-wrapper {
        position: relative;
        z-index: 10;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
        padding: 2rem 1rem;
        justify-content: center;
    }

    /* ── Logo & brand ── */
    .zorie-brand {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2.25rem;
        opacity: 0;
        transform: translateY(-24px);
        animation: slide-in 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s forwards;
    }

    .zorie-logo-img {
        height: 44px;
        width: auto;
        margin-bottom: 1rem;
        filter: drop-shadow(0 0 16px var(--brand-glow));
    }

    .zorie-wordmark {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 3rem;
        letter-spacing: 0.12em;
        color: var(--brand);
        line-height: 1;
        text-shadow: 0 0 32px var(--brand-glow);
        position: relative;
    }
    .zorie-wordmark::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: var(--brand);
        border-radius: 2px;
        animation: line-expand 0.8s cubic-bezier(0.34, 1.2, 0.64, 1) 0.7s forwards;
    }
    @keyframes line-expand {
        to { width: 80%; }
    }

    .zorie-tagline {
        margin-top: 0.75rem;
        font-size: 0.95rem;
        color: #6b7280;
        font-weight: 300;
        letter-spacing: 0.04em;
    }
    .dark .zorie-tagline { color: #9ca3af; }

    .zorie-sub {
        font-size: 0.8rem;
        color: #9ca3af;
        font-weight: 300;
        margin-top: 0.2rem;
    }
    .dark .zorie-sub { color: #6b7280; }

    @keyframes slide-in {
        to { opacity: 1; transform: translateY(0); }
    }

    /* ── Card ── */
    .zorie-card {
        width: 100%;
        max-width: 420px;
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(43,127,255,0.15);
        border-radius: 20px;
        padding: 2rem;
        box-shadow:
            0 4px 6px -1px rgba(0,0,0,0.04),
            0 20px 60px -10px rgba(43,127,255,0.08),
            inset 0 1px 0 rgba(255,255,255,0.7);
        opacity: 0;
        transform: translateY(20px);
        animation: slide-in 0.65s cubic-bezier(0.34, 1.2, 0.64, 1) 0.25s forwards;
        position: relative;
        overflow: hidden;
    }

    .dark .zorie-card {
        background: rgba(15, 17, 26, 0.88);
        border: 1px solid rgba(43,127,255,0.2);
        box-shadow:
            0 4px 6px -1px rgba(0,0,0,0.3),
            0 20px 60px -10px rgba(43,127,255,0.15),
            inset 0 1px 0 rgba(255,255,255,0.04);
    }

    /* Card shine effect */
    .zorie-card::before {
        content: '';
        position: absolute;
        top: 0; left: -60%;
        width: 40%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
        transform: skewX(-20deg);
        animation: card-shine 4s ease-in-out 1.2s infinite;
    }
    @keyframes card-shine {
        0%, 70%, 100% { left: -60%; opacity: 0; }
        20%            { left: 130%; opacity: 1; }
    }

    /* ── Form fields ── */
    .field-group {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .field-wrapper {
        opacity: 0;
        transform: translateX(-10px);
        animation: field-in 0.5s ease forwards;
    }
    .field-wrapper:nth-child(1) { animation-delay: 0.4s; }
    .field-wrapper:nth-child(2) { animation-delay: 0.5s; }
    .field-wrapper:nth-child(3) { animation-delay: 0.6s; }
    .field-wrapper:nth-child(4) { animation-delay: 0.65s; }
    .field-wrapper:nth-child(5) { animation-delay: 0.7s; }

    @keyframes field-in {
        to { opacity: 1; transform: translateX(0); }
    }

    /* Password relative wrapper */
    .pwd-wrap {
        position: relative;
    }

    /* ── Submit button ── */
    .zorie-submit {
        position: relative;
        width: 100%;
        padding: 0.8rem 1.5rem;
        background: var(--brand);
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.95rem;
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        overflow: hidden;
        transition: transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 4px 20px rgba(43,127,255,0.35);
    }
    .zorie-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(43,127,255,0.45);
    }
    .zorie-submit:active {
        transform: translateY(0) scale(0.98);
    }
    /* Ripple effect */
    .zorie-submit::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(255,255,255,0.12), transparent);
        border-radius: inherit;
    }
    /* Shimmer on hover */
    .zorie-submit::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 60%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0s;
    }
    .zorie-submit:hover::before {
        left: 160%;
        transition: left 0.5s ease;
    }

    /* ── Divider ── */
    .zorie-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0.25rem 0;
    }
    .zorie-divider-line {
        flex: 1;
        height: 1px;
        background: rgba(43,127,255,0.15);
    }

    /* ── Footer link ── */
    .zorie-footer {
        text-align: center;
        font-size: 0.85rem;
        color: #9ca3af;
        opacity: 0;
        animation: slide-in 0.5s ease 0.85s forwards;
        margin-top: 1.5rem;
    }
    .dark .zorie-footer { color: #6b7280; }

    /* ── Theme toggle ── */
    .theme-toggle {
        position: fixed;
        top: 1.25rem;
        right: 1.25rem;
        z-index: 100;
        width: 40px; height: 40px;
        border-radius: 50%;
        border: 1px solid rgba(43,127,255,0.25);
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(12px);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        color: #374151;
    }
    .dark .theme-toggle {
        background: rgba(20,22,35,0.85);
        color: #e5e7eb;
        border-color: rgba(43,127,255,0.3);
    }
    .theme-toggle:hover {
        background: var(--brand);
        color: #fff;
        border-color: transparent;
        transform: rotate(20deg) scale(1.08);
    }
    .theme-toggle svg {
        width: 18px; height: 18px;
        transition: opacity 0.2s, transform 0.3s;
    }
    .icon-sun  { display: none; }
    .dark .icon-moon { display: none; }
    .dark .icon-sun  { display: block; }

    /* ── Floating badge ── */
    .admin-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.7rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--brand);
        background: var(--brand-subtle);
        border: 1px solid var(--brand-dim);
        border-radius: 999px;
        padding: 3px 10px;
        margin-bottom: 0.6rem;
        opacity: 0;
        animation: slide-in 0.5s ease 0s forwards;
    }
    .admin-badge-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--brand);
        box-shadow: 0 0 6px var(--brand);
        animation: pulse-dot 1.8s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.5; transform: scale(0.7); }
    }

    /* Shoe icon decoration */
    .shoe-decoration {
        position: absolute;
        top: -18px;
        right: -18px;
        width: 120px;
        height: 120px;
        opacity: 0.035;
        pointer-events: none;
    }
    .dark .shoe-decoration { opacity: 0.06; }
</style>

<!-- Alpine root: isDark state reaktif untuk semua child termasuk logo -->
<div
    x-data="{
        isDark: localStorage.getItem('zorie-theme') === 'dark'
            || (!localStorage.getItem('zorie-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
    }"
    x-init="document.documentElement.classList.toggle('dark', isDark)"
    @keydown.window.alt.t="isDark = !isDark; document.documentElement.classList.toggle('dark', isDark); localStorage.setItem('zorie-theme', isDark ? 'dark' : 'light')"
>

<!-- Animated background -->
<div class="zorie-bg">
    <div class="grid-canvas"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-1-light"></div>
</div>

<!-- Theme toggle -->
<button class="theme-toggle" aria-label="Toggle theme" title="Toggle dark/light"
    @click="isDark = !isDark; document.documentElement.classList.toggle('dark', isDark); localStorage.setItem('zorie-theme', isDark ? 'dark' : 'light'); $el.style.transform='rotate(360deg) scale(1.15)'; setTimeout(()=>$el.style.transform='',350)">
    <!-- Moon icon -->
    <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
    </svg>
    <!-- Sun icon -->
    <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="5"/>
        <path stroke-linecap="round" d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
    </svg>
</button>

<!-- Main content -->
<div class="zorie-wrapper">
    <div class="flex flex-col items-center w-full max-w-sm">

        <!-- Brand header -->
        <div class="zorie-brand">
            <span class="admin-badge">
                <span class="admin-badge-dot"></span>
                Admin Portal
            </span>

            {{-- Logo reaktif: ganti otomatis saat dark/light toggle --}}
            <img
                id="brandLogo"
                :src="isDark ? '{{ asset('images/logo-dark.png') }}' : '{{ asset('images/logo-light.png') }}'"
                alt="ZORIE Logo"
                class="zorie-logo-img"
                onerror="this.style.display='none'"
            />

            <div class="zorie-wordmark">ZORIE</div>
            <p class="zorie-tagline">Welcome back 👋</p>
            <p class="zorie-sub">Sign in to continue to your dashboard</p>
        </div>

        <!-- Status message -->
        <x-auth-session-status
            class="mb-4 text-center w-full"
            :status="session('status')" />

        <!-- Login card -->
        <div class="zorie-card w-full">

            <!-- Decorative shoe SVG watermark -->
            <svg class="shoe-decoration" viewBox="0 0 100 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 65 Q20 40 50 38 Q65 36 75 42 L85 55 Q90 60 85 68 L20 72 Q12 72 10 65Z" fill="#2B7FFF"/>
                <ellipse cx="22" cy="72" rx="8" ry="5" fill="#2B7FFF"/>
                <ellipse cx="72" cy="70" rx="10" ry="5" fill="#2B7FFF"/>
            </svg>

            <form
                method="POST"
                action="{{ route('login.store') }}"
                class="flex flex-col gap-5">

                @csrf

                <!-- Email field -->
                <div class="field-wrapper">
                    <flux:input
                        name="email"
                        :label="__('Email address')"
                        :value="old('email')"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                </div>

                <!-- Password field -->
                <div class="field-wrapper">
                    <div class="pwd-wrap">
                        <flux:input
                            name="password"
                            :label="__('Password')"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            viewable
                        />

                        @if (Route::has('password.request'))
                            <flux:link
                                class="absolute top-0 end-0 text-sm"
                                style="font-size: 0.78rem; color: var(--brand); opacity: 0.85;"
                                :href="route('password.request')"
                                wire:navigate>
                                Forgot password?
                            </flux:link>
                        @endif
                    </div>
                </div>

                <!-- Remember me -->
                <div class="field-wrapper">
                    <flux:checkbox
                        name="remember"
                        :label="__('Remember me')"
                        :checked="old('remember')" />
                </div>

                <!-- Divider -->
                <div class="field-wrapper zorie-divider">
                    <div class="zorie-divider-line"></div>
                </div>

                <!-- Submit -->
                <div class="field-wrapper">
                    <button type="submit" class="zorie-submit" data-test="login-button">
                        Log In
                    </button>
                </div>

            </form>
        </div>

        <!-- Sign up link -->
        @if (Route::has('register'))
            <div class="zorie-footer">
                Don't have an account?
                <flux:link
                    :href="route('register')"
                    wire:navigate
                    style="color: var(--brand); font-weight: 500; margin-left: 4px;">
                    Sign up
                </flux:link>
            </div>
        @endif

    </div>
</div>

</div>{{-- end Alpine root --}}

</x-layouts::auth>