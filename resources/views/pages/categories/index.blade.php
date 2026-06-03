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
        <div class="mb-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">

            <div class="dashboard-header">

                <h1 class="font-jakarta-bold text-3xl md:text-4xl text-zinc-900 dark:text-white">

                    Kelola Kategori

                </h1>

                <p class="mt-2 text-sm md:text-base text-zinc-600 dark:text-zinc-400">

                    Organisir dan atur kategori produk Anda

                </p>

            </div>

            <a href="{{ route('categories.create') }}"
                class="btn-primary w-full sm:w-auto flex items-center justify-center gap-2 whitespace-nowrap">

                <i data-lucide="plus" class="h-5 w-5"></i> Tambah Kategori

            </a>
        </div>

        <div class="dashboard-grid mb-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">

            <!-- Total -->
            <div class="dashboard-card group">

                <div class="flex justify-between gap-3">

                    <div class="min-w-0">

                        <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400 truncate">

                            Total Kategori

                        </p>

                        <h2 class="mt-3 md:mt-4 text-3xl md:text-4xl font-jakarta-bold text-zinc-900 dark:text-white">

                            {{ $totalCategories }}

                        </h2>

                    </div>

                    <div class="stat-icon bg-blue-500/10">

                        <i data-lucide="tags" class="h-6 w-6 md:h-7 md:w-7 text-blue-500"></i>

                    </div>

                </div>

            </div>

            <!-- Active -->

            <div class="dashboard-card group">

                <div class="flex justify-between gap-3">

                    <div class="min-w-0">

                        <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400 truncate">

                            Aktif

                        </p>

                        <h2 class="mt-3 md:mt-4 text-3xl md:text-4xl font-jakarta-bold text-green-600 dark:text-green-400">

                            {{ $activeCategories }}

                        </h2>

                    </div>

                    <div class="stat-icon bg-green-500/10">

                        <i data-lucide="circle-check" class="h-6 w-6 md:h-7 md:w-7 text-green-500"></i>

                    </div>

                </div>

            </div>

            <!-- Inactive -->

            <div class="dashboard-card group">

                <div class="flex justify-between gap-3">

                    <div class="min-w-0">

                        <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400 truncate">

                            Tidak Aktif

                        </p>

                        <h2 class="mt-3 md:mt-4 text-3xl md:text-4xl font-jakarta-bold text-red-600 dark:text-red-400">

                            {{ $inactiveCategories }}

                        </h2>

                    </div>

                    <div class="stat-icon bg-red-500/10">

                        <i data-lucide="circle-x" class="h-6 w-6 md:h-7 md:w-7 text-red-500"></i>

                    </div>

                </div>

            </div>

            <!-- Popular -->

            <div class="dashboard-card group">

                <div class="flex justify-between gap-3">

                    <div class="min-w-0">

                        <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400 truncate">

                            Paling Populer

                        </p>

                        <h2 class="mt-3 md:mt-4 text-lg md:text-xl font-jakarta-bold text-zinc-900 dark:text-white truncate">

                            {{ $popularCategory?->name ?? '-' }}

                        </h2>

                    </div>

                    <div class="stat-icon bg-yellow-500/10">

                        <i data-lucide="star" class="h-6 w-6 md:h-7 md:w-7 text-yellow-500"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="mb-8 dashboard-card">

            <!-- Header -->
            <div class="mb-6">

                <h2 class="font-jakarta-bold text-xl md:text-2xl text-zinc-900 dark:text-white">

                    Penggunaan Kategori

                </h2>

                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">

                    Total produk per kategori

                </p>

            </div>

            <!-- Scroll indicator for mobile -->
            <div class="lg:hidden mb-3 flex items-center gap-2 text-xs text-zinc-500">
                <i data-lucide="move-right" class="h-4 w-4"></i>
                <span>Scroll untuk melihat lebih banyak</span>
            </div>

            <!-- Chart container with horizontal scroll -->
            <div
                class="overflow-x-auto -mx-6 px-6 scrollbar-thin scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700 scrollbar-track-transparent">
                <div class="min-w-full lg:w-full">
                    <div class="relative h-80 sm:h-96" style="min-width: 500px;">
                        <canvas id="categoryUsageChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <!-- Table -->
        <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">

            <!-- Top -->
            <div class="border-b border-zinc-200 dark:border-zinc-800">

                <div class="lg:hidden px-5 pt-4 flex items-center gap-2 text-xs text-zinc-500">

                    <i data-lucide="move-right" class="h-4 w-4"></i>

                    <span>Geser untuk melihat filter lainnya</span>

                </div>

                <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700">

                    <div class="flex items-center justify-between gap-4 p-5 min-w-[900px]">

                        <div class="relative w-full max-w-sm">

                            <i data-lucide="search"
                                class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-500">
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

                    </div>

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

                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="rounded-lg bg-blue-500/10 p-2 text-blue-500">

                                            <i data-lucide="pencil" class="h-4 w-4">
                                            </i>

                                        </a>

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
