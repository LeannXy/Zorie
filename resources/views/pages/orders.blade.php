<x-layouts.dashboard>

    <div x-data="{
    
        showDetail: false,
    
        selectedOrder: null,
    
        selectedOrders: [],
        showDelete: false,
    
        bulkUpdate(status) {
    
            fetch(
                    '{{ route('orders.bulkUpdate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: this.selectedOrders,
                            status: status
                        })
                    }
                )
                .then(() => location.reload())
    
        },
    
        bulkDelete() {
    
            fetch(
                    '{{ route('orders.bulkDelete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: this.selectedOrders
                        })
                    }
                )
                .then(() => location.reload())
    
        }
    
    }">

        <!-- Header -->

        <div class=" mb-8 flex items-center justify-between">

            <div>

                <h1 class="text-2xl font-semibold">

                    Orders

                </h1>

                <p class="text-sm text-zinc-500">

                    Manage customer orders

                </p>

            </div>

            <div class="flex gap-3">

                <a href="{{ route('orders.export') }}"
                    class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 transition hover:bg-zinc-100 dark:hover:bg-zinc-800">

                    Download Report

                </a>

            </div>

        </div>



        <!-- Stats Cards -->
        <div class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-zinc-500">Total Orders</p>
                        <h2 class="mt-2 text-3xl font-bold">{{ $totalOrders }}</h2>
                    </div>
                    <div class="rounded-xl bg-blue-500/10 p-3">
                        <i data-lucide="shopping-bag" class="h-6 w-6 text-blue-500"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-zinc-500">Pending</p>
                        <h2 class="mt-2 text-3xl font-bold text-yellow-500">{{ $pendingOrders }}</h2>
                    </div>
                    <div class="rounded-xl bg-yellow-500/10 p-3">
                        <i data-lucide="clock-3" class="h-6 w-6 text-yellow-500"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-zinc-500">Completed</p>
                        <h2 class="mt-2 text-3xl font-bold text-green-500">{{ $completedOrders }}</h2>
                    </div>
                    <div class="rounded-xl bg-green-500/10 p-3">
                        <i data-lucide="circle-check" class="h-6 w-6 text-green-500"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-zinc-500">Revenue</p>
                        <h2 class="mt-2 text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                    </div>
                    <div class="rounded-xl bg-emerald-500/10 p-3">
                        <i data-lucide="wallet" class="h-6 w-6 text-emerald-500"></i>
                    </div>
                </div>
            </div>
        </div>


        <!-- Table Card -->
        <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden">
            <!-- Filter Section -->
            <div
                class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 p-5 flex-col md:flex-row gap-4">
                <form method="GET" class="flex gap-3 w-full">
                    <div class="relative w-full md:w-[450px]">
                        <i data-lucide="search"
                            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-500"></i>
                        <input name="search" value="{{ request('search') }}" type="text"
                            placeholder="Search order..."
                            class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 py-2.5 pl-10 pr-4 text-sm">
                    </div>
                    <a href="{{ route('orders') }}"
                        class="rounded-xl bg-zinc-700 px-4 py-2 text-white hover:bg-zinc-600">

                        Reset

                    </a>
                    <select name="status" onchange="this.form.submit()"
                        class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-2.5 text-sm">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing
                        </option>
                        <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>


                </form>
                <div x-show="selectedOrders.length>0" x-transition style="display:none"
                    class="mt-4 flex flex-wrap items-center gap-3 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 p-3">

                    <div class="flex items-center gap-2">

                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-500/10">

                            <i data-lucide="check" class="h-4 w-4 text-blue-500">
                            </i>

                        </div>

                        <span class="text-sm font-medium">

                            <span x-text="selectedOrders.length"></span>

                            selected

                        </span>

                    </div>


                    <div class="ml-auto flex items-center gap-2">

                        <button type="button" @click="bulkUpdate('Pending')"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500 hover:text-white">

                            <i data-lucide="clock-3"></i>

                        </button>

                        <button type="button" @click="bulkUpdate('Processing')"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500/10 text-orange-500 hover:bg-orange-500 hover:text-white">

                            <i data-lucide="package"></i>

                        </button>

                        <button type="button" @click="bulkUpdate('Shipped')"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white">

                            <i data-lucide="truck"></i>

                        </button>

                        <button type="button" @click="bulkUpdate('Completed')"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white">

                            <i data-lucide="circle-check"></i>

                        </button>

                        <button type="button" @click="showDelete=true"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white">

                            <i data-lucide="trash-2"></i>

                        </button>

                    </div>

                </div>
            </div>


            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr
                            class="border-b border-zinc-200 dark:border-zinc-800 text-left text-sm text-zinc-500 bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-6 py-4 w-12">
                                <label class="relative flex items-center cursor-pointer">
                                    <input type="checkbox"
                                        class="peer h-5 w-5 appearance-none rounded-md border border-zinc-300 dark:border-zinc-600 checked:bg-blue-500"
                                        @click="if($event.target.checked){selectedOrders=@js($orders->pluck('id')->values());}else{selectedOrders=[];}">
                                    <i data-lucide="check"
                                        class="pointer-events-none absolute left-[2px] top-[2px] h-4 w-4 text-white opacity-0 peer-checked:opacity-100"></i>
                                </label>
                            </th>
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Products</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm">
                        @forelse($orders as $order)
                            <tr
                                class="border-b border-zinc-100 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                                <td class="px-6 py-5">
                                    <label class="relative flex items-center cursor-pointer">
                                        <input value="{{ $order->id }}" x-model="selectedOrders" type="checkbox"
                                            class="peer h-5 w-5 appearance-none rounded-md border border-zinc-300 dark:border-zinc-600 checked:bg-blue-500">
                                        <i data-lucide="check"
                                            class="pointer-events-none absolute left-[2px] top-[2px] h-4 w-4 text-white opacity-0 peer-checked:opacity-100"></i>
                                    </label>
                                </td>
                                <td class="px-6 py-5 font-medium">#{{ $order->order_number }}</td>
                                <td class="px-6 py-5">{{ $order->customer?->name ?? 'Unknown Customer' }}</td>
                                <td class="px-6 py-5">

                                    <div class="space-y-1">

                                        <p class="text-sm font-medium">

                                            {{ $order->items->sum('quantity') }} items

                                        </p>

                                        <p class="text-xs text-zinc-500">

                                            @foreach ($order->items as $item)
                                                {{ $item->product?->name }}

                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach

                                        </p>

                                    </div>

                                </td>
                                <td class="px-6 py-5">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-5">{{ $order->payment_method }}</td>

                                <!-- Status Dropdown -->
                                <td class="px-6 py-5">
                                    <form action="{{ route('orders.status', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="rounded-full border px-3 py-1 text-xs font-medium focus:ring-0

