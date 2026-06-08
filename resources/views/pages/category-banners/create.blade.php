<x-layouts.dashboard>

<div class="px-4 py-8">

    <h1 class="mb-8 text-3xl font-bold">

        Create Banner

    </h1>

    @include(
        'pages.category-banners._form',
        [
            'action' => route('category-banners.store')
        ]
    )

</div>

</x-layouts.dashboard>