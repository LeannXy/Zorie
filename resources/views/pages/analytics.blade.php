<x-layouts.dashboard>

<div class="space-y-8">

    <!-- Header -->

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">

                Analytics Dashboard

            </h1>

            <p class="text-zinc-500">

                Sales insights and business performance

            </p>

        </div>

    </div>


    <!-- KPI -->

    <div class="grid gap-6 lg:grid-cols-4">

        <!-- Revenue -->

        <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-zinc-500">

                        Revenue

                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">

                        Rp {{ number_format($revenue) }}

                    </h2>

                </div>

                <div class="rounded-2xl bg-green-500/10 p-4">

                    <i data-lucide="wallet"
                    class="h-6 w-6 text-green-500"></i>

                </div>

            </div>

        </div>


        <!-- Orders -->

        <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-zinc-500">

                        Orders

                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">

                        {{ $orders }}

                    </h2>

                </div>

                <div class="rounded-2xl bg-blue-500/10 p-4">

                    <i data-lucide="shopping-cart"
                    class="h-6 w-6 text-blue-500"></i>

                </div>

            </div>

        </div>


        <!-- Customers -->

        <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-zinc-500">

                        Customers

                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">

                        {{ $customers }}

                    </h2>

                </div>

                <div class="rounded-2xl bg-purple-500/10 p-4">

                    <i data-lucide="users"
                    class="h-6 w-6 text-purple-500"></i>

                </div>

            </div>

        </div>


        <!-- Rating -->

        <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

            <div class="flex justify-between">

                <div>

                    <p class="text-zinc-500">

                        Average Rating

                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">

                        {{ $averageRating }}

                    </h2>

                </div>

                <div class="rounded-2xl bg-yellow-500/10 p-4">

                    <i data-lucide="star"
                    class="h-6 w-6 text-yellow-500"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- Chart -->

    <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

        <h2 class="mb-1 text-xl font-semibold text-zinc-900 dark:text-white">

            Sales Performance

        </h2>

        <p class="mb-6 text-zinc-500">

            Revenue trends over time

        </p>

        <div class="relative ">

            <x-chart
            :chartLabels="$chartLabels"
            :chartValues="$chartValues"/>

        </div>

    </div>


    <!-- Bottom -->

    <div class="grid gap-6 lg:grid-cols-2">

        <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

            <h2 class="mb-6 text-xl font-semibold text-zinc-900 dark:text-white">

                Top Products

            </h2>

            @foreach($topProducts as $product)

            <div class="mb-5 flex justify-between">

                <span class="text-zinc-900 dark:text-white">

                    {{ $product->product?->name }}

                </span>

                <span class="text-zinc-500">

                    {{ $product->sold }} sold

                </span>

            </div>

            @endforeach

        </div>



        <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

            <h2 class="mb-6 text-xl font-semibold text-zinc-900 dark:text-white">

                Order Status

            </h2>

            @foreach($statusStats as $status)

            <div class="mb-5">

                <div class="flex justify-between">

                    <span class="text-zinc-900 dark:text-white">

                        {{ $status->status }}

                    </span>

                    <span class="text-zinc-500">

                        {{ $status->total }}

                    </span>

                </div>

                <div class="mt-2 h-2 rounded-full bg-zinc-200 dark:bg-zinc-800">

                    <div
                    class="h-2 rounded-full bg-green-500"

                    style="width:{{ ($status->total/$orders)*100 }}%">

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</div>

</x-layouts.dashboard>