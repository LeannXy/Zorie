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

    sizes: [],

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

                <a href="{{ route('products.create') }}" class="rounded-xl bg-blue-500 px-4 py-2 text-sm font-medium text-white">

                    + Add Product

                </a>

            </div>
            <div class="mb-8 grid grid-cols-1 gap-4 sm:gap-5 sm:grid-cols-2 lg:grid-cols-4">

                <!-- Total Products -->
                <div
                    class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 md:p-6">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <p class="text-xs md:text-sm text-zinc-500 truncate">
                                Total Products
                            </p>

                            <h2 class="mt-2 md:mt-3 text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">
                                {{ $totalProducts }}
                            </h2>

                        </div>

                        <div class="rounded-xl bg-blue-500/10 p-3 flex-shrink-0">

                            <i data-lucide="package" class="h-6 w-6 md:h-7 md:w-7 text-blue-500">
                            </i>

                        </div>

                    </div>

                </div>

                <!-- Total Stock -->
                <div
                    class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 md:p-6">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <p class="text-xs md:text-sm text-zinc-500 truncate">
                                Total Stock
                            </p>

                            <h2 class="mt-2 md:mt-3 text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">
                                {{ $totalStock }}
                            </h2>

                        </div>

                        <div class="rounded-xl bg-green-500/10 p-3 flex-shrink-0">

                            <i data-lucide="boxes" class="h-6 w-6 md:h-7 md:w-7 text-green-500">
                            </i>

                        </div>

                    </div>

                </div>

                <!-- Out Of Stock -->
                <div
                    class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 md:p-6">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <p class="text-xs md:text-sm text-zinc-500 truncate">
                                Out of Stock
                            </p>

                            <h2 class="mt-2 md:mt-3 text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">
                                {{ $outOfStock }}
                            </h2>

                        </div>

                        <div class="rounded-xl bg-red-500/10 p-3 flex-shrink-0">

                            <i data-lucide="triangle-alert" class="h-6 w-6 md:h-7 md:w-7 text-red-500">
                            </i>

                        </div>

                    </div>

                </div>



                <!-- Inventory Value -->
                <div
                    class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 md:p-6">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <p class="text-xs md:text-sm text-zinc-500 truncate">
                                Inventory Value
                            </p>

                            <h2
                                class="mt-2 md:mt-3 text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white truncate">
                                Rp {{ number_format($totalValue) }}
                            </h2>

                        </div>

                        <div class="rounded-xl bg-yellow-500/10 p-3 flex-shrink-0">

                            <i data-lucide="wallet" class="h-6 w-6 md:h-7 md:w-7 text-yellow-500">
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
                <div class="border-b border-zinc-200 dark:border-zinc-800">

                    <!-- Scroll Hint Mobile -->
                    <div class="lg:hidden px-5 pt-4 flex items-center gap-2 text-xs text-zinc-500">

                        <i data-lucide="move-right" class="h-4 w-4"></i>

                        <span>Geser untuk melihat filter lainnya</span>

                    </div>

                    <div
                        class="overflow-x-auto scrollbar-thin scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700 scrollbar-track-transparent">

                        <div class="flex items-center justify-between gap-4 p-5 min-w-[900px]">

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

                                                <p x-text="product.name"
                                                    class="font-medium text-zinc-900 dark:text-white">
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
                                <button
                                    @click=" search=''; results=[]; window.location.href='{{ route('products') }}'; "
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
                                               selectedProduct.sizes = @js(
                                                        $product->sizes->map(fn($size)=>[
                                                       'size'=>$size->size,
                                                       'stock'=>$size->stock
                                                      ])->values());
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
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="rounded-lg bg-blue-500/10 p-2 text-blue-500">

                                                <i data-lucide="pencil"></i>

                                            </a>

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
                            <!-- Inventory -->
<div class="mt-6">

    <div
        class="overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50 shadow-xl">

        <!-- Header -->

        <div
            class="flex items-center gap-3 border-b border-zinc-200 dark:border-zinc-800 px-6 py-5">

            <div
                class="flex h-11 w-11 items-center justify-center rounded-2xl bg-green-500/10">

                <i data-lucide="package" class="h-5 w-5 text-green-500"></i>

            </div>

            <div>

                <h3
                    class="font-semibold text-zinc-900 dark:text-white">

                    Inventory

                </h3>

                <p
                    class="text-xs text-zinc-500">

                    Stock by size

                </p>

            </div>

        </div>

        <!-- Total -->

        <div class="px-6 pt-5">

            <div
                class="rounded-2xl bg-blue-500/10 border border-blue-500/20 p-4">

                <p class="text-sm text-zinc-500">

                    Total Stock

                </p>

                <h2
                    class="mt-1 text-3xl font-bold text-blue-500">

                    <span
                        x-text="selectedProduct.stock">
                    </span>

                </h2>

            </div>

        </div>

        <!-- Sizes -->

        <div class="p-6">

            <div class="space-y-3">

                <template
                    x-for="size in selectedProduct.sizes"
                    :key="size.size">

                    <div
                        class="flex items-center justify-between rounded-2xl border border-zinc-200 dark:border-zinc-700 px-4 py-3">

                        <span
                            class="font-medium">

                            Size
                            <span x-text="size.size"></span>

                        </span>

                        <span
                            class="rounded-full bg-green-500/10 px-3 py-1 text-sm text-green-500">

                            <span
                                x-text="size.stock">
                            </span>

                            pcs

                        </span>

                    </div>

                </template>

            </div>

        </div>

    </div>

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
