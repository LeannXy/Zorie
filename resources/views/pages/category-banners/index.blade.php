<x-layouts.dashboard>

    <div class="px-4 py-8">

        <div class="mb-8 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">

            <div>

                <h1 class="text-3xl font-bold">

                    Category Banners

                </h1>

                <p class="mt-2 text-zinc-500">

                    Manage homepage banners

                </p>

            </div>

            <a href="{{ route('category-banners.create') }}"
                class="
            rounded-xl
            bg-blue-500
            px-5
            py-3
            text-center
            text-white
            w-full
            sm:w-auto">

                Add Banner

            </a>

        </div>

        <div
            class="
        overflow-hidden
        rounded-3xl
        border
        border-zinc-200
        dark:border-zinc-800">

            <div class="overflow-x-auto overscroll-x-contain">
            <p class="px-4 py-2 text-xs text-zinc-500 sm:hidden">Geser tabel untuk melihat kolom lainnya.</p>
            <table class="w-full min-w-[640px]">

                <thead>

                    <tr class="border-b">

                        <th class="p-4 text-left">
                            Banner
                        </th>

                        <th class="p-4 text-left">
                            Category
                        </th>

                        <th class="p-4 text-left">
                            Status
                        </th>
                        
                        <th class="p-4 text-left">
                            Type
                        </th>

                        <th class="p-4 text-right">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($banners as $banner)
                        <tr class="border-b">

                            <td class="p-4">

                                <div>

                                    <div class="font-medium">

                                        {{ $banner->title }}

                                    </div>

                                    <div class="text-sm text-zinc-500">

                                        {{ $banner->subtitle }}

                                    </div>

                                </div>

                            </td>

                            <td class="p-4">

                                {{ $banner->category->name }}

                            </td>

                            <td class="p-4">

                                @if ($banner->status)
                                    <span
                                        class="
                                    rounded-full
                                    bg-green-500/10
                                    px-3
                                    py-1
                                    text-xs
                                    text-green-500">

                                        Active

                                    </span>
                                @else
                                    <span
                                        class="
                                    rounded-full
                                    bg-red-500/10
                                    px-3
                                    py-1
                                    text-xs
                                    text-red-500">

                                        Inactive

                                    </span>
                                @endif

                            </td>

                            <td class="p-4">

                                @if ($banner->banner_type === 'main')
                                    <span
                                        class=" rounded-full bg-blue-500/10 px-3 py-1 text-xs text-blue-500">

                                        Main

                                    </span>
                                @else
                                    <span
                                        class="  rounded-full bg-zinc-500/10 px-3 py-1 text-xs text-zinc-500">

                                        Secondary

                                    </span>
                                @endif

                            </td>

                            <td class="p-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('category-banners.edit', $banner) }}"
                                        class=" rounded-lg bg-blue-500/10 p-2 text-blue-500 hover:bg-blue-500/20 transition">

                                        <i data-lucide="pencil" class="h-4 w-4">
                                        </i>

                                    </a>

                                    <form action="{{ route('category-banners.destroy', $banner) }}" method="POST">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            class=" rounded-lg bg-red-500/10 p-2 text-red-500 hover:bg-red-500/20 transition">

                                            <i data-lucide="trash-2" class="h-4 w-4">
                                            </i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4"
                                class="
                            p-10
                            text-center
                            text-zinc-500">

                                No banners yet

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>
            </div>

        </div>

    </div>

</x-layouts.dashboard>
