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

    <style>
        /* Custom scrollbar styling */
        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            border-radius: 3px;
            background: #d4d4d8;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #52525b;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a1a1aa;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #71717a;
        }
    </style>
</head>
@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
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
    
        darkMode: localStorage.getItem(
            'darkMode'
        ) === 'true',
    
        showNotifications: false,
    
        sidebarOpen: false,
    
        search: '',
    
        results: [],
    
        openSearch: false,
    
        searchData() {
    
            if (
                this.search.trim() === ''
            ) {
    
                this.results = [];
    
                this.openSearch = false;
    
                return;
    
            }
    
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
    
                        this.results = data;
    
                        this.openSearch =
                            data.length > 0;
    
                    });
    
        }
    
    }"
        class="flex min-h-screen bg-zinc-100 text-zinc-900 transition dark:bg-zinc-950 dark:text-white">

        <!-- Sidebar Overlay for mobile -->
        <div @click="sidebarOpen=false" :class="{ 'hidden': !sidebarOpen, 'block': sidebarOpen }"
            class="fixed inset-0 bg-black/50 z-40 md:hidden md:hidden">
        </div>

        <!-- Sidebar -->
        <aside
            class="fixed left-0 top-0 h-screen w-72 border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950 overflow-y-auto z-50 md:flex flex-col"
            :class="{ 'hidden': !sidebarOpen, 'flex': sidebarOpen, 'md:flex': true }">

            <!-- Close button for mobile -->
            <button @click="sidebarOpen=false"
                class="md:hidden absolute top-6 right-4 text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                <i data-lucide="x" class="h-6 w-6"></i>
            </button>

            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-6">

                <div class="flex items-center gap-3 px-2">

                    <!-- Logo Light -->
                    <img x-show="!darkMode" src="{{ asset('images/logo-light.png') }}" class="h-10 w-auto">

                    <!-- Logo Dark -->
                    <img x-show="darkMode" src="{{ asset('images/logo-dark.png') }}" class="h-10 w-auto">

                    <div>

                        <h1 class="text-3xl font-extrabold tracking-tight">

                            <span class="text-zinc-900 dark:text-white">Z</span>
                            <span class="dark:text-blue-500 text-zinc-900">O</span>
                            <span class="text-zinc-900 dark:text-white">R</span>
                            <span class="text-zinc-900 dark:text-white">I</span>
                            <span class="text-zinc-900 dark:text-white">E</span>

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
                <a href="{{ route('dashboard') }}" @click="sidebarOpen=false"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('dashboard')
                            ? 'bg-blue-500/10 text-blue-500'
                            : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">

                    <i data-lucide="layout-dashboard" class="h-5 w-5"></i>

                    Dashboard

                </a>

                <!-- Products -->
                <a href="{{ route('products') }}" @click="sidebarOpen=false"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('products')
                            ? 'bg-blue-500/10 text-blue-500'
                            : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">

                    <i data-lucide="package" class="h-5 w-5"></i>

                    Produk

                </a>

                <!-- Categories -->
                <a href="{{ route('categories') }}" @click="sidebarOpen=false"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
                        {{ request()->routeIs('categories')
                            ? 'bg-blue-500/10 text-blue-500'
                            : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">
                    <i data-lucide="layers-3" class="h-5 w-5"></i>

                    Kategori

                </a>

                <!-- Orders -->
                <a href="{{ route('orders') }}" @click="sidebarOpen=false"
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

                        <a href="{{ route('customers') }}" @click="sidebarOpen=false"
                            class="block rounded-lg px-3 py-2 text-sm transition
                            {{ request()->routeIs('customers') ? 'bg-blue-500/10 text-blue-500' : 'text-zinc-500 hover:text-blue-500' }}">

                            Accounts

                        </a>


                        <a href="{{ route('testimonials') }}" @click="sidebarOpen=false"
                            class="block rounded-lg px-3 py-2 text-sm transition
                            {{ request()->routeIs('testimonials') ? 'bg-blue-500/10 text-blue-500' : 'text-zinc-500 hover:text-blue-500' }}">

                            Testimonials

                        </a>

                    </div>
                </div>

                <!-- Analytics -->
                <a href="{{ route('analytics') }}" @click="sidebarOpen=false"
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

                        <a href="{{ route('settings.profile') }}" @click="sidebarOpen=false"
                            class="block rounded-lg px-4 py-2 text-sm
                             {{ request()->routeIs('settings.profile')
                                 ? 'text-blue-500'
                                 : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            Profile

                        </a>


                        <a href="{{ route('settings.security') }}" @click="sidebarOpen=false"
                            class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('settings.security')
                                ? 'text-blue-500'
                                : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            Security

                        </a>

                        <a href="{{ route('settings.system') }}" @click="sidebarOpen=false"
                            class="block rounded-lg px-4 py-2 text-sm
                            {{ request()->routeIs('settings.system')
                                ? 'text-blue-500'
                                : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            System

                        </a>

                        <a href="{{ route('settings.activity') }}" @click="sidebarOpen=false"
                            class="block rounded-lg px-4 py-2 text-sm
                                {{ request()->routeIs('settings.activity')
                                    ? 'text-blue-500'
                                    : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">

                            Activity Logs

                        </a>

                        <a href="{{ route('settings.backup') }}" @click="sidebarOpen=false"
                            class="block rounded-lg px-4 py-2 text-sm{{ request()->routeIs('settings.backup')
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
        <main class="md:ml-72 flex flex-1 flex-col w-full">

            <header
                class="sticky top-0 z-40 flex items-center justify-between border-b border-zinc-200 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md px-6 md:px-8 py-4 md:py-5 dark:border-zinc-800">

                <!-- Mobile Sidebar & search Toggle -->
                <div class="md:hidden flex items-center gap-2">

                    <button @click="sidebarOpen=!sidebarOpen"
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">

                        <i data-lucide="menu" class="h-5 w-5"></i>

                    </button>

                    <button @click="openSearch=true"
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">

                        <i data-lucide="search" class="h-5 w-5"></i>

                    </button>

                </div>

                <!-- Search -->
                <!-- Search Desktop -->
                <div class="hidden md:block flex-1 max-w-lg ml-6">

                    <div class="relative w-full max-w-xl" @click.away="openSearch=false">

                        <i data-lucide="search"
                            class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-zinc-400">
                        </i>

                        <input x-model="search" @focus="if(results.length)openSearch=true"
                            @input.debounce.300ms="searchData()" type="text"
                            placeholder="Search products, customers, orders..."
                            class="h-11 w-full rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 pl-11 pr-4 text-sm shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none">

                        <div x-show="openSearch" x-transition style="display:none"
                            class="absolute top-[115%] w-full overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-xl z-50">

                            <div class="border-b border-zinc-100 dark:border-zinc-800 px-4 py-3">

                                <p class="text-xs uppercase tracking-wider text-zinc-400">

                                    Search Results

                                </p>

                            </div>

                            <div class="max-h-80 overflow-y-auto">

                                <template x-for="item in results">

                                    <a :href="item.url"
                                        class="group flex items-center gap-3 px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">


                                        <div class="flex-1">

                                            <p class="font-medium text-sm" x-text="item.title">
                                            </p>

                                            <p class="text-xs text-zinc-500" x-text="item.type">
                                            </p>

                                        </div>

                                        <i data-lucide="chevron-right"
                                            class="h-4 w-4 text-zinc-400 opacity-0 transition group-hover:opacity-100">
                                        </i>

                                    </a>

                                </template>

                                <div x-show="results.length===0" class="p-8 text-center">

                                    <i data-lucide="search-x" class="mx-auto h-8 w-8 text-zinc-300">
                                    </i>

                                    <p class="mt-2 text-sm text-zinc-500">

                                        No results found

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- Mobile Search Modal -->
                <div x-show="openSearch" x-transition style="display:none"
                    class="fixed inset-0 z-[9999] bg-white dark:bg-zinc-950 md:hidden">

                    <div class="border-b border-zinc-200 dark:border-zinc-800 p-4 bg-white dark:bg-zinc-950">

                        <div class="flex items-center gap-3">

                            <input x-model="search" @input.debounce.300ms="searchData()" type="text"
                                placeholder="Search..."
                                class="h-12 flex-1 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <button @click="openSearch=false" class="font-medium text-zinc-500">

                                Cancel

                            </button>

                        </div>

                    </div>

                    <div class="h-[calc(100vh-80px)] overflow-y-auto bg-white dark:bg-zinc-950 p-4">

                        <template x-for="item in results">

                            <a :href="item.url"
                                class="mb-2 flex items-center gap-3 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-4 shadow-sm">

                                <div class="flex-1">

                                    <p class="font-medium" x-text="item.title">
                                    </p>

                                    <p class="text-xs text-zinc-500" x-text="item.type">
                                    </p>

                                </div>

                            </a>

                        </template>

                    </div>

                </div>

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


                    <div class="relative" x-data="{ openProfile: false }">

                        <button @click="openProfile=!openProfile"
                            class="flex items-center gap-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-2 md:px-3 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">

                            <div class="relative">

                                @if (auth()->user()->profile_photo)
                                    <img src="{{ Storage::url(auth()->user()->profile_photo) }}"
                                        class="h-10 w-10 rounded-full object-cover flex-shrink-0">
                                @else
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white font-bold text-sm flex-shrink-0">

                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                                    </div>
                                @endif

                                <span
                                    class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 border-2 border-white dark:border-zinc-900 flex-shrink-0">
                                </span>

                            </div>

                            <div class="hidden md:block text-left">

                                <p class="text-sm font-medium">

                                    {{ auth()->user()->name }}

                                </p>

                                <p class="text-xs text-zinc-500">

                                    Administrator

                                </p>

                            </div>

                            <i data-lucide="chevron-down" class="h-4 w-4 text-zinc-500">
                            </i>

                        </button>


                        <div x-show="openProfile" @click.away="openProfile=false" x-transition style="display:none"
                            class="absolute right-0 top-14 w-56 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-xl z-50">

                            <a href="{{ route('settings.profile') }}"
                                class="flex items-center gap-3 p-4 hover:bg-zinc-100 dark:hover:bg-zinc-800">

                                <i data-lucide="user" class="h-4 w-4"></i>

                                Profile

                            </a>


                            <a href="{{ route('settings.system') }}"
                                class="flex items-center gap-3 p-4 hover:bg-zinc-100 dark:hover:bg-zinc-800">

                                <i data-lucide="settings" class="h-4 w-4"></i>

                                Settings

                            </a>


                            <form action="{{ route('logout') }}" method="POST">

                                @csrf

                                <button type="submit"
                                    class="flex w-full items-center gap-3 p-4 text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">

                                    <i data-lucide="log-out" class="h-4 w-4"></i>

                                    Logout

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </header>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-10">

                {{ $slot }}

            </div>

        </main>

    </div>

    {{-- @livewireScripts
    @fluxScripts --}}

</body>

</html>
