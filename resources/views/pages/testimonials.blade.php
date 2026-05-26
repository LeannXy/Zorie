<x-layouts.dashboard>

    <div>

        <div class="mb-8">

            <h1 class="text-2xl font-semibold">

                Testimonials

            </h1>

            <p class="text-sm text-zinc-500">

                Manage customer reviews

            </p>
            <div class="mt-6 flex items-center justify-between">

                <div class="relative w-[350px]">

                    <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-500">
                    </i>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search testimonial..."
                        onkeydown="
if(event.key==='Enter'){
window.location='?search='+this.value
}"
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 py-2.5 pl-10 pr-4 text-sm">

                </div>


                <select onchange="
window.location='?status='+this.value"
                    class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-2.5 text-sm">

                    <option value="">

                        All Status

                    </option>

                    <option value="Pending">

                        Pending

                    </option>

                    <option value="Approved">

                        Approved

                    </option>

                    <option value="Hidden">

                        Hidden

                    </option>

                </select>

            </div>

        </div>


        <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden">

            <table class="w-full">

                <thead>

                    <tr class="border-b border-zinc-200 dark:border-zinc-800">

                        <th class="px-6 py-4">

                            Customer

                        </th>

                        <th class="px-6 py-4">

                            Product

                        </th>

                        <th class="px-6 py-4">

                            Rating

                        </th>

                        <th class="px-6 py-4">

                            Comment

                        </th>

                        <th class="px-6 py-4">

                            Status

                        </th>

                        <th class="px-6 py-4">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($testimonials as $testimonial)
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">

                            <td class="px-6 py-5">

                                {{ $testimonial->user->name }}

                            </td>

                            <td class="px-6 py-5">

                                {{ $testimonial->product->name }}

                            </td>

                            <td class="px-6 py-5">

                                <div class="flex">

                                    @for ($i = 1; $i <= 5; $i++)
                                        <i data-lucide="star"
                                            class="h-4 w-4 {{ $i <= $testimonial->rating ? 'fill-yellow-400 text-yellow-400' : 'text-zinc-300' }}">
                                        </i>
                                    @endfor

                                </div>

                            </td>

                            <td class="px-6 py-5">

                                {{ Str::limit($testimonial->comment, 40) }}

                            </td>

                            <td class="px-6 py-5">

                                {{ $testimonial->status }}

                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    <form action="{{ route('testimonials.status', $testimonial->id) }}" method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                            title="{{ $testimonial->status == 'Approved' ? 'Hide' : 'Show' }}"
                                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition">

                                            @if ($testimonial->status == 'Approved')
                                                <i data-lucide="eye-off"></i>
                                            @else
                                                <i data-lucide="eye"></i>
                                            @endif

                                        </button>

                                    </form>


                                    <form action="{{ route('testimonials.delete', $testimonial->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" onclick="return confirm('Delete testimonial?')"
                                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition">

                                            <i data-lucide="trash-2"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-8 text-zinc-500">

                                No testimonials

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-layouts.dashboard>
