<x-layouts.dashboard>

    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">

        <div>

            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">
                Dashboard
            </h1>

            <p class="mt-1 text-sm text-zinc-500">
                Welcome back, Admin 👋
            </p>

        </div>

        <a href="{{ route('dashboard.export') }}"
            class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 transition hover:bg-zinc-100 dark:hover:bg-zinc-800">

            Export Report

        </a>

    </div>

    <!-- Stats -->
    <div class="grid gap-5 md:grid-cols-4">
        <a href="{{ route('orders') }}"
            class="group rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-blue-500/40">
            <!-- Card: Total Revenue -->

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Total Revenue
                    </p>

                    <h2 class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">
                        Rp {{ number_format($revenue, 0, ',', '.') }}
                    </h2>

                </div>

                <div class="rounded-xl bg-blue-500/10 p-3 text-blue-500">

                    <i data-lucide="wallet"></i>

                </div>

            </div>


        </a>


        <!-- Card: Orders -->
        <a href="{{ route('orders') }}"
            class="group rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-blue-500/40">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Orders
                    </p>

                    <h2 class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">
                        {{ $orders }}
                    </h2>

                </div>

                <div class="rounded-xl bg-green-500/10 p-3 text-green-500">

                    <i data-lucide="shopping-cart"></i>

                </div>

            </div>

        </a>

        <!-- Card: Products -->
        <a href="{{ route('products') }}"
            class="group rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-blue-500/40">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Products
                    </p>

                    <h2 class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">
                        {{ $products }}
                    </h2>

                </div>

                <div class="rounded-xl bg-orange-500/10 p-3 text-orange-500">

                    <i data-lucide="package"></i>

                </div>

            </div>

        </a>

        <!-- Card: Customers -->
        <a href="{{ route('customers') }}"
            class="group rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-blue-500/40">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Customers
                    </p>

                    <h2 class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">
                        {{ $customers }}
                    </h2>

                </div>

                <div class="rounded-xl bg-pink-500/10 p-3 text-pink-500">

                    <i data-lucide="users"></i>

                </div>

            </div>

        </a>

    </div>



    <div class="mt-6 grid gap-6 lg:grid-cols-3">

        <!-- Growth -->

        <div
            class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm hover:shadow-lg transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">

                        Monthly Growth

                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">

                        +{{ $growth }}%

                    </h2>

                    <span
                        class="mt-2 inline-flex rounded-full bg-green-500/10 px-3 py-1 text-xs font-medium text-green-500">

                        Trending Up

                    </span>

                </div>

                <div class="rounded-2xl bg-green-500/10 p-4">

                    <i data-lucide="trending-up" class="h-7 w-7 text-green-500"></i>

                </div>

            </div>

        </div>


        <!-- Top Product -->

        <div
            class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm hover:shadow-lg transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">

                        Top Product

                    </p>

                    <h2 class="mt-2 text-xl font-bold text-zinc-900 dark:text-white">

                        {{ $topProduct?->product?->name ?? 'No Data' }}

                    </h2>

                    <span class="text-xs text-zinc-500">

                        Best seller product

                    </span>

                </div>

                <div class="rounded-2xl bg-blue-500/10 p-4">

                    <i data-lucide="package" class="h-7 w-7 text-blue-500"></i>

                </div>

            </div>

        </div>


        <!-- Rating -->

        <div
            class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm hover:shadow-lg transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">

                        Average Rating

                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">

                        {{ $averageRating }}

                    </h2>

                    <span class="text-xs text-zinc-500">

                        Customer reviews

                    </span>

                </div>

                <div class="rounded-2xl bg-yellow-500/10 p-4">

                    <i data-lucide="star" class="h-7 w-7 text-yellow-500"></i>

                </div>

            </div>

        </div>

    </div>



    <!-- Chart + Activity -->
    <div class="mt-6 grid gap-6 lg:grid-cols-3">

        <!-- Chart -->
        <div
            class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 lg:col-span-2">

            <div class="mb-6">

                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Sales Overview
                </h2>

                <p class="mt-1 text-sm text-zinc-500">
                    Monthly sales statistics
                </p>

            </div>

            <x-chart :chartLabels="$chartLabels" :chartValues="$chartValues" />

        </div>

        <!-- Activity -->
        <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                Recent Activity
            </h2>

            <div class="mt-6 space-y-6">

                @foreach ($activities as $activity)
                    <div class="flex gap-3">

                        <div class="mt-2 h-2 w-2 rounded-full bg-blue-500 flex-shrink-0"></div>

                        <div>

                            <p class="text-sm text-zinc-300">

                                New order from

                                <span class="font-medium">

                                    {{ $activity->customer?->name }}

                                </span>

                            </p>

                            <span class="text-xs text-zinc-500">

                                {{ $activity->created_at->diffForHumans() }}

                            </span>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="mt-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

        <div class="mb-6 flex items-center justify-between">

            <div>

                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Recent Orders
                </h2>

                <p class="mt-1 text-sm text-zinc-500">
                    Latest customer orders
                </p>

            </div>

            <button
                class="rounded-xl bg-blue-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-600">
                <a href="{{ route('orders') }}">
                    View All
                </a>
            </button>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-left text-sm text-zinc-500">

                        <th class="pb-4 font-medium">Customer</th>
                        <th class="pb-4 font-medium">Product</th>
                        <th class="pb-4 font-medium">Amount</th>
                        <th class="pb-4 font-medium">Status</th>

                    </tr>

                </thead>

                <tbody class="text-sm">

                    @foreach ($recentOrders as $order)
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">

                            <td class="py-4 text-zinc-900 dark:text-white">

                                {{ $order->customer?->name }}

                            </td>

                            <td class="text-zinc-600 dark:text-zinc-400">

                                {{ $order->items->first()?->product?->name }}

                            </td>

                            <td class="text-zinc-600 dark:text-zinc-400">

                                Rp {{ number_format($order->total, 0, ',', '.') }}

                            </td>

                            <td>

                                <span
                                    class="rounded-lg px-3 py-1 text-xs

                                            @if ($order->status == 'Completed') bg-green-500/10 text-green-500
                                            @elseif($order->status == 'Pending')
                                            bg-yellow-500/10 text-yellow-500
                                            @else
                                            bg-orange-500/10 text-orange-500 @endif">

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
