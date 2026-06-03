<x-layouts.dashboard>

    <div x-data="{
    
        showCustomer: false,
    
        showImage: false,
    
        selectedCustomer: null
    
    }">

        <div class="mb-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">

            <div class="dashboard-header">

                <h1 class="font-jakarta-bold text-3xl md:text-4xl text-zinc-900 dark:text-white">

                    Pelanggan

                </h1>

                <p class="mt-2 text-sm md:text-base text-zinc-600 dark:text-zinc-400">

                    Kelola akun dan data pelanggan Anda

                </p>

            </div>

            <a href="{{ route('customers.export') }}"
                class="btn-secondary w-full sm:w-auto flex items-center justify-center gap-2 whitespace-nowrap">

                <i data-lucide="download" class="h-5 w-5"></i> Unduh Laporan

            </a>

        </div>


        <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-lg">

            <table class="dashboard-table">

                <thead>

                    <tr class="border-b border-zinc-200 dark:border-zinc-800">

                        <th class="px-6 py-4 text-center">

                            Profile

                        </th>

                        <th class="px-6 py-4 text-center">

                            Name

                        </th>

                        <th class="px-6 py-4 text-center">

                            Email

                        </th>

                        <th class="px-6 py-4 text-center">

                            Phone

                        </th>

                        <th class="px-6 py-4 text-center">

                            Orders

                        </th>

                        <th class="px-6 py-4 text-center">

                            Status

                        </th>

                        <th class="px-6 py-4 text-center">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($customers as $customer)
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">

                            <td class="px-6 py-5 justify-center">

                                <img src="{{ $customer->profile_photo
                                    ? asset('storage/' . $customer->profile_photo)
                                    : 'https://ui-avatars.com/api/?name=' . $customer->name }}"
                                    class="h-10 w-10 rounded-full object-cover cursor-pointer hover:scale-110 transition"
                                    @click="selectedCustomer={

name:'{{ $customer->name }}',
email:'{{ $customer->email }}',
phone:'{{ $customer->phone ?? '-' }}',
orders:'{{ $customer->orders_count }}',
status:'{{ $customer->status }}',

photo:'{{ $customer->profile_photo
    ? asset('storage/' . $customer->profile_photo)
    : 'https://ui-avatars.com/api/?name=' . $customer->name }}'

};showCustomer=true">

                            </td>

                            <td class="px-6 py-5" text-center>

                                {{ $customer->name }}

                            </td>

                            <td class="px-6 py-5" text-center>

                                {{ $customer->email }}

                            </td>

                            <td class="px-6 py-5" text-center>

                                {{ $customer->phone ?? '-' }}

                            </td>

                            <td class="px-6 py-5" text-center>

                                {{ $customer->orders_count }} Orders

                            </td>



                            <td class="px-6 py-5 justify-center">

                                <form action="{{ route('customers.status', $customer->id) }}" method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <select name="status" onchange="this.form.submit()"
                                        class="rounded-full border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 px-3 py-1 text-xs">

                                        <option value="Active" {{ $customer->status == 'Active' ? 'selected' : '' }}>

                                            🟢 Active

                                        </option>

                                        <option value="Blocked" {{ $customer->status == 'Blocked' ? 'selected' : '' }}>

                                            🔴 Blocked

                                        </option>

                                    </select>

                                </form>

                            </td>



                            <td class="px-6 py-5">

                                <div class="flex gap-2 justify-center">

                                    <button
                                        @click="selectedCustomer={name:'{{ $customer->name }}',email:'{{ $customer->email }}',phone:'{{ $customer->phone ?? '-' }}',orders:'{{ $customer->orders_count }}',status:'{{ $customer->status }}'};showCustomer=true"
                                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition">

                                        <i data-lucide="eye"></i>

                                    </button>

                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                        onsubmit="return confirm( 'Yakin ingin menghapus customer ini?' )">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition">

                                            <i data-lucide="trash-2"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="py-8 text-center text-zinc-500">

                                No customers found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <div x-show="showCustomer" x-transition style="display:none"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">

            <div @click.outside="showCustomer=false" class="w-full max-w-lg rounded-3xl bg-white p-6 dark:bg-zinc-900">

                <div class="mb-6 flex items-center justify-between">

                    <h2 class="text-xl font-semibold">

                        Customer Detail

                    </h2>

                    <button @click="showCustomer=false">

                        <i data-lucide="x"></i>

                    </button>

                </div>


                <div class="space-y-4">



                    <img :x-src="selectedCustomer?.photo"
                        class="mx-auto h-28 w-28 rounded-full object-cover border-4 border-blue-500 shadow-lg cursor-pointer hover:scale-105 transition"
                        @click="showImage=true">




                    <div>

                        <p class="text-sm text-zinc-500">

                            Name

                        </p>

                        <p x-text="selectedCustomer?.name">
                        </p>

                    </div>


                    <div>

                        <p class="text-sm text-zinc-500">

                            Email

                        </p>

                        <p x-text="selectedCustomer?.email">
                        </p>

                    </div>


                    <div>

                        <p class="text-sm text-zinc-500">

                            Phone

                        </p>

                        <p x-text="selectedCustomer?.phone">
                        </p>

                    </div>


                    <div>

                        <p class="text-sm text-zinc-500">

                            Orders

                        </p>

                        <p x-text="selectedCustomer?.orders">
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <div x-show="showImage" style="display:none"
            class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80" @click.self="showImage=false">

            <img :x-src="selectedCustomer?.photo" class="max-h-[80vh] max-w-[80vw] rounded-3xl shadow-2xl">

        </div>

    </div>

</x-layouts.dashboard>
