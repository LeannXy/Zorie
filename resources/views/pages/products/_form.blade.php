<!-- Product Form -->
<form :action="editMode ? '/products/' + editId : '{{ route('products.store') }}'" method="POST"
    enctype="multipart/form-data" class="space-y-8">

    @csrf

    <template x-if="editMode">
        <input type="hidden" name="_method" value="PUT">
    </template>

    <template x-for="id in form.deletedImages">
        <input type="hidden" name="deleted_images[]" :value="id">
    </template>

    <!-- Basic Information Section -->
    <div class="space-y-6">
        <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Basic Information</h2>
            <p class="mt-1 text-sm text-zinc-500">Product name, category, and pricing details</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Product Name <span
                        class="text-red-500">*</span></label>
                <input x-model="form.name" type="text" name="name" placeholder="e.g., Nike Air Max 270"
                    class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-950 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition"
                    required>
            </div>

            <!-- Category -->
            <!-- Category -->
            <div x-data="{
            
                open: false,
            
                search: '',
            
                categories: @js(
    $categories
        ->map(
            fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
            ],
        )
        ->values(),
),
            
                get filtered() {
            
                    if (!this.search) {
                        return this.categories.filter(
                            c => !form.categories.includes(c.id)
                        );
                    }
            
                    return this.categories.filter(c =>
            
                        c.name.toLowerCase()
                        .includes(
                            this.search.toLowerCase()
                        )
            
                        &&
            
                        !form.categories.includes(c.id)
            
                    );
                },
            
                getName(id) {
            
                    return this.categories.find(
                        c => c.id === id
                    )?.name ?? '';
            
                },
            
                add(id) {
            
                    if (!form.categories.includes(id)) {
            
                        form.categories.push(id);
            
                    }
            
                    this.search = '';
            
                    this.open = true;
            
                },
            
                remove(id) {
            
                    form.categories =
                        form.categories.filter(
                            c => c !== id
                        );
            
                }
            
            }" class="relative">

                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">

                    Category
                    <span class="text-red-500">*</span>

                </label>

                <!-- hidden input -->

                <template x-for="id in form.categories" :key="id">

                    <input type="hidden" name="categories[]" :value="id">

                </template>

                <!-- wrapper -->

                <div @click="open=true" @click.away="open=false"
                    class="min-h-[48px] w-full rounded-xl border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-950 p-2 cursor-text">

                    <!-- selected tags -->

                    <div class="flex flex-wrap gap-2">

                        <template x-for="id in form.categories" :key="id">

                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-500/10 text-blue-600 border border-blue-500/20 text-sm">

                                <span x-text="getName(id)">
                                </span>

                                <button type="button" @click.stop="remove(id)">

                                    ×

                                </button>

                            </div>

                        </template>

                        <!-- input -->

                        <input x-model="search" @focus="open=true"
                            class="flex-1 min-w-[120px] border-0 bg-transparent outline-none text-sm"
                            placeholder="Search categories...">

                    </div>

                </div>

                <!-- dropdown -->

                <div x-show="open" x-transition
                    class="absolute z-50 mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-lg overflow-hidden">

                    <template x-for="category in filtered" :key="category.id">

                        <button type="button" @click="add(category.id)"
                            class="w-full px-4 py-3 text-left hover:bg-zinc-100 dark:hover:bg-zinc-800 text-sm">

                            <span x-text="category.name">
                            </span>

                        </button>

                    </template>

                    <div x-show="filtered.length === 0" class="px-4 py-3 text-sm text-zinc-500">

                        No category found

                    </div>

                </div>

            </div>

            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Price <span
                        class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-zinc-500">Rp</span>
                    <input type="number" name="price" placeholder="0" x-model="form.price"
                        class="w-full pl-10 pr-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-950 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition"
                        required>
                </div>
            </div>

            <!-- Discount -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Discount</label>
                <div class="relative">
                    <input type="number" name="discount" placeholder="0" x-model="form.discount" min="0"
                        max="100"
                        class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-950 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    <span class="absolute right-4 top-2.5 text-zinc-500">%</span>
                </div>
            </div>
        </div>

        <!-- Final Price Display -->
        <div
            class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Final Price</p>
            <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                Rp <span
                    x-text="new Intl.NumberFormat('id-ID').format(
                    (form.price || 0) - ((form.price || 0) * (form.discount || 0) / 100)
                )"></span>
            </h3>
        </div>
    </div>

    <!-- Size Inventory Section -->
    <div class="space-y-6">
        <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Size Inventory</h2>
                    <p class="mt-1 text-sm text-zinc-500">Manage shoe sizes and stock quantities</p>
                </div>
                <button type="button" @click="form.sizes.push({ size: '', stock: 0 })"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium transition">
                    <span>+</span> Add Size
                </button>
            </div>
        </div>

        <div class="space-y-3">
            <template x-for="(item, index) in form.sizes" :key="index">
                <div
                    class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-lg border border-zinc-200 dark:border-zinc-800">
                    <!-- Size Input -->
                    <div class="sm:col-span-4">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Size</label>
                        <input type="text" :name="'sizes[' + index + '][size]'" x-model="item.size"
                            placeholder="e.g., 39, 40, 41"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-950 text-zinc-900 dark:text-white placeholder-zinc-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    </div>

                    <!-- Stock Input -->
                    <div class="sm:col-span-5">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Stock
                            Quantity</label>
                        <input type="number" :name="'sizes[' + index + '][stock]'" x-model.number="item.stock"
                            placeholder="0"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-950 text-zinc-900 dark:text-white placeholder-zinc-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    </div>

                    <!-- Delete Button -->
                    <div class="sm:col-span-3">
                        <button type="button"
                          @click.stop="

