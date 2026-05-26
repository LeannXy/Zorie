<x-layouts.dashboard>
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
            class="fixed right-5 top-5 z-[100]">

            <div class="flex items-center gap-3 rounded-2xl bg-green-500 px-5 py-4 text-white shadow-2xl">

                <i data-lucide="check-circle" class="h-5 w-5"></i>

                <span>

                    {{ session('success') }}

                </span>

            </div>

        </div>
    @endif

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
            class="fixed right-5 top-5 z-[100]">

            <div class="rounded-2xl bg-red-500 px-5 py-4 text-white shadow-2xl">

                {{ $errors->first() }}

            </div>

        </div>
    @endif

    <div x-data="{
        selectedCategories: [],
    
        showModal: false,
    
        editMode: false,
    
        duplicate: false,
    
        selectedCategories: [],
        deleteModal: false,
        deleteId: null,
        deleteNames: [],
        isBulkDelete: false,
        categories: @js($categories->items()),
    
        form: {
    
            id: '',
            name: '',
            description: '',
            status: true,
            featured: false,
            image: ''
    
        },
    
        showImagePreview: false,
        selectedImage: '',
    
        async bulkUpdate(data) {
    
            await fetch(
                '/categories/bulk-update', {
    
                    method: 'POST',
    
                    headers: {
    
                        'Content-Type': 'application/json',
    
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    
                    },
    
                    body: JSON.stringify({
    
                        ids: this.selectedCategories,
    
                        ...data
    
                    })
    
                }
    
            );
    
            location.reload();
    
        },
    
        async checkCategory() {
    
            if (this.form.name.length < 1) {
    
                this.duplicate = false;
                return;
    
            }
    
            let response = await fetch(
                `/categories/check?name=${this.form.name}&id=${this.form.id}`
            );
    
            let data = await response.json();
    
            this.duplicate = data.exists;
    
        }
    
    }">

        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">

            <div>

                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">

                    Categories

                </h1>

                <p class="mt-1 text-sm text-zinc-500">

                    Manage product categories

                </p>

            </div>

            <button
                @click=" showModal=true; editMode=false; form.id=''; form.name=''; form.description=''; form.status=true; form.featured=false; form.image=''; duplicate=false; "
                class="rounded-xl bg-blue-500 px-4 py-2 text-white">

                + Add Category

            </button>

        </div>

        <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

            <!-- Total -->
            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">

                <div class="flex justify-between">

                    <div>

                        <p class="text-sm text-zinc-500">

                            Total Categories

                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">

                            {{ $totalCategories }}

                        </h2>

                    </div>

                    <div class="rounded-xl bg-blue-500/10 p-3">

                        <i data-lucide="tags" class="h-6 w-6 text-blue-500"></i>

                    </div>

                </div>

            </div>

            <!-- Active -->

            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">

                <div class="flex justify-between">

                    <div>

                        <p class="text-sm text-zinc-500">

                            Active

                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">

                            {{ $activeCategories }}

                        </h2>

                    </div>

                    <div class="rounded-xl bg-green-500/10 p-3">

                        <i data-lucide="circle-check" class="h-6 w-6 text-green-500"></i>

                    </div>

                </div>

            </div>

            <!-- Inactive -->

            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">

                <div class="flex justify-between">

                    <div>

                        <p class="text-sm text-zinc-500">

                            Inactive

                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">

                            {{ $inactiveCategories }}

                        </h2>

                    </div>

                    <div class="rounded-xl bg-red-500/10 p-3">

                        <i data-lucide="circle-x" class="h-6 w-6 text-red-500"></i>

                    </div>

                </div>

            </div>

            <!-- Popular -->

            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">

                <div class="flex justify-between">

                    <div>

                        <p class="text-sm text-zinc-500">

                            Most Used

                        </p>

                        <h2 class="mt-2 text-lg font-bold text-zinc-900 dark:text-white">

                            {{ $popularCategory?->name ?? '-' }}

                        </h2>

                    </div>

                    <div class="rounded-xl bg-yellow-500/10 p-3">

                        <i data-lucide="star" class="h-6 w-6 text-yellow-500"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="mb-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

            <!-- Header -->
            <div class="mb-6">

                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">

                    Category Usage

                </h2>

                <p class="mt-1 text-sm text-zinc-500">

                    Total products by category

                </p>

            </div>

            <div class="relative h-[350px]">

                <canvas id="categoryUsageChart">
                </canvas>

            </div>

        </div>

        <!-- Table -->
        <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">

            <!-- Top -->
            <div class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 p-5">

                <div class="relative w-full max-w-sm">

                    <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-500">
                    </i>

                    <input type="text" value="{{ request('search') }}" placeholder="Search category..."
                        onkeydown="if(event.key==='Enter'){let params=new URLSearchParams(window.location.search);if(this.value){params.set('search',this.value);}else{params.delete('search');}window.location='?'+params.toString();}"
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 py-2.5 pl-10 pr-4 text-sm">

                </div>

                {{-- filter --}}
                <div class="flex gap-3">

                    <select
                        onchange="let params=new URLSearchParams(window.location.search);if(this.value===''){params.delete('status');}else{params.set('status',this.value);}window.location='?'+params.toString();"
                        class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-2.5 text-sm">

                        <option value=""
                            {{ request('status') === '' || request('status') === null ? 'selected' : '' }}>

                            All Status

                        </option>

                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>

                            Active

                        </option>

                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>

                            Inactive

                        </option>

                    </select>

                    <select
                        onchange="let params=new URLSearchParams(window.location.search);

