<?php

use function Livewire\Volt\state;
use App\Models\Product;
use Livewire\WithFileUploads;

state([
    'showModal' => false,
    'name' => '',
    'categories' => [],
    'price' => '',
    'stock' => '',
]);

$save = function () {
    $product = Product::create([
        'name' => $this->name,

        'price' => $this->price,

        'stock' => $this->stock,
    ]);

    $product->categories()->sync($this->categories);

    $this->reset();

    $this->showModal = false;
};

?>

<div>
    <x-layouts.dashboard>

        <div x-data="{
            pageY: 0,
        
            showModal: false,
        
            editMode: false,
        
            editId: null,
        
            showDetail: false,
        
            showImagePreview: false,
        
            selectedImage: '',
        
            activeDetailImage: '',
        
            isSubmitting: false,
        
            selectedProducts: [],
        
            selectedProducts: [],
        
            products: @js($products->items()),
        
            deleteModal: false,
            deleteId: null,
            deleteNames: [],
            isBulkDelete: false,
        
            selectedProduct: {
        
                name: '',
        
                categories: [],
        
                price: '',
        
                discount: '',
        
                stock: '',
        
                description: '',
        
                images: []
        
            },
        
            form: {
        
                name: '',
        
                categories: [],
        
                price: '',
        
                discount: '',
        
                stock: '',
        
                description: '',
        
                images: [],
        
                files: [],
        
                deletedImages: [],
            }
        
        }">

            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">

                <div>

                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">
                        Products
                    </h1>

                    <p class="mt-1 text-sm text-zinc-500">
                        Manage your shoe products
                    </p>

                </div>

                <button
                    @click="
                                                     showModal = true;
                                                     editMode = false;
                                                     editId = null;
                                                     form.name = '';
                                                     form.categories=[];
                                                     if(window.categorySelect){
                                                        categorySelect.clear();
                                                    }
                                                    form.files=[];
                                                     form.price = '';
                                                     form.discount = '';
                                                     form.stock = '';
                                                     form.description = '';
                                                     form.images = [];
                                                     form.deletedImages = [];"
                    class="rounded-xl bg-blue-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-600">

                    + Add Product

                </button>

            </div>
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

                <!-- Total Products -->
                <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-sm text-zinc-500">
                                Total Products
                            </p>

                            <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                                {{ $totalProducts }}
                            </h2>

                        </div>

                        <div class="rounded-xl bg-blue-500/10 p-3">

                            <i data-lucide="package" class="h-6 w-6 text-blue-500">
                            </i>

                        </div>

                    </div>

                </div>

                <!-- Total Stock -->
                <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-sm text-zinc-500">
                                Total Stock
                            </p>

                            <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                                {{ $totalStock }}
                            </h2>

                        </div>

                        <div class="rounded-xl bg-green-500/10 p-3">

                            <i data-lucide="boxes" class="h-6 w-6 text-green-500">
                            </i>

                        </div>

                    </div>

                </div>

                <!-- Out Of Stock -->
                <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-sm text-zinc-500">
                                Out of Stock
                            </p>

                            <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                                {{ $outOfStock }}
                            </h2>

                        </div>

                        <div class="rounded-xl bg-red-500/10 p-3">

                            <i data-lucide="triangle-alert" class="h-6 w-6 text-red-500">
                            </i>

                        </div>

                    </div>

                </div>



                <!-- Inventory Value -->
                <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-sm text-zinc-500">
                                Inventory Value
                            </p>

                            <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                                Rp {{ number_format($totalValue) }}
                            </h2>

                        </div>

                        <div class="rounded-xl bg-yellow-500/10 p-3">

                            <i data-lucide="wallet" class="h-6 w-6 text-yellow-500">
                            </i>

                        </div>

                    </div>

                </div>

            </div>

            <div
                class="mb-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 overflow-hidden">

                <!-- Header -->
                <div class="mb-6">

                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">

                        Products by Category

                    </h2>

                    <p class="mt-1 text-sm text-zinc-500">

                        Total jumlah produk berdasarkan kategori

                    </p>

                </div>

                <div class="relative h-[350px]">

                    <canvas id="categoryChart"></canvas>

                </div>

            </div>

            <!-- Table -->
            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">

                <!-- Top -->
                <div class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 p-5">

                    <div class="flex items-start gap-3">

                        <div x-data="{
                        
                            search: '{{ request('search') }}',
                            results: [],
                        
                            async getProducts() {
                        
                                if (this.search.length < 1) {
                        
                                    this.results = [];
                                    return;
                        
                                }
                        
                                let response = await fetch(
                                    `/products/search?search=${this.search}`
                                );
                        
                                this.results = await response.json();
                        
                            }
                        
                        }" class="relative w-full max-w-sm">

                            <i data-lucide="search"
                                class="absolute left-3 top-1/2 z-10 h-4 w-4 -translate-y-1/2 text-zinc-500">
                            </i>

                            <input x-model="search" @input.debounce.300ms="getProducts()"
                                placeholder="Search product..."
                                class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 py-2.5 pl-10 pr-4 text-sm text-zinc-900 dark:text-white">

                            <!-- Search Result -->
                            <div x-show="results.length"
                                class="absolute z-50 mt-2 w-full overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-xl">

                                <template x-for="product in results" :key="product.id">

                                    <div @click=" 
                                    search = product.name;results = [];
                                    window.location.href='{{ route('products') }}?search=' + product.name;"
                                        class="cursor-pointer border-b border-zinc-100 px-4 py-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-zinc-800">

                                        <p x-text="product.name" class="font-medium text-zinc-900 dark:text-white">
                                        </p>

                                        <p x-text="product.categories
                                        ?.map(c => c.name)
                                        .join(', ')"
                                            class="text-xs text-zinc-500">
                                        </p>
                                    </div>

                                </template>

                            </div>

                        </div>




                        <!-- Reset -->
                        <button @click=" search=''; results=[]; window.location.href='{{ route('products') }}'; "
                            class="rounded-xl border border-zinc-200 dark:border-zinc-800 px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800">

                            Reset

                        </button>

                    </div>


                    {{-- filter --}}
                    <div class="flex items-center gap-3">

                        <select
                            onchange=" window.location='{{ route('products') }}?'+ new URLSearchParams({ search:'{{ request('search') }}', category:this.value, stock:'{{ request('stock') }}'})"
                            class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-2.5 text-sm">

                            <option value="">

                                All Categories

                            </option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>
                            @endforeach

                        </select>


                        {{-- filter --}}
                        <select
                            onchange="window.location='{{ route('products') }}?'+new URLSearchParams({search:'{{ request('search') }}',category:'{{ request('category') }}',stock:this.value})
