{{-- Account Sidebar Component --}}
<aside class="hidden lg:flex flex-col w-[240px] flex-shrink-0 gap-2">
    <a href="{{ url('/') }}"
        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-black transition mb-6">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

        </svg>

        Kembali ke Beranda

    </a>
    {{-- User card --}}
    <div class="bg-white rounded-2xl border border-[#e5e5e3] p-5 mb-2">
        <div class="flex items-center gap-3">
            @if ($customer->profile_photo)

                @if (Str::startsWith($customer->profile_photo, 'http'))
                    <img src="{{ $customer->profile_photo }}" class="w-20 h-20 rounded-full object-cover">
                @else
                    <img src="{{ asset('storage/' . $customer->profile_photo) }}"
                        class="w-20 h-20 rounded-full object-cover">
                @endif
            @else
                <div class="w-20 h-20 rounded-full bg-[#111] text-white flex items-center justify-center text-[20px] font-black"
                    x-text="initials">
                </div>

            @endif
            <div class="min-w-0">
                <p class="text-[13px] font-bold text-[#111] truncate" x-text="user.name"></p>
                <p class="text-[11px] text-[#aaa] truncate" x-text="user.email"></p>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-[#f0f0ee]">
            <span :class="isVerified ? 'bg-[#111] text-white' : 'bg-[#fff3cd] text-[#856404]'"
                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-[0.06em] uppercase">
                <span x-text="isVerified ? '✓' : @if ($customer->email_verified) '✓' @else '!' @endif"></span>
                <span
                    x-text="isVerified ? 'Verified' : @if ($customer->email_verified) 'Verified' @else 'Belum Diverifikasi' @endif"></span>
            </span>
        </div>
    </div>

    {{-- Nav Links --}}
    @foreach ([
        ['customer.account', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'Dashboard'],
        ['customer.profile', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'Profile'],
        ['customer.orders', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'Orders'],
        ['customer.wishlist', 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'Wishlist'],
        ['customer.reviews', 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'Reviews'],
        ['customer.addresses', 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'Addresses'],
        ['customer.security', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'Security'],
    ] as [$route, $icon, $label])
        <a href="{{ route($route) }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl border {{ Route::is($route) ? 'bg-[#111] text-white border-[#111]' : 'bg-white text-[#555] hover:bg-[#f5f5f3] border-[#e5e5e3]' }} text-[12.5px] font-semibold tracking-[0.02em] transition-all w-full text-left">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
            </svg>
            {{ $label }}
        </a>
    @endforeach

    {{-- Logout --}}
    <button @click="logoutModal = true"
        class="flex items-center gap-3 px-4 py-3 rounded-xl border border-red-100 text-red-500 bg-white hover:bg-red-50 text-[12.5px] font-semibold tracking-[0.02em] transition-all w-full text-left mt-1">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        Logout
    </button>
</aside>