if(this.value===''){

params.delete('featured');

}else{

params.set('featured',this.value);

}

window.location='?'+params.toString();
"
                        class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-2.5 text-sm">

                        <option value=""
                            {{ request('featured') === '' || request('featured') === null ? 'selected' : '' }}>

                            All Featured

                        </option>

                        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>

                            Featured

                        </option>

                        <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>

                            Normal

                        </option>

                    </select>
                     {{-- download file --}}
                        <a href="{{ route('categories.export') }}"
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-500/10 text-green-500 transition hover:bg-green-500 hover:text-white">

                            <i data-lucide="download" class="h-5 w-5">
                            </i>

                        </a>
                </div>

                <div x-show="selectedCategories.length" x-transition
                    class="flex items-center gap-3 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-3">

                    <div class="flex items-center gap-2">

                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-500/10">

                            <i data-lucide="check" class="h-4 w-4 text-blue-500">
                            </i>

                        </div>

                        <span class="text-sm font-medium">

                            <span x-text="selectedCategories.length"></span>

                            selected

                        </span>

                    </div>


                    <div class="ml-auto flex gap-2">

                        <button @click="bulkUpdate({status:true})"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white transition">

                            <i data-lucide="circle-check" class="h-5 w-5">
                            </i>

                        </button>


                        <button @click="bulkUpdate({status:false})"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition">

                            <i data-lucide="circle-x" class="h-5 w-5">
                            </i>

                        </button>


                        <button @click="bulkUpdate({featured:true})"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500 hover:text-white transition">

                            <i data-lucide="sparkles" class="h-5 w-5">
                            </i>

                        </button>


                        <button @click="bulkUpdate({featured:false})"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-500/10 text-zinc-500 hover:bg-zinc-500 hover:text-white transition">

                            <i data-lucide="minus-circle" class="h-5 w-5">
                            </i>

                        </button>


                        <button
                            @click="deleteNames=selectedCategories.map(id=>categories.find(c=>c.id==id)?.name);isBulkDelete=true;deleteModal=true"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition">

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
                                        class="peer h-5 w-5 appearance-none rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 checked:border-blue-500 checked:bg-blue-500"
                                        @click="if($event.target.checked){selectedCategories=@js($categories->pluck('id')->values());}else{selectedCategories=[];}">

                                    <i data-lucide="check"
                                        class="pointer-events-none absolute left-[2px] top-[2px] h-4 w-4 text-white opacity-0 peer-checked:opacity-100"></i>

                                </label>



                            </th>

                            <th class="px-6 py-4">

                                <a href="{{ route(
                                    'categories',
                                
                                    array_merge(
                                        request()->query(),
                                
                                        [
                                            'sort' => 'name',
                                
                                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                                        ],
                                    ),
                                ) }}"
                                    class="flex items-center gap-2 hover:text-blue-500">

                                    Category

                                    <i data-lucide="arrow-up-down" class="h-4 w-4">
                                    </i>

                                </a>

                            </th>

                            <th class="px-6 py-4">

                                <a href="{{ route(
                                    'categories',
                                
                                    array_merge(
                                        request()->query(),
                                
                                        [
                                            'sort' => 'products_count',
                                
                                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                                        ],
                                    ),
                                ) }}"
                                    class="flex items-center gap-2 hover:text-blue-500">

                                    Products

                                    <i data-lucide="arrow-up-down" class="h-4 w-4">
                                    </i>

                                </a>

                            </th>

                            <th class="px-6 py-4 font-medium">
                                Status
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Featured
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="text-sm">

                        @forelse($categories as $category)
                            <tr
                                class="border-b border-zinc-100
                dark:border-zinc-800
                transition
                hover:bg-zinc-50
                dark:hover:bg-zinc-800/30">
                                <td class="px-6 py-5">

                                    <label class="relative flex items-center">

                                        <input :value="{{ $category->id }}" x-model="selectedCategories"
                                            type="checkbox"
                                            class="peer h-5 w-5 appearance-none rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 checked:border-blue-500 checked:bg-blue-500">

                                        <i data-lucide="check"
                                            class="pointer-events-none absolute left-[2px] top-[2px] h-4 w-4 text-white opacity-0 peer-checked:opacity-100"></i>

                                    </label>

                                </td>

                                <!-- Category -->
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="h-12 w-12 overflow-hidden rounded-xl">

                                            <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://placehold.co/80x80?text=No' }}"
                                                class="h-full w-full object-cover">

                                        </div>

                                        <div>

                                            <h2 class="font-medium text-zinc-900 dark:text-white">

                                                {{ $category->name }}

                                            </h2>

                                            <p class="text-xs text-zinc-500">

                                                {{ $category->description }}

                                            </p>

                                        </div>

                                    </div>

                                </td>

                                <!-- Product count -->
                                <td class="px-6 py-5">

                                    {{ $category->products_count }}

                                </td>



                                <!-- Status -->
                                <td class="px-6 py-5">

                                    <form action="{{ route('categories.toggleStatus', $category->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            class="{{ $category->status ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }} rounded-full px-3 py-1 text-xs transition hover:scale-105">

                                            {{ $category->status ? 'Active' : 'Inactive' }}

                                        </button>

                                    </form>

                                </td>

                                <td class="px-6 py-5">

                                    <form action="{{ route('categories.toggleFeatured', $category->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            class="{{ $category->featured ? 'bg-yellow-500/10 text-yellow-500' : 'bg-zinc-500/10 text-zinc-500' }} rounded-full px-3 py-1 text-xs transition hover:scale-105">

                                            <span class="flex items-center gap-1">

                                                <i data-lucide="sparkles" class="h-3.5 w-3.5"></i>

                                                <span>

                                                    {{ $category->featured ? 'Featured' : 'Normal' }}

                                                </span>

                                            </span>

                                        </button>

                                    </form>

                                </td>

                                <!-- Action -->
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-2">

                                        <button
                                            @click=" showModal=true;
                                                     editMode=true;
                                                     form.id='{{ $category->id }}';
                                                     form.name=`{{ $category->name }}`;
                                                     form.description=`{{ $category->description }}`;form.status={{ $category->status ? 'true' : 'false' }};
                                                     form.featured= {{ $category->featured ? 'true' : 'false' }};
                                                     form.image='{{ $category->image ? asset('storage/' . $category->image) : '' }}';"
                                            class="rounded-lg bg-blue-500/10 p-2 text-blue-500">

                                            <i data-lucide="pencil" class="h-4 w-4"></i>



                                        </button>

                                        <button
                                            type="button"@click="deleteId={{ $category->id }};deleteNames=['{{ addslashes($category->name) }}'];isBulkDelete=false;deleteModal=true"
                                            class="rounded-lg bg-red-500/10 p-2 text-red-500">

                                            <i data-lucide="trash-2" class="h-4 w-4">
                                            </i>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="py-10 text-center text-zinc-500">

                                    No categories yet

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

                <div class="border-t border-zinc-200 dark:border-zinc-800 p-5">

                    {{ $categories->links() }}

                </div>

            </div>

        </div>


        <!-- Modal -->

        <div x-show="showModal" x-transition style="display:none"
            class="fixed inset-0 z-50 overflow-y-auto bg-black/70 p-6">

            <div @click.away="showModal=false"
                class="mx-auto my-10 w-full max-w-4xl rounded-3xl bg-white dark:bg-zinc-900 shadow-2xl overflow-hidden"
                bg-white dark:bg-zinc-900 shadow-2xl overflow-hidden">

                <!-- Header -->

                <div
                    class="flex items-start justify-between
    border-b border-zinc-200
    dark:border-zinc-800
    p-6">

                    <div class="flex items-center gap-4">

                        <div
                            class="flex h-14 w-14 items-center justify-center
            rounded-2xl
            bg-blue-500/10">

                            <i data-lucide="tag" class="h-7 w-7 text-blue-500">
                            </i>

                        </div>

                        <div>

                            <h2 class="text-2xl font-semibold
                text-zinc-900 dark:text-white">

                                <span
                                    x-text="
                    editMode
                    ?
                    'Edit Category'
                    :
                    'Add Category'
                    ">
                                </span>

                            </h2>

                            <p class="mt-1 text-sm text-zinc-500">

                                Create or manage
                                product categories

                            </p>

                        </div>

                    </div>

                    <button @click="showModal=false"
                        class="rounded-xl p-2
        text-zinc-500
        hover:bg-zinc-100
        dark:hover:bg-zinc-800">

                        ✕

                    </button>

                </div>


                <form :action="editMode ? '/categories/' + form.id : '{{ route('categories.store') }}'" method="POST"
                    enctype="multipart/form-data" class="p-8">

                    @csrf

                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8">

                        <!-- Left -->
                        <div class="space-y-6">

                            <div>

                                <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">

                                    Category Name

                                </label>

                                <input x-model="form.name" @input.debounce.400ms="checkCategory()" name="name"
                                    placeholder="Enter category name"
                                    class="w-full rounded-2xl border bg-zinc-50 dark:bg-zinc-950 px-4 py-3"
                                    :class="duplicate
                                        ?
                                        'border-red-500' :
                                        'border-zinc-200 dark:border-zinc-800'">

                                <p x-show="duplicate" class="mt-2 text-sm text-red-500">

                                    Category already exists

                                </p>

                            </div>

                            <div>

                                <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">

                                    Description

                                </label>

                                <textarea x-model="form.description" name="description" rows="5" placeholder="Enter category description"
                                    class="w-full resize-none rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-3"></textarea>

                            </div>

                        </div>


                        <!-- Right -->
                        <div class="space-y-6">

                            <!-- Settings -->

                            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5">

                                <h3 class="mb-4 font-medium">

                                    Settings

                                </h3>

                                <div class="space-y-4">

                                    <label class="flex items-center gap-3">

                                        <input x-model="form.status" name="status" type="checkbox"
                                            class="h-5 w-5 accent-blue-500">

                                        <span>

                                            Active

                                        </span>

                                    </label>


                                    <label class="flex items-center gap-3">

                                        <input x-model="form.featured" name="featured" type="checkbox"
                                            class="h-5 w-5 accent-blue-500">

                                        <span class="flex items-center gap-2">

                                            <i data-lucide="sparkles" class="h-4 w-4 text-yellow-500"></i>

                                            Featured

                                        </span>

                                    </label>

                                </div>

                            </div>


                            <!-- Images -->

                            <div class="space-y-5">

                                <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5">

                                    <h3 class="mb-4 text-sm font-medium">

                                        Current Image

                                    </h3>

                                    <template x-if="form.image">

                                        <img :src="form.image"
                                            @click="
                    selectedImage=form.image;
                    showImagePreview=true
                    "
                                            class="h-48 w-full cursor-pointer rounded-2xl object-cover">

                                    </template>

                                    <template x-if="!form.image">

                                        <div
                                            class="flex h-48 items-center justify-center rounded-2xl bg-zinc-100 dark:bg-zinc-800">

                                            <span class="text-sm text-zinc-500">

                                                No image

                                            </span>

                                        </div>

                                    </template>

                                </div>


                                <div class="rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-700 p-5">

                                    <h3 class="mb-4 text-sm font-medium">

                                        Change Image

                                    </h3>

                                    <input x-ref="imageInput" type="file" name="image" accept="image/*"
                                        @change="
                let file=$event.target.files[0];

                if(file){

                    form.image=
                    URL.createObjectURL(file);

                }
                "
                                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 px-4 py-3 text-sm">

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- Footer -->

                    <div
                        class="mt-8 flex items-center justify-between border-t border-zinc-200 dark:border-zinc-800 pt-6">

                        <button type="button" @click="showModal=false"
                            class="rounded-xl border border-zinc-200 dark:border-zinc-800 px-6 py-3 text-sm">

                            Cancel

                        </button>

                        <button :disabled="duplicate"
                            :class="duplicate
                                ?
                                'opacity-50 cursor-not-allowed' :
                                ''"
                            class="rounded-xl bg-blue-500 px-8 py-3 text-sm font-medium text-white hover:bg-blue-600">

                            <span x-text="editMode ? 'Update Category':'Save Category'"></span>

                        </button>

                    </div>

                </form>

            </div>



            <!-- Image Preview -->

            <div x-show="showImagePreview" x-transition style="display:none"
                class="fixed inset-0 z-[70] flex items-center justify-center bg-black/80 p-6">

                <button @click="showImagePreview=false"
                    class="absolute right-6 top-6 flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-xl text-white">

                    ✕

                </button>

                <img :src="selectedImage" class="max-h-[90vh] max-w-[90vw] rounded-3xl object-contain">

            </div>

        </div>


        {{-- delete peringatan --}}
        <div x-show="deleteModal" x-transition style="display:none"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 p-5">

            <div @click.away="deleteModal=false" class="w-full max-w-md rounded-3xl bg-white dark:bg-zinc-900 p-6">

                <div class="flex items-start gap-4">

                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-500/10">

                        <i data-lucide="alert-triangle" class="h-6 w-6 text-red-500">
                        </i>

                    </div>

                    <div>

                        <h3 class="text-lg font-semibold">

                            Delete Confirmation

                        </h3>

                        <p class="mt-1 text-sm text-zinc-500">

                            This action cannot be undone

                        </p>

                    </div>

                </div>

                <div class="mt-4 rounded-2xl bg-zinc-100 dark:bg-zinc-800 p-4">

                    <template x-if="!isBulkDelete">

                        <p>

                            Delete:

                            <b x-text="deleteNames[0]"></b>

                        </p>

                    </template>

                    <template x-if="isBulkDelete">

                        <div>

                            <p>

                                <span x-text="selectedCategories.length"></span>

                                categories selected

                            </p>

                            <div class="mt-2 max-h-28 overflow-y-auto">

                                <template x-for="name in deleteNames">

                                    <div x-text="name" class="py-1">
                                    </div>

                                </template>

                            </div>

                        </div>

                    </template>

                </div>

                <div class="mt-6 flex justify-end gap-3">

                    <div class="mt-8 flex justify-end gap-3">

                        <button @click="deleteModal=false"
                            class="rounded-xl border border-zinc-200 dark:border-zinc-700 px-5 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800">

                            Cancel

                        </button>

                        <template x-if="!isBulkDelete">

                            <form :action="'/categories/' + deleteId" method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="rounded-xl bg-red-500 px-4 py-2 text-white">

                                    Delete

                                </button>

                            </form>

                        </template>

                        <template x-if="isBulkDelete">

                            <button
                                @click=" fetch('/categories/bulk-delete',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({ids:selectedCategories})}).then(()=>location.reload())"
                                class="rounded-xl bg-red-500 px-4 py-2 text-white">

                                Delete All

                            </button>

                        </template>

                    </div>

                </div>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                new Chart(

                    document.getElementById(
                        'categoryUsageChart'
                    ),

                    {

                        type: 'bar',

                        data: {

                            labels: @json($categoryChartLabels),

                            datasets: [{

                                label: 'Products',

                                data: @json($categoryChartData),

                                backgroundColor: '#3b82f6',

                                borderRadius: 0,

                                borderSkipped: false,

                                barThickness: 40

                            }]

                        },

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            plugins: {

                                legend: {

                                    position: 'bottom'

                                }

                            },

                            scales: {

                                x: {

                                    ticks: {

                                        precision: 0,

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

                                        stepSize: 1,

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
</x-layouts.dashboard>
