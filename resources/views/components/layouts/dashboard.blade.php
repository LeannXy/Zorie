<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Dashboard' }}</title>
    @fluxAppearance
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <script>
        const darkMode = localStorage.getItem('darkMode');

        if (darkMode === 'true') {

            document.documentElement.classList.add('dark');

        } else {

            document.documentElement.classList.remove('dark');

        }
    </script>
</head>
@if(session('success'))
<div x-data="{show:true
        darkMode: localStorage.getItem('darkMode') === 'true',
    
        showNotifications: false,
    
        search: '',
    
        results: [],
    
        searchData() {
    
            fetch(
                    '/search?search=' +
                    this.search
                )
    
                .then(
                    response =>
                    response.json()
                )
    
                .then(
                    data => {
    
                        this.results =
                            data;
    
                    })
    
        }
    
    }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10"
        x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed top-6 right-6 z-[9999]">

        <div
            class="flex items-start gap-3 rounded-2xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-5 py-4 shadow-2xl min-w-[320px]">

            <div class="rounded-full bg-green-500/10 p-2">

                <i data-lucide="check" class="h-5 w-5 text-green-500">
                </i>

            </div>


            <div class="flex-1">

                <h3 class="font-semibold">

                    Success

                </h3>

                <p class="text-sm text-zinc-500">

                    {{ session('success') }}

                </p>

            </div>


            <button @click="show=false" class="text-zinc-400 hover:text-red-500">

                <i data-lucide="x" class="h-4 w-4">
                </i>

            </button>

        </div>

    </div>
@endif

<body class="bg-zinc-100 text-zinc-900 dark:bg-zinc-950 dark:text-white">

    <div x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        showNotifications: false
    }" x-init="if (darkMode) {
        document.documentElement.classList.add('dark')
    }" :class="{ 'dark': darkMode }"
        class="flex min-h-screen bg-zinc-100 text-zinc-900 transition dark:bg-zinc-950 dark:text-white">

        <!-- Sidebar -->
        <aside
            class="fixed left-0 top-0 h-screen w-72
border-r border-zinc-200
bg-white dark:border-zinc-800 dark:bg-zinc-950
overflow-y-auto z-50">

            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-6">

                <div class="flex items-center gap-3 px-2">

                    <!-- Logo Light -->
                    <img x-show="!darkMode" src="{{ asset('images/logo-light.jpg') }}" class="h-10 w-auto">

                    <!-- Logo Dark -->
                    <img x-show="darkMode" src="{{ asset('images/logo-dark.png') }}" class="h-10 w-auto">

                    <div>

                        <h1 class="text-3xl font-extrabold tracking-wide">

                            <span class="text-zinc-900 dark:text-white">Z</span>

                            <span class="text-blue-500">O</span>

                            <span class="text-zinc-900 dark:text-white">RIE</span>

                        </h1>

                        <p class="text-xs text-zinc-500 dark:text-zinc-400">

                            Shoe Store Admin

                        </p>

                    </div>

                </div>

            </div>

            <!-- Menu -->
            <nav class=" space-y-1 px-3">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('dashboard')
                            ? 'bg-blue-500/10 text-blue-500'
                            : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">

                    <i data-lucide="layout-dashboard" class="h-5 w-5"></i>

                    Dashboard

                </a>

                <!-- Products -->
                <a href="{{ route('products') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('products')
                            ? 'bg-blue-500/10 text-blue-500'
                            : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">

                    <i data-lucide="package" class="h-5 w-5"></i>

                    Produk

                </a>

                <!-- Categories -->
                <a href="{{ route('categories') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('categories')
                            ? 'bg-blue-500/10 text-blue-500'
                            : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">
                    <i data-lucide="layers-3" class="h-5 w-5"></i>

                    Kategori

                </a>

                <!-- Orders -->
                <a href="{{ route('orders') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('orders')
                            ? 'bg-blue-500/10 text-blue-500'
                            : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">

                    <i data-lucide="shopping-cart" class="h-5 w-5"></i>

                    Pesanan

                </a>

                <!-- Customers -->
                <!-- Customers -->

                <div x-data="{
                
                    open: {{ request()->routeIs('customers') || request()->routeIs('testimonials') ? 'true' : 'false' }}
                
                }" class="space-y-1">

                    <button @click="open=!open"
                        class="flex w-full items-center justify-between rounded-xl px-4 py-3 text-sm transition