{{ $order->status == 'Pending'
    ? 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20'
    : ($order->status == 'Paid'
        ? 'bg-cyan-500/10 text-cyan-500 border-cyan-500/20'
        : ($order->status == 'Processing'
            ? 'bg-orange-500/10 text-orange-500 border-orange-500/20'
            : ($order->status == 'Shipped'
                ? 'bg-blue-500/10 text-blue-500 border-blue-500/20'
                : ($order->status == 'Completed'
                    ? 'bg-green-500/10 text-green-500 border-green-500/20'
                    : 'bg-red-500/10 text-red-500 border-red-500/20')))) }}

">
                                            <option value="Pending"
                                                {{ $order->status == 'Pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>

                                            <option value="Paid" {{ $order->status == 'Paid' ? 'selected' : '' }}>
                                                Paid
                                            </option>

                                            <option value="Processing"
                                                {{ $order->status == 'Processing' ? 'selected' : '' }}>
                                                Processing
                                            </option>

                                            <option value="Shipped"
                                                {{ $order->status == 'Shipped' ? 'selected' : '' }}>
                                                Shipped
                                            </option>

                                            <option value="Completed"
                                                {{ $order->status == 'Completed' ? 'selected' : '' }}>
                                                Completed
                                            </option>

                                            <option value="Cancelled"
                                                {{ $order->status == 'Cancelled' ? 'selected' : '' }}>
                                                Cancelled
                                            </option>
                                        </select>
                                    </form>
                                </td>

                                <td class="px-6 py-5">{{ $order->created_at->format('d M Y') }}</td>

                                <!-- Action Buttons -->
                                <td class="px-6 py-5">
                                    <button type="button"
                                        @click="selectedOrder = {{ Js::from([
                                            'id' => $order->order_number,
                                            'customer' => $order->customer?->name ?? 'Unknown Customer',
                                            'payment' => $order->payment_method,
                                            'status' => $order->status,
                                            'total' => number_format($order->total, 0, ',', '.'),
                                            'items' => $order->items->map(
                                                    fn($i) => [
                                                        'name' => $i->product->name,
                                                        'qty' => $i->quantity,
                                                        'price' => number_format($i->price, 0, ',', '.'),
                                                    ],
                                                )->values(),
                                        ]) }}; showDetail = true"
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-5 text-center text-zinc-500">
                                    No orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="border-t border-zinc-200 dark:border-zinc-800 p-5">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>



        <!-- Order Detail Modal -->

        <div x-show="showDetail" x-transition style="display:none"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 p-5">

            <div @click.away="showDetail=false"
                class="w-full max-w-2xl rounded-3xl bg-white dark:bg-zinc-900 p-6 shadow-2xl">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-xl font-semibold">

                            Order Details

                        </h2>

                        <p class="text-sm text-zinc-500">

                            Order #

                            <span x-text="selectedOrder?.id"></span>

                        </p>

                    </div>

                    <button @click="showDetail=false" class="rounded-xl p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800">

                        <i data-lucide="x"></i>

                    </button>

                </div>


                <div class="mt-6 grid grid-cols-2 gap-5">

                    <div>

                        <p class="text-sm text-zinc-500">

                            Customer

                        </p>

                        <h3 x-text="selectedOrder?.customer"></h3>

                    </div>


                    <div>

                        <p class="text-sm text-zinc-500">

                            Payment

                        </p>

                        <h3 x-text="selectedOrder?.payment"></h3>

                    </div>


                    <div>

                        <p class="text-sm text-zinc-500">

                            Status

                        </p>

                        <h3 x-text="selectedOrder?.status"></h3>

                    </div>


                    <div>

                        <p class="text-sm text-zinc-500">

                            Total

                        </p>

                        <h3>

                            Rp <span x-text="selectedOrder?.total"></span>

                        </h3>

                    </div>

                </div>


                <div class="mt-6 space-y-3">

                    <template x-for="item in selectedOrder?.items">

                        <div class="flex justify-between rounded-xl bg-zinc-100 dark:bg-zinc-800 p-4">

                            <div>

                                <p x-text="item.name"></p>

                                <p class="text-xs text-zinc-500">

                                    Qty:

                                    <span x-text="item.qty"></span>

                                </p>

                            </div>

                            <div>

                                Rp

                                <span x-text="item.price"></span>

                            </div>

                        </div>

                    </template>

                </div>

            </div>

        </div>


        <!-- Delete Modal -->

        <div x-show="showDelete" x-transition style="display:none"
            class="fixed inset-0 z-[200] flex items-center justify-center bg-black/60 p-5">

            <div @click.away="showDelete=false" class="w-full max-w-md rounded-3xl bg-white dark:bg-zinc-900 p-6">

                <h2 class="font-semibold">

                    Delete Orders

                </h2>

                <p class="mt-2 text-sm text-zinc-500">

                    <span x-text="selectedOrders.length"></span>

                    orders will be deleted permanently

                </p>

                <div class="mt-6 flex justify-end gap-3">

                    <button @click="showDelete=false" class="rounded-xl border px-4 py-2">

                        Cancel

                    </button>

                    <button @click="bulkDelete()" class="rounded-xl bg-red-500 px-4 py-2 text-white">

                        Delete

                    </button>

                </div>

            </div>

        </div>


    </div>

</x-layouts.dashboard>
