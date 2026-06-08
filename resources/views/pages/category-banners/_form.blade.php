<form action="{{ $action }}" method="POST" enctype="multipart/form-data">

    @csrf

    @if (isset($method))
        @method($method)
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-[1fr_320px] gap-6">

        <!-- LEFT -->

        <div class="space-y-6">

            <!-- Category -->

            <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 p-6">

                <label class="mb-2 block text-sm font-medium">

                    Category

                </label>

                <select name="category_id"
                    class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 px-4 py-3">

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $banner->category_id ?? '') == $category->id)>

                            {{ $category->name }}

                        </option>
                    @endforeach

                </select>

            </div>

            <!-- Title -->

            <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 p-6">

                <label class="mb-2 block text-sm font-medium">

                    Banner Title

                </label>

                <input type="text" name="title" value="{{ old('title', $banner->title ?? '') }}"
                    class="w-full rounded-xl border px-4 py-3">
                <p class="mt-2 text-xs text-amber-600">

                    Recommended maximum 30 characters to keep the banner layout clean.

                </p>

                @error('title')
                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>
                @enderror

            </div>

            <!-- Subtitle -->

            <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 p-6">

                <label class="mb-2 block text-sm font-medium">

                    Subtitle

                </label>

                <textarea name="subtitle" rows="4" class="w-full rounded-xl border px-4 py-3">{{ old('subtitle', $banner->subtitle ?? '') }}</textarea>
                <p class="mt-2 text-xs text-amber-600">

                    Recommended maximum 80 characters.

                </p>

                @error('subtitle')
                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>
                @enderror

            </div>

        </div>

        <!-- RIGHT -->

        <div class="space-y-6">

            <!-- Button -->

            <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 p-6">

                <label class="mb-2 block text-sm font-medium">

                    Button Text

                </label>

                <input type="text" name="button_text"
                    value="{{ old('button_text', $banner->button_text ?? 'Shop Now') }}"
                    class="w-full rounded-xl border px-4 py-3">
                <p class="mt-2 text-xs text-amber-600">

                    Recommended maximum 15 characters.

                </p>

            </div>

            <div class=" rounded-3xl border border-zinc-200 dark:border-zinc-800 p-6">

                <label class=" mb-2 block text-sm font-medium">

                    Banner Type

                </label>

                <select name="banner_type"
                    class=" w-full rounded-xl border border-zinc-200 dark:border-zinc-700 px-4 py-3">

                    <option value="main" @selected(old('banner_type', $banner->banner_type ?? '') === 'main')>

                        Main Banner

                    </option>

                    <option value="secondary" @selected(old('banner_type', $banner->banner_type ?? 'secondary') === 'secondary')>

                        Secondary Banner

                    </option>

                </select>

                <p class=" mt-2 text-xs text-zinc-500">

                    Main Banner is displayed as the large banner. Secondary Banner is displayed as the smaller banner.

                </p>

                @error('banner_type')
                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>
                @enderror

            </div>

            <!-- Banner Image -->

            <div x-data="{
                preview: '{{ isset($banner) && $banner->image ? asset('storage/' . $banner->image) : '' }}'
            }" class="  rounded-3xl border border-zinc-200 dark:border-zinc-800 p-6">

                <label class=" mb-4 block text-sm font-medium">

                    Banner Image

                </label>

                <label
                    class=" flex h-56 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-zinc-300 dark:border-zinc-700 transition hover:border-blue-500">

                    <div class="text-center">

                        <div class=" mb-4 flex justify-center">

                            <i data-lucide="image-plus" class=" h-12 w-12 text-zinc-400">
                            </i>

                        </div>

                        <h3 class="font-medium">

                            Upload Banner Image

                        </h3>

                        <p class="text-sm text-zinc-500">

                            PNG, JPG, WEBP

                        </p>

                    </div>

                    <input hidden type="file" name="image" accept="image/*"
                        @change=" let file = $event.target.files[0]; if(file){     preview =     URL.createObjectURL(file); }">

                </label>

                <!-- Preview -->
                <div x-show="preview" class="mt-4">

                    <p class="mb-3 text-sm font-medium">

                        Preview

                    </p>

                    <img :src="preview"
                        class=" w-full aspect-[16/9] rounded-2xl object-cover border border-zinc-200 dark:border-zinc-800">
                </div>

            </div>

            <!-- Status -->

            <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 p-6">



                <div>

                    <p class="mb-3 text-sm font-medium">

                        Status

                    </p>

                    <label class="flex items-center gap-3">

                        <input type="checkbox" name="status" value="1" @checked(old('status', $banner->status ?? true))>

                        <span>

                            Active Banner

                        </span>

                    </label>

                </div>

            </div>

        </div>

    </div>

    <div class="mt-8 flex justify-end gap-3">

        <a href="{{ route('category-banners.index') }}" class="rounded-xl border px-6 py-3">

            Cancel

        </a>

        <button type="submit"
            class="inline-flex items-center gap-2 rounded-xl bg-blue-500 px-6 py-3 text-white hover:bg-blue-600 transition">

            <i data-lucide="save" class="h-4 w-4">
            </i>

            Save Banner

        </button>

    </div>

</form>