if(form.images[index]?.id){

    form.deletedImages.push(
        form.images[index].id
    );

}else{

    form.files.splice(index,1);

}

form.images.splice(index,1);

$refs.imageInput.value='';

"

                            class="w-full px-3 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-600 dark:text-red-400 rounded-lg font-medium transition border border-red-200 dark:border-red-900">
                            Delete
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Total Stock Summary -->
        <div
            class="bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border border-emerald-200 dark:border-emerald-800 rounded-lg p-4">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Total Stock</p>
            <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">
                <span x-text="form.sizes.reduce((total, size) => total + Number(size.stock || 0), 0)"></span> units
            </h3>
        </div>
    </div>

    <!-- Images Section -->
    <div class="space-y-6">
        <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Product Images</h2>
            <p class="mt-1 text-sm text-zinc-500">Upload product photos (JPG, PNG, WebP)</p>
        </div>

        <!-- Upload Area -->
        <div class="border-2 border-dashed border-zinc-300 dark:border-zinc-700 rounded-lg p-8 text-center bg-zinc-50 dark:bg-zinc-950/50 hover:bg-zinc-100 dark:hover:bg-zinc-900/50 transition cursor-pointer"
            @click="$refs.imageInput.click()">
            <input x-ref="imageInput" type="file" name="image[]" multiple accept="image/*"
                @change="Array.from($event.target.files).forEach(file => {
                    form.files.push(file);
                    form.images.push(URL.createObjectURL(file));
                });"
                class="hidden">
            <svg class="mx-auto h-12 w-12 text-zinc-400 mb-2" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Click to upload or drag and drop</p>
            <p class="text-xs text-zinc-500 mt-1">PNG, JPG, WebP up to 10MB</p>
        </div>

        <!-- Image Preview Grid -->
        <div x-show="form.images.length > 0"
            class=" grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <template x-for="(image, index) in form.images" :key="index">
              <div
    class="relative group rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-900 aspect-square">
                    <!-- Image -->
                    <img :src="image.url ?? image"
                        @click="
        selectedImage = image.url ?? image;
        showImagePreview = true;
    "
                        class="aspect-square w-full object-cover cursor-pointer group-hover:opacity-75 transition">
                    <!-- Overlay -->
                    <div
                        class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center">
                        <!-- Delete Button -->
                        <button type="button"
                            @click.stop="if(form.images[index]?.id){ form.deletedImages.push(form.images[index].id); } form.images.splice(index, 1);"
                            class="opacity-0 group-hover:opacity-100 transition relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-red-500 text-white shadow-lg hover:bg-red-600">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Description Section -->
    <div class="space-y-6">
        <div class="border-b border-zinc-200 dark:border-zinc-800 pb-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Description</h2>
            <p class="mt-1 text-sm text-zinc-500">Product details and specifications</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Description <span
                    class="text-red-500">*</span></label>
            <textarea x-model="form.description" name="description" rows="5"
                placeholder="Enter detailed product description..."
                class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-950 text-zinc-900 dark:text-white placeholder-zinc-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition resize-none"
                required></textarea>
            <p class="text-xs text-zinc-500 mt-1">Provide clear and detailed information about the product</p>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex gap-3 pt-6 border-t border-zinc-200 dark:border-zinc-800">
        <a href="{{ route('products') }}"
            class="flex-1 px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-lg font-medium hover:bg-zinc-50 dark:hover:bg-zinc-900 transition text-center">
            Cancel
        </a>
        <button type="submit" :disabled="isSubmitting"
            class="flex-1 px-6 py-3 bg-blue-500 hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-lg font-medium transition flex items-center justify-center gap-2">
            <template x-if="isSubmitting">
                <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
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
