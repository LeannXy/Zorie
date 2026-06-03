<x-layouts.dashboard>

    <div class="max-w-none px-4 py-8">

        <div class="mb-8">

            <a href="{{ route('categories') }}"
                class="inline-flex items-center gap-2 text-blue-500 hover:text-blue-600 transition mb-4">

                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                    </path>
                </svg>

                Back to Categories

            </a>

            <div class="flex items-start justify-between border-b border-zinc-200 dark:border-zinc-800 p-6">

                <div class="flex items-center gap-4">

                    <div class="flex h-14 w-14 items-center justify-center  rounded-2xl bg-blue-500/10">

                        <i data-lucide="tag" class="h-7 w-7 text-blue-500">
                        </i>

                    </div>

                    <div>

                        <h2 class="text-2xl font-semibold text-zinc-900 dark:text-white">

                            Edit Category

                        </h2>

                        <p class="mt-1 text-sm text-zinc-500">

                            Create or manage
                            product categories

                        </p>

                    </div>

                </div>



            </div>

        </div>

        <div x-data="{
        
            editMode: true,
        
            editId: {{ $category->id }},
        
            form: {
        
                id: '{{ $category->id }}',
        
                name: @js($category->name),
        
                description: @js($category->description),
        
                status: {{ $category->status ? 'true' : 'false' }},
        
                featured: {{ $category->featured ? 'true' : 'false' }},
        
                image: @js($category->image ? asset('storage/' . $category->image) : '')
        
            }
        
        }">

            @include('pages.categories._form')

        </div>

    </div>

</x-layouts.dashboard>
