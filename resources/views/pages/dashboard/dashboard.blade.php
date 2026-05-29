<x-layouts.dashboard>

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">
                Dashboard
            </h1>

            <p class="mt-1 text-sm text-zinc-500">
                Welcome back, Admin
            </p>

        </div>

        <a href="{{ route('dashboard.export') }}"
            class="w-full sm:w-auto text-center rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 transition hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:shadow-md">

            Export Report

        </a>

    </div>

    <!-- Stats -->
    <div class="grid gap-4 sm:gap-5 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('orders') }}"
            class="group rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 md:p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-blue-500/50 active:scale-95 sm:active:scale-100">
            <!-- Card: Total Revenue -->

            <div class="flex items-center justify-between gap-3">

                <div class="min-w-0">

                    <p class="text-xs md:text-sm text-zinc-500 truncate">
                        Total Revenue
                    </p>

                    <h2 class="mt-2 md:mt-3 text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white truncate">
                        Rp {{ number_format($revenue, 0, ',', '.') }}
                    </h2>

                </div>

                <div class="rounded-xl bg-blue-500/10 p-3 flex-shrink-0">

                    <i data-lucide="wallet" class="h-6 w-6 md:h-7 md:w-7 text-blue-500"></i>

                </div>

            </div>


        </a>


        <!-- Card: Orders -->
        <a href="{{ route('orders') }}"
            class="group rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 md:p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-green-500/50 active:scale-95 sm:active:scale-100">

            <div class="flex items-center justify-between gap-3">

                <div class="min-w-0">

                    <p class="text-xs md:text-sm text-zinc-500 truncate">
                        Orders
                    </p>

                    <h2 class="mt-2 md:mt-3 text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">
                        {{ $orders }}
                    </h2>

                </div>

                <div class="rounded-xl bg-green-500/10 p-3 flex-shrink-0">

                    <i data-lucide="shopping-cart" class="h-6 w-6 md:h-7 md:w-7 text-green-500"></i>

                </div>

            </div>

        </a>

        <!-- Card: Products -->
        <a href="{{ route('products') }}"
            class="group rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 md:p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-orange-500/50 active:scale-95 sm:active:scale-100">

            <div class="flex items-center justify-between gap-3">

                <div class="min-w-0">

                    <p class="text-xs md:text-sm text-zinc-500 truncate">
                        Products
                    </p>

                    <h2 class="mt-2 md:mt-3 text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">
                        {{ $products }}
                    </h2>

                </div>

                <div class="rounded-xl bg-orange-500/10 p-3 flex-shrink-0">

                    <i data-lucide="package" class="h-6 w-6 md:h-7 md:w-7 text-orange-500"></i>

                </div>

            </div>

        </a>

        <!-- Card: Customers -->
        <a href="{{ route('customers') }}"
            class="group rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 md:p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-pink-500/50 active:scale-95 sm:active:scale-100">

            <div class="flex items-center justify-between gap-3">

                <div class="min-w-0">

                    <p class="text-xs md:text-sm text-zinc-500 truncate">
                        Customers
                    </p>

                    <h2 class="mt-2 md:mt-3 text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">
                        {{ $customers }}
                    </h2>

                </div>

                <div class="rounded-xl bg-pink-500/10 p-3 flex-shrink-0">

                    <i data-lucide="users" class="h-6 w-6 md:h-7 md:w-7 text-pink-500"></i>

                </div>

            </div>

        </a>

    </div>



    <div class="mt-8 grid gap-4 sm:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">

        <!-- Growth -->

        <div
            class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 md:p-7 shadow-sm hover:shadow-md transition-shadow duration-200">

            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0 flex-1">

                    <p class="text-sm text-zinc-500">

                        Monthly Growth

                    </p>

                    <h2 class="mt-2 text-3xl md:text-4xl font-bold text-zinc-900 dark:text-white">

                        +{{ $growth }}%

                    </h2>

                    <span
                        class="mt-3 inline-flex rounded-full bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-600 dark:text-green-400">

                        ↑ Trending Up

                    </span>

                </div>

                <div class="rounded-2xl bg-green-500/10 p-4 flex-shrink-0">

                    <i data-lucide="trending-up" class="h-7 w-7 text-green-500"></i>

                </div>

            </div>

        </div>


        <!-- Top Product -->

        <div
            class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 md:p-7 shadow-sm hover:shadow-md transition-shadow duration-200">

            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0 flex-1">

                    <p class="text-sm text-zinc-500">

                        Top Product

                    </p>

                    <h2 class="mt-2 text-lg md:text-xl font-bold text-zinc-900 dark:text-white line-clamp-2">

                        {{ $topProduct?->product?->name ?? 'No Data' }}

                    </h2>

                    <span class="text-xs text-zinc-500 mt-2 block">

                        Best seller product

                    </span>

                </div>

                <div class="rounded-2xl bg-blue-500/10 p-4 flex-shrink-0">

                    <i data-lucide="package" class="h-7 w-7 text-blue-500"></i>

                </div>

            </div>

        </div>


        <!-- Rating -->

        <div
            class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 md:p-7 shadow-sm hover:shadow-md transition-shadow duration-200">

            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0 flex-1">

                    <p class="text-sm text-zinc-500">

                        Average Rating

                    </p>

                    <h2 class="mt-2 text-3xl md:text-4xl font-bold text-zinc-900 dark:text-white">

                        {{ $averageRating }}

                    </h2>

                    <span class="text-xs text-zinc-500 mt-2 block">

                        From customer reviews

                    </span>

                </div>

                <div class="rounded-2xl bg-yellow-500/10 p-4 flex-shrink-0">

                    <i data-lucide="star" class="h-7 w-7 text-yellow-500"></i>

                </div>

            </div>

        </div>

    </div>



    <!-- Chart + Activity -->
    <div class="mt-8 grid gap-4 sm:gap-6 grid-cols-1 lg:grid-cols-3">

        <!-- Chart -->
        <div
            class="lg:col-span-2 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 md:p-7 shadow-sm hover:shadow-md transition-shadow duration-200">

            <div class="mb-6">

                <h2 class="text-lg md:text-xl font-bold text-zinc-900 dark:text-white">
                    Sales Overview
                </h2>

                <p class="mt-1 text-xs md:text-sm text-zinc-500">
                    Monthly sales statistics
                </p>

            </div>

            <x-chart :chartLabels="$chartLabels" :chartValues="$chartValues" />

        </div>

        <!-- Activity -->
        <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 md:p-7 shadow-sm hover:shadow-md transition-shadow duration-200">

            <h2 class="text-lg md:text-xl font-bold text-zinc-900 dark:text-white">
                Recent Activity
            </h2>

            <div class="mt-6 space-y-4 max-h-80 overflow-y-auto pr-2 custom-scrollbar">

                @foreach ($activities as $activity)
                    <div class="flex gap-3 pb-4 border-b border-zinc-100 dark:border-zinc-800 last:border-b-0 last:pb-0">

                        <div class="mt-1 h-2 w-2 rounded-full bg-blue-500 flex-shrink-0"></div>

                        <div class="min-w-0 flex-1">

                            <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">

                                New order

                            </p>

                            <p class="text-xs text-zinc-500 mt-1">

                                <span class="font-semibold">

                                    {{ $activity->customer?->name }}

                                </span>

                            </p>

                            <span class="text-xs text-zinc-400 mt-1 block">

                                {{ $activity->created_at->diffForHumans() }}

                            </span>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="mt-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 md:p-7 shadow-sm hover:shadow-md transition-shadow duration-200">

        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

            <div>

                <h2 class="text-lg md:text-xl font-bold text-zinc-900 dark:text-white">
                    Recent Orders
                </h2>

                <p class="mt-1 text-xs md:text-sm text-zinc-500">
                    Latest customer orders
                </p>

            </div>

            <a href="{{ route('orders') }}"
                class="w-full sm:w-auto text-center rounded-xl bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600 active:scale-95 shadow-sm hover:shadow-md">
                View All Orders
            </a>

        </div>

        <div class="overflow-x-auto rounded-lg border border-zinc-100 dark:border-zinc-800">

            <table class="w-full">

                <thead>

                    <tr class="border-b border-zinc-200 dark:border-zinc-700 text-left text-xs md:text-sm font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-50 dark:bg-zinc-800/50">

                        <th class="px-4 md:px-6 py-3 md:py-4">Customer</th>
                        <th class="px-4 md:px-6 py-3 md:py-4">Product</th>
                        <th class="px-4 md:px-6 py-3 md:py-4">Amount</th>
                        <th class="px-4 md:px-6 py-3 md:py-4">Status</th>

                    </tr>

                </thead>

                <tbody class="text-sm divide-y divide-zinc-100 dark:divide-zinc-800">

                    @foreach ($recentOrders as $order)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-150">

                            <td class="px-4 md:px-6 py-3 md:py-4 font-medium text-zinc-900 dark:text-white">

                                {{ $order->customer?->name }}

                            </td>

                            <td class="px-4 md:px-6 py-3 md:py-4 text-zinc-600 dark:text-zinc-400 truncate max-w-xs">

                                {{ $order->items->first()?->product?->name }}

                            </td>

                            <td class="px-4 md:px-6 py-3 md:py-4 font-semibold text-zinc-900 dark:text-white">

                                Rp {{ number_format($order->total, 0, ',', '.') }}

                            </td>

                            <td class="px-4 md:px-6 py-3 md:py-4">

                                <span
                                    class="inline-flex rounded-lg px-2.5 py-1.5 text-xs font-semibold

                                            @if ($order->status == 'Completed') bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400
                                            @elseif($order->status == 'Pending')
                                            bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400
                                            @else
                                            bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-400 @endif">

                                    {{ $order->status }}

                                </span>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


</x-layouts.dashboard>
