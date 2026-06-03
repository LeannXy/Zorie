<x-layouts.dashboard>

<div class="max-w-none mx-auto px-4 py-8">

    <div class="mb-8">
        <a href="{{ route('products') }}" class="inline-flex items-center gap-2 text-blue-500 hover:text-blue-600 transition mb-4">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Products
        </a>

        <div>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Edit Product</h1>
            <p class="mt-2 text-zinc-600 dark:text-zinc-400">Update shoe product details and information</p>
        </div>
    </div>

    <div x-data="{
        editMode: true,
        editId: {{ $product->id }},
        form: {
            name: @js($product->name),
            categories: @js($product->categories->pluck('id')->toArray()),
            price: {{ $product->price }},
            discount: {{ $product->discount ?? 0 }},
            description: @js($product->description ?? ''),
            stock: {{ $product->stock ?? 0 }},
            images: @js($product->images->map(fn($img) => ['id' => $img->id, 'url' => asset('storage/' . $img->image)])->toArray()),
            files: [],
            deletedImages: [],
            sizes: @js($product->sizes->map(fn($s) => ['size' => $s->size, 'stock' => $s->stock])->toArray())
        },
        isSubmitting: false,
        showImagePreview: false,
        selectedImage: ''
    }">

        @include('pages.products._form')

    </div>

</div>

</x-layouts.dashboard>