"
                            class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-2.5 text-sm">

                            <option value="">

                                All Stock

                            </option>

                            <option value="instock" {{ request('stock') == 'instock' ? 'selected' : '' }}>

                                In Stock

                            </option>

                            <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>

                                Low Stock

                            </option>

                            <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>

                                Out of Stock

                            </option>

                        </select>

                        {{-- download file --}}
                        <a href="{{ route('products.export') }}"
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-500/10 text-green-500 transition hover:bg-green-500 hover:text-white">

                            <i data-lucide="download" class="h-5 w-5">
                            </i>

                        </a>

                        <div x-show="selectedProducts.length" x-transition class="flex items-center">

                            <button
                                @click=" deleteNames= selectedProducts.map (id=>products.find(p=>p.id==id)?.name);isBulkDelete=true;deleteModal=true;"
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-500/10 text-red-500 transition hover:bg-red-500 hover:text-white">

                                <i data-lucide="trash-2" class="h-5 w-5">
                                </i>

                            </button>

                        </div>

                    </div>

                </div>

                <!-- Table -->
                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>

                            <tr class="border-b border-zinc-200 dark:border-zinc-800 text-left text-sm text-zinc-500">
                                <th class="px-6 py-4">

                                    <label class="relative flex items-center">

                                        <input type="checkbox"
                                            class="peer h-5 w-5 appearance-none rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 checked:bg-blue-500 checked:border-blue-500"
                                            @click=" if($event.target.checked){ selectedProducts= @js($products->pluck('id')->values());
                                        }else{
                                            selectedProducts=[];
                                            }">

                                        <i data-lucide="check"
                                            class="pointer-events-none absolute left-[2px] top-[2px] h-4 w-4 text-white opacity-0 peer-checked:opacity-100">
                                        </i>

                                    </label>

                                </th>

                                <th class="px-6 py-4 font-medium">

                                    <a href="{{ route(
                                        'products',
                                        array_merge(request()->query(), [
                                            'sort' => 'name',
                                            'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc',
                                        ]),
                                    ) }}"
                                        class="flex items-center gap-2 hover:text-blue-500 transition">

                                        Product

                                        <i data-lucide="arrow-up-down"
                                            class="h-4 w-4 {{ request('sort') === 'name' ? 'text-blue-500' : '' }}">
                                        </i>

                                    </a>

                                </th>
                                <th class="px-6 py-4 font-medium">Category</th>
                                <th class="px-6 py-4 font-medium">

                                    <a href="{{ route(
                                        'products',
                                        array_merge(request()->query(), [
                                            'sort' => 'price',
                                            'direction' => request('sort') === 'price' && request('direction') === 'asc' ? 'desc' : 'asc',
                                        ]),
                                    ) }}"
                                        class="flex items-center gap-2 hover:text-blue-500 transition">

                                        Price

                                        <i data-lucide="arrow-up-down"
                                            class="h-4 w-4 {{ request('sort') === 'price' ? 'text-blue-500' : '' }}"></i>

                                    </a>

                                </th>
                                <th class="px-6 py-4 font-medium">

                                    <a href="{{ route(
                                        'products',
                                        array_merge(request()->query(), [
                                            'sort' => 'stock',
                                            'direction' => request('sort') === 'stock' && request('direction') === 'asc' ? 'desc' : 'asc',
                                        ]),
                                    ) }}"
                                        class="flex items-center gap-2 hover:text-blue-500 transition">

                                        Stock

                                        <i data-lucide="arrow-up-down"
                                            class="h-4 w-4 {{ request('sort') === 'stock' ? 'text-blue-500' : '' }}"></i>

                                    </a>

                                </th>
                                <th class="px-6 py-4 font-medium">Status</th>
                                <th class="px-6 py-4 font-medium">Action</th>

                            </tr>

                        </thead>
                        <tbody class="text-sm">

                            @forelse ($products as $product)
                                <tr
                                    class="border-b border-zinc-100 dark:border-zinc-800 transition hover:bg-zinc-50 dark:hover:bg-zinc-800/30">
                                    <td class="px-6 py-5">

                                        <label class="relative flex items-center">

                                            <input :value="{{ $product->id }}" x-model="selectedProducts"
                                                type="checkbox"
                                                class="peer h-5 w-5 appearance-none rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 checked:bg-blue-500 checked:border-blue-500">

                                            <i data-lucide="check"
                                                class="pointer-events-none absolute left-[2px] top-[2px] h-4 w-4 text-white opacity-0 peer-checked:opacity-100">
                                            </i>

                                        </label>

                                    </td>

                                    {{-- Kolom Product - klik untuk buka Detail --}}
                                    <td class="px-6 py-5 cursor-pointer"
                                        @click="
                                               showDetail = true;
                                               selectedProduct.name = @js($product->name);
                                               selectedProduct.categories =@js($product->categories->pluck('name')->values());
                                               selectedProduct.price = @js($product->price);
                                               selectedProduct.discount = @js($product->discount ?? 0);
                                               selectedProduct.stock = @js($product->stock);
                                               selectedProduct.description = @js($product->description);
                                               selectedProduct.images = @js($product->images->map(fn($i) => asset('storage/' . $i->image))->values());
                                               selectedProduct.activeDetailImage = selectedProduct.images[0] ?? '';
                                               $nextTick(() => {activeDetailImage = selectedProduct.images[0];}); ">


                                        <div class="flex items-center gap-4">

                                            <img src="{{ $product->images->first()
                                                ? asset('storage/' . $product->images->first()->image)
                                                : 'https://placehold.co/100x100/18181b/ffffff?text=No+Image' }}"
                                                class="h-14 w-14 rounded-xl object-cover">

                                            <div>
                                                <h2 class="font-medium text-zinc-900 dark:text-white">
                                                    {{ $product->name }}
                                                </h2>
                                                <div class="mt-1 flex flex-wrap gap-1">

                                                    @foreach ($product->categories as $category)
                                                        <span class="text-xs text-zinc-500">

                                                            {{ $category->name }}

                                                        </span>
                                                    @endforeach

                                                </div>
                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-6 py-5 text-zinc-600 dark:text-zinc-400">
                                        <div class="flex flex-wrap gap-1">

                                            @foreach ($product->categories as $category)
                                                <span
                                                    class="rounded-full bg-blue-500/10 px-2 py-1 text-xs text-blue-500">

                                                    {{ $category->name }}

                                                </span>
                                            @endforeach

                                        </div>
                                    </td>

                                    <td class="px-6 py-5 text-zinc-600 dark:text-zinc-400">
                                        Rp
                                        {{ number_format($product->price - ($product->price * ($product->discount ?? 0)) / 100) }}
                                    </td>

                                    <td class="px-6 py-5 text-zinc-600 dark:text-zinc-400">
                                        {{ $product->stock }}
                                    </td>

                                    <td class="px-6 py-5">
                                        @if ($product->stock > 10)
                                            <span class="bg-green-500/10 text-green-500">
                                                In Stock
                                            </span>
                                        @elseif($product->stock > 0)
                                            <span class="bg-yellow-500/10 text-yellow-500">
                                                Low Stock
                                            </span>
                                        @else
                                            <span class="bg-red-500/10 text-red-500">
                                                Out of Stock
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">

                                            {{-- Tombol Edit --}}
                                            <button
                                                @click.stop="
                                                      showModal = true;
                                                      editMode = true;
                                                      editId = {{ $product->id }};
                                                      form.name = @js($product->name);
                                                      form.categories = @js($product->categories->pluck('id')->values());
                                                      form.price = @js((string) $product->price);
                                                      form.discount = @js((string) ($product->discount ?? 0));
                                                      form.stock = @js((string) $product->stock);
                                                      form.description = @js($product->description);
                                                      form.images = @js($product->images->map(fn($i) => ['id' => $i->id, 'url' => asset('storage/' . $i->image)])->values());
                                                      form.files = [];
                                                      form.deletedImages = [];
                                                      $nextTick(() => { if ($refs.imageInput) $refs.imageInput.value = ''; });
                                                      if(window.categorySelect){categorySelect.clear();categorySelect.setValue(form.categories);}"
                                                class="rounded-lg bg-blue-500/10 p-2 text-blue-500 transition hover:bg-blue-500/20">
                                                <i data-lucide="pencil" class="h-4 w-4"></i>
                                            </button>

                                            {{-- Tombol Delete --}}

                                            <button
                                                type="button"@click="deleteId={{ $product->id }};deleteNames=['{{ addslashes($product->name) }}'];isBulkDelete=false;deleteModal=true"
                                                class="rounded-lg bg-red-500/10 p-2 text-red-500 transition hover:bg-red-500/20">

                                                <i data-lucide="trash-2" class="h-4 w-4">
                                                </i>

                                            </button>


                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-zinc-500">
                                        No products yet
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                    <div class="border-t border-zinc-200 dark:border-zinc-800 p-5">
                        {{ $products->links() }}
                    </div>

                </div>

            </div>

            <!-- Modal -->
            <!-- Modal -->
            <div x-show="showModal" x-transition
                class="fixed inset-0 z-50 flex items-start justify-center bg-black/70 py-6 overflow-y-auto"
                style="display: none;">

                <div @click.away="showModal = false" x-transition
                    class="relative w-full max-w-2xl my-auto rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-2xl">

                    <!-- Header -->
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                                <span x-text="editMode ? 'Edit Product' : 'Add Product'"></span>
                            </h2>
                            <p class="mt-1 text-sm text-zinc-500">
                                <span x-text="editMode ? 'Update existing product' : 'Add new shoe product'"></span>
                            </p>
                        </div>
                        <button @click="showModal = false"
                            class="rounded-lg p-2 text-zinc-500 transition hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white">
                            ✕
                        </button>
                    </div>

                    <form :action="editMode ? '/products/' + editId : '{{ route('products.store') }}'" method="POST"
                        enctype="multipart/form-data" class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        @csrf

                        <template x-if="editMode">

                            <input type="hidden" name="_method" value="PUT">

                        </template>

                        <template x-for="id in form.deletedImages">

                            <input type="hidden" name="deleted_images[]" :value="id">

                        </template>

                        <!-- Name -->
                        <div>
                            <label class="mb-2 block text-sm text-zinc-600 dark:text-zinc-400">Product Name</label>
                            <input x-model="form.name" type="text" name="name"
                                placeholder="Enter product name"
                                class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-3 text-sm text-zinc-900 dark:text-white outline-none placeholder:text-zinc-500 dark:placeholder:text-zinc-600 focus:border-blue-500"
                                required>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="mb-2 block text-sm text-zinc-600 dark:text-zinc-400">Category</label>
                            <select id="categories" multiple name="categories[]"
                                class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800">

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">

                                        {{ $category->name }}

                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="mb-2 block text-sm text-zinc-600 dark:text-zinc-400">Price</label>
                            <input type="number" name="price" placeholder="Enter product price"
                                x-model="form.price"
                                class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-3 text-sm text-zinc-900 dark:text-white outline-none placeholder:text-zinc-500 dark:placeholder:text-zinc-600 focus:border-blue-500"
                                required>
                        </div>

                        <!-- Discount -->
                        <div>
                            <label class="mb-2 block text-sm text-zinc-600 dark:text-zinc-400">Discount (%)</label>
                            <input type="number" name="discount" placeholder="Enter discount percentage"
                                x-model="form.discount" min="0" max="100"
                                class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-3 text-sm text-zinc-900 dark:text-white outline-none placeholder:text-zinc-500 dark:placeholder:text-zinc-600 focus:border-blue-500">
                        </div>

                        <!-- Stock -->
                        <div>
                            <label class="mb-2 block text-sm text-zinc-600 dark:text-zinc-400">Stock</label>
                            <input type="number" name="stock" placeholder="Enter stock quantity"
                                x-model="form.stock"
                                class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-3 text-sm text-zinc-900 dark:text-white outline-none placeholder:text-zinc-500 dark:placeholder:text-zinc-600 focus:border-blue-500"
                                required>
                        </div>

                        <!-- Final Price -->
                        <div class="rounded-xl border border-blue-500/20 bg-blue-500/10 p-4">
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Final Price</p>
                            <h2 class="mt-2 text-2xl font-bold text-blue-500">
                                Rp
                                <span
                                    x-text="new Intl.NumberFormat('id-ID').format(
                        (form.price || 0) - ((form.price || 0) * (form.discount || 0) / 100)
                    )"></span>
                            </h2>
                        </div>

                        <!-- Images -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm text-zinc-600 dark:text-zinc-400">Product Image</label>

                            <!-- Upload Input -->
                            <input x-ref="imageInput" type="file" name="image[]" multiple
                                @change="
                        Array.from($event.target.files).forEach(file => {
                            form.files.push(file);
                            form.images.push(URL.createObjectURL(file));
                        });"
                                class="w-full rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-500/10 file:px-4 file:py-2 file:text-blue-500">

                            <!-- Preview Grid -->
                            <div x-show="form.images.length > 0"
                                class="mt-4 grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-5">
                                <template x-for="(image, index) in form.images" :key="index">
                                    <div class="relative aspect-square">
                                        <img :src="image.url ?? image"
                                            @click="
                                            selectedImage = image;
                                            showImagePreview = true;"
                                            class="h-28 w-28 cursor-pointer rounded-2xl border border-zinc-200 object-cover transition hover:scale-105 dark:border-zinc-800">
                                        <button type="button"
                                            @click="
                                          if(form.images[index]?.id){
                                               form.deletedImages.push(
                                                  form.images[index].id
                                                );
                                            }
                                            form.images.splice(index,1);"
                                            class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs text-white shadow-md transition hover:bg-red-600">
                                            ✕
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm text-zinc-600 dark:text-zinc-400">Product
                                Description</label>
                            <textarea x-model="form.description" name="description" rows="4" placeholder="Enter product description..."
                                class="scrollbar-thin scrollbar-track-transparent scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700 w-full resize-none rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-3 text-sm text-zinc-900 dark:text-zinc-300 outline-none placeholder:text-zinc-500 dark:placeholder:text-zinc-600 focus:border-blue-500"
                                required></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="md:col-span-2">
                            <button type="submit" :disabled="isSubmitting"
                                class="w-full rounded-xl bg-blue-500 py-3 text-sm font-medium text-white transition hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <template x-if="isSubmitting">
                                    <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </template>
                                <span
                                    x-text="editMode ? (isSubmitting ? 'Updating...' : 'Update Product') : (isSubmitting ? 'Saving...' : 'Save Product')"></span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>





            <!-- Product Detail Modal -->
            <div x-show="showDetail" x-transition class="fixed inset-0 z-50 overflow-y-auto bg-black/40 px-4 py-6"
                style="display:none;">

                <div @click.away="showDetail = false"
                    class="relative mx-auto my-10 w-full max-w-5xl rounded-3xl bg-white dark:bg-zinc-900 shadow-2xl overflow-hidden">

                    <!-- Close -->
                    <button @click="showDetail = false"
                        class="absolute right-5 top-5 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-black/60 text-white">

                        ✕

                    </button>

                    <div class="grid md:grid-cols-2">

                        <!-- Images -->
                        <!-- Images -->
                        <div
                            class="rounded-l-3xl bg-gradient-to-b from-zinc-100 to-white dark:from-zinc-800/40 dark:to-zinc-900/40 p-6">

                            <!-- Main Image -->

                            <img :src="activeDetailImage"
                                @click="
                                 selectedImage = activeDetailImage;
                                 showImagePreview=true;"
                                class="h-[350px] w-full cursor-pointer rounded-3xl object-cover">

                            <!-- Thumbnail Scroll -->

                            <div
                                class="mt-5 flex gap-3 overflow-x-auto overflow-y-visible px-2 py-2 scrollbar-thin scrollbar-track-transparent scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700">

                                <template x-for="(image,index) in selectedProduct.images" :key="index">

                                    <img :src="image"
                                        @click="
                                    activeDetailImage=image"
                                        :class="activeDetailImage === image ?
                                            'ring-2 ring-blue-500 scale-100' :
                                            ''"
                                        class="h-20 w-20 flex-shrink-0 cursor-pointer rounded-xl object-cover transition duration-200 hover:opacity-90">

                                </template>

                            </div>

                        </div>

                        <!-- Info -->
                        <div class="p-8">

                            <div class="mb-4">

                                <div class="mb-4 flex flex-wrap gap-2">
                                    <template x-for="category in selectedProduct.categories">
                                        <span
                                            class="rounded-full bg-blue-500/10 px-4 py-1 text-xs font-medium text-blue-500">
                                            <span x-text="category">

                                            </span>
                                        </span>
                                    </template>
                                </div>

                            </div>

                            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">

                                <span x-text="selectedProduct.name"></span>

                            </h1>

                            <!-- Price -->
                            <div class="mt-6">

                                <p class="text-sm text-zinc-500">
                                    Final Price
                                </p>

                                <h2 class="mt-2 text-4xl font-bold text-blue-500">

                                    Rp

                                    <span x-text="new Intl.NumberFormat('id-ID').format(selectedProduct.price)">
                                    </span>

                                </h2>

                            </div>

                            <!-- Stock -->
                            <div class="mt-6 flex items-center gap-3">

                                <span class="rounded-full bg-green-500/10 px-4 py-2 text-sm text-green-500">

                                    Stock:
                                    <span x-text="selectedProduct.stock"></span>

                                </span>

                                <span class="rounded-full bg-red-500/10 px-4 py-2 text-sm text-red-500">

                                    Discount:
                                    <span x-text="selectedProduct.discount"></span>%

                                </span>

                            </div>

                            <!-- Description -->
                            <!-- Description -->
                            <div class="mt-8">

                                <div
                                    class="overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50 backdrop-blur-sm shadow-xl">

                                    <!-- Header -->
                                    <div
                                        class="flex items-center gap-3 border-b border-zinc-200 dark:border-zinc-800 px-6 py-5">

                                        <div
                                            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-500/10">

                                            <i data-lucide="file-text" class="h-5 w-5 text-blue-500"></i>

                                        </div>

                                        <div>

                                            <h3 class="font-semibold text-zinc-900 dark:text-white">

                                                Product Description

                                            </h3>

                                            <p class="text-xs text-zinc-500">

                                                Product details and specifications

                                            </p>

                                        </div>

                                    </div>

                                    <!-- Content -->
                                    <div
                                        class="max-h-[280px]  overflow-y-auto px-8 py-6 scrollbar-thin scrollbar-track-transparent scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700">

                                        <p x-text="selectedProduct.description?.trim()"
                                            class="m-0 whitespace-pre-line leading-8 text-zinc-600 dark:text-zinc-300">
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>


            <!-- Image Preview Modal -->
            <div x-show="showImagePreview" x-transition style="display:none"
                class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 p-5">

                <!-- close -->
                <button @click="showImagePreview=false"
                    class="absolute right-6 top-6 flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-xl text-white">

                    ✕

                </button>

                <img :src="selectedImage" class="max-h-[90vh] max-w-[90vw] rounded-3xl object-contain">
            </div>

            {{-- delete modal --}}
            <div x-show="deleteModal" x-transition style="display:none"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 p-5">

                <div @click.away="deleteModal=false"
                    class="w-full max-w-md rounded-3xl bg-white dark:bg-zinc-900 p-6 shadow-2xl">

                    <div class="flex items-start gap-4">

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-500/10">

                            <i data-lucide="alert-triangle" class="h-6 w-6 text-red-500">
                            </i>

                        </div>

                        <div>

                            <h3 class="font-semibold text-lg">

                                Confirm Delete

                            </h3>

                            <p class="mt-1 text-sm text-zinc-500">

                                This action cannot be undone.

                            </p>

                        </div>

                    </div>


                    <div class="mt-5 rounded-2xl bg-zinc-100 dark:bg-zinc-800 p-4">

                        <template x-if="!isBulkDelete">

                            <div>

                                <p class="text-sm text-zinc-500">

                                    Product to delete:

                                </p>

                                <p x-text="deleteNames[0]" class="mt-2 font-semibold text-red-500">
                                </p>

                            </div>

                        </template>


                        <template x-if="isBulkDelete">

                            <div>

                                <p class="text-sm text-zinc-500">

                                    Products selected:

                                </p>

                                <p class="mt-2 font-semibold text-red-500">

                                    <span x-text="selectedProducts.length">
                                    </span>

                                    products

                                </p>

                                <div class="mt-3 max-h-28 overflow-y-auto text-sm">

                                    <template x-for="name in deleteNames">

                                        <div x-text="name"
                                            class="py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        </div>

                                    </template>

                                </div>

                            </div>

                        </template>

                    </div>


                    <div class="mt-6 flex justify-end gap-3">

                        <button @click="deleteModal=false"
                            class="rounded-xl border border-zinc-200 dark:border-zinc-700 px-5 py-2">

                            Cancel

                        </button>


                        <template x-if="!isBulkDelete">

                            <form :action="'/products/' + deleteId" method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="rounded-xl bg-red-500 px-5 py-2 text-white">

                                    Delete

                                </button>

                            </form>

                        </template>


                        <template x-if="isBulkDelete">

                            <button
                                @click="

fetch(

'{{ route('products.bulkDelete') }}',

{

method:'POST',

headers:{

'Content-Type':'application/json',

'Accept':'application/json',

'X-CSRF-TOKEN':
'{{ csrf_token() }}'

},

body:JSON.stringify({

ids:selectedProducts

})

}

)

.then(()=>window.location.reload())

"
                                class="rounded-xl bg-red-500 px-5 py-2 text-white">

                                Delete All

                            </button>

                        </template>

                    </div>

                </div>

            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                new Chart(
                    document.getElementById('categoryChart'),

                    {
                        type: 'bar',

                        data: {

                            labels: @json($categoryLabels),
                            datasets: [{

                                label: 'Products',

                                data: @json($categoryTotals),

                                backgroundColor: '#3b82f6',

                                borderRadius: 0,

                                borderSkipped: false,

                                barThickness: 40,

                                maxBarThickness: 40

                            }]

                        },

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,
                            options: {

                                responsive: true,

                                maintainAspectRatio: false,

                                layout: {

                                    padding: {

                                        top: 10,
                                        bottom: 10,
                                        left: 10,
                                        right: 10

                                    }

                                }

                            },

                            plugins: {

                                legend: {

                                    position: 'bottom',

                                    labels: {

                                        color: '#a1a1aa',

                                        usePointStyle: true,

                                        pointStyle: 'rectRounded',

                                        padding: 25,

                                        boxWidth: 12

                                    }

                                },

                                title: {

                                    display: false

                                }

                            },

                            scales: {

                                x: {

                                    ticks: {

                                        color: document.documentElement.classList.contains('dark')

                                            ?
                                            '#d4d4d8'

                                            :
                                            '#52525b'

                                    },

                                    grid: {

                                        color: document.documentElement.classList.contains('dark')

                                            ?
                                            'rgba(255,255,255,0.12)'

                                            :
                                            'rgba(0,0,0,0.08)',

                                        drawBorder: false

                                    }

                                },

                                y: {

                                    beginAtZero: true,

                                    grace: '15%',

                                    ticks: {

                                        precision: 0,

                                        color: document.documentElement.classList.contains('dark')

                                            ?
                                            '#d4d4d8' : '#52525b',

                                        callback: function(value) {

                                            return Number.isInteger(value) ?
                                                value :
                                                null;

                                        }

                                    },

                                    grid: {

                                        color: document.documentElement.classList.contains('dark')

                                            ?
                                            'rgba(255,255,255,0.12)' : 'rgba(0,0,0,0.08)',

                                        drawBorder: false

                                    }

                                }

                            }

                        }

                    }


                );
            </script>
            <script>
                // simpan posisi scroll
                window.addEventListener('beforeunload', () => {

                    sessionStorage.setItem(
                        'scrollPosition',
                        window.scrollY
                    );

                });

                // kembalikan posisi scroll
                window.addEventListener('load', () => {

                    let position =
                        sessionStorage.getItem(
                            'scrollPosition'
                        );

                    if (position) {

                        window.scrollTo(
                            0,
                            parseInt(position)
                        );

                    }

                });
            </script>

    </x-layouts.dashboard>
</div>