{{ request()->routeIs('customers') || request()->routeIs('testimonials')
    ? 'bg-blue-500/10 text-blue-500'
    : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">

                        <div class="flex items-center gap-3">

                            <i data-lucide="users" class="h-5 w-5">
                            </i>

                            <span>

                                Customers

                            </span>

                        </div>

                        <i data-lucide="chevron-down" :class="{ 'rotate-180': open }"
                            class="h-4 w-4 transition-transform">
                        </i>

                    </button>


                    <div x-show="open" x-transition style="display:none"
                        class="ml-7 mt-2 space-y-1 border-l border-zinc-200 dark:border-zinc-800 pl-4">

                        <a href="{{ route('customers') }}"
                            class="block rounded-lg px-3 py-2 text-sm transition
                            {{ request()->routeIs('customers') ? 'bg-blue-500/10 text-blue-500' : 'text-zinc-500 hover:text-blue-500' }}">

                            Accounts

                        </a>


                        <a href="{{ route('testimonials') }}"
                            class="block rounded-lg px-3 py-2 text-sm transition
                            {{ request()->routeIs('testimonials') ? 'bg-blue-500/10 text-blue-500' : 'text-zinc-500 hover:text-blue-500' }}">

                            Testimonials

                        </a>

                    </div>
                </div>

                <!-- Analytics -->
                <a href="{{ route('analytics') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('analytics')
                            ? 'bg-blue-500/10 text-blue-500'
                            : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">

                    <i data-lucide="chart-column" class="h-5 w-5"></i>

                    Analytics

                </a>

                <!-- Divider -->
                <div class="my-4 border-t border-zinc-200 dark:border-zinc-800"></div>

                <div x-data="{ openSettings: {{ request()->routeIs('settings.*') ? 'true' : 'false' }} }">

                    <button @click="openSettings=!openSettings"
                        class="flex w-full items-center justify-between rounded-xl px-4 py-3 text-sm transition
        {{ request()->routeIs('settings.*')
            ? 'bg-blue-500/10 text-blue-500'
            : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">

                        <div class="flex items-center gap-3">

                            <i data-lucide="settings" class="h-5 w-5">
                            </i>

                            <span>

                                Settings

                            </span>

                        </div>

                        <i data-lucide="chevron-down" class="h-4 w-4 transition"
                            :class="openSettings ? 'rotate-180' : ''">
                        </i>

                    </button>


                    <div x-show="openSettings" x-transition class="mt-2 ml-6 space-y-2">

                        <a href="{{ route('settings.profile') }}"
                            class="block rounded-lg px-4 py-2 text-sm
            {{ request()->routeIs('settings.profile')
                ? 'text-blue-500'
                : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            Profile

                        </a>


                        <a href="{{ route('settings.security') }}"
                            class="block rounded-lg px-4 py-2 text-sm
            {{ request()->routeIs('settings.security')
                ? 'text-blue-500'
                : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            Security

                        </a>


                        <a href="{{ route('settings.appearance') }}"
                            class="block rounded-lg px-4 py-2 text-sm
            {{ request()->routeIs('settings.appearance')
                ? 'text-blue-500'
                : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            Appearance

                        </a>


                        <a href="{{ route('settings.notifications') }}"
                            class="block rounded-lg px-4 py-2 text-sm
            {{ request()->routeIs('settings.notifications')
                ? 'text-blue-500'
                : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            Notifications

                        </a>

                        <a href="{{ route('settings.system') }}"
                            class="block rounded-lg px-4 py-2 text-sm
{{ request()->routeIs('settings.system')
    ? 'text-blue-500'
    : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            System

                        </a>

                        <a href="{{ route('settings.activity') }}"
                            class="block rounded-lg px-4 py-2 text-sm
{{ request()->routeIs('settings.activity')
    ? 'text-blue-500'
    : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            Activity Logs

                        </a>

                        <a href="{{ route('settings.backup') }}"
                            class="block rounded-lg px-4 py-2 text-sm
{{ request()->routeIs('settings.backup')
    ? 'text-blue-500'
    : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            Backup & Data

                        </a>

                    </div>

                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm text-red-500 transition hover:bg-red-500/10">

                        <i data-lucide="log-out" class="h-5 w-5"></i>

                        Logout

                    </button>

                </form>

            </nav>

        </aside>

        <!-- Main -->
        <main class="ml-72 flex flex-1 flex-col">

            <header
                class="sticky top-0 z-40 flex items-center justify-between border-b border-zinc-200 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md px-8 py-5 dark:border-zinc-800">

                <!-- Search -->
                <form class="w-64 md:w-80">

                    <div class="relative">

                        <i data-lucide="search"
                            class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-zinc-500">
                        </i>

                        <div class="relative w-64 md:w-80">

                            <input x-model="search" @input.debounce.300ms="searchData()" type="text"
                                placeholder="Search..."
                                class="w-full rounded-xl border border-zinc-200 py-2 pl-10 pr-4">

                            <div x-show="results.length"
                                class="absolute top-full mt-2 w-full rounded-2xl border bg-white dark:bg-zinc-900 shadow-xl z-50">

                                <template x-for="item in results">

                                    <a :href="item.url"
                                        class="flex items-center justify-between p-3 hover:bg-zinc-100 dark:hover:bg-zinc-800">

                                        <div class="flex items-center gap-3">

                                            <i :data-lucide="item.icon" class="h-4 w-4 text-zinc-500">
                                            </i>

                                            <div>

                                                <p x-text="item.title"></p>

                                                <p class="text-xs text-zinc-500" x-text="item.type">
                                                </p>

                                            </div>

                                        </div>

                                    </a>

                                </template>

                            </div>

                        </div>

                    </div>

                </form>

                <!-- Right -->
                <div class="ml-6 flex items-center gap-3">

                    <!-- Theme Toggle -->
                    <button
                        @click="
                             darkMode = !darkMode;

                             localStorage.setItem('darkMode', darkMode);

                              if (darkMode) {
                                 document.documentElement.classList.add('dark')
                             } else {
                                    document.documentElement.classList.remove('dark')
                      }"
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-200 bg-white text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800">



                        <i x-show="!darkMode" data-lucide="moon" class="h-5 w-5"></i>
                        <i x-show="darkMode" data-lucide="sun" class="h-5 w-5"></i>

                    </button>

                    <!-- Notification -->
                    @php

                        $notifications = \App\Models\Notification::where('user_id', auth()->id())
                            ->latest()
                            ->take(99)
                            ->get();

                        $count = $notifications->where('is_read', false)->count();

                    @endphp


                    <div class="relative">

                        <button @click="showNotifications=!showNotifications"
                            class="relative flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 transition hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white">


                            <i data-lucide="bell" class="h-5 w-5"></i>


                            @if ($count > 0)
                                <span
                                    class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-blue-500 text-xs text-white">

                                    {{ $count }}

                                </span>
                            @endif

                        </button>

                        <div x-show="showNotifications" @click.away="showNotifications=false" x-transition
                            style="display:none"
                            class="absolute right-0 top-14 w-96 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-2xl z-50">

                            <div class="border-b border-zinc-200 dark:border-zinc-800 p-4">

                                <h3 class="font-semibold">

                                    Notifications

                                </h3>

                            </div>


                            <div class="max-h-96 overflow-y-auto">

                                @forelse($notifications as $notification)
                                    <div
                                        class="border-b border-zinc-100 dark:border-zinc-800 p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">

                                        <div class="flex justify-between gap-3">

                                            <div class="flex gap-3">

                                                <div class="rounded-xl bg-blue-500/10 p-2">

                                                    <i data-lucide="{{ $notification->icon }}"
                                                        class="h-4 w-4 text-blue-500">
                                                    </i>

                                                </div>

                                                <div>

                                                    <p class="font-medium">

                                                        {{ $notification->title }}

                                                    </p>

                                                    <p class="text-sm text-zinc-500">

                                                        {{ $notification->message }}

                                                    </p>

                                                    <p class="mt-1 text-xs text-zinc-400">

                                                        {{ $notification->created_at->diffForHumans() }}

                                                    </p>

                                                </div>

                                            </div>


                                            <form action="{{ route('notification.delete', $notification->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="text-zinc-400 hover:text-red-500">

                                                    <i data-lucide="x" class="h-4 w-4">
                                                    </i>

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                @empty

                                    <div class="p-6 text-center text-zinc-500">

                                        No notifications

                                    </div>
                                @endforelse

                            </div>

                        </div>

                    </div>

                    <!-- Profile -->


                    <div
                        class="flex items-center gap-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-3 py-2">

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500 text-sm font-semibold text-white">

                            @if (auth()->user()->profile_photo)
                                <img src="{{ Storage::url(auth()->user()->profile_photo) }}"
                                    class="h-full w-full object-cover">
                            @else
                                <div
                                    class="flex h-full w-full items-center justify-center bg-blue-500 text-4xl font-bold text-white">

                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                                </div>
                            @endif

                        </div>

                        <div class="hidden md:block">

                            <p class="text-sm font-medium">

                                {{ auth()->user()->name }}

                            </p>

                            <p class="text-xs text-zinc-500">

                                Admin

                            </p>

                        </div>

                    </div>

                </div>

            </header>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-10">

                {{ $slot }}

            </div>

        </main>

    </div>

    {{-- @livewireScripts
    @fluxScripts --}}

</body>

</html>
