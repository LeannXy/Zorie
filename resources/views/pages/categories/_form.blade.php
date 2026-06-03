        <!-- Modal -->

        <div>

            <div>

                <!-- Header -->

               


                <form :action="editMode ? '/categories/' + form.id : '{{ route('categories.store') }}'" method="POST"
                    enctype="multipart/form-data" class="p-8">

                    @csrf

                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="grid grid-cols-1 xl:grid-cols-[1fr_280px] gap-6">

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
                                            class="
    aspect-square
    w-full
    rounded-2xl
    object-cover">

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

                        <a href="{{ route('categories') }}"
                            class="rounded-xl border border-zinc-200 dark:border-zinc-800 px-6 py-3 text-sm">

                            Cancel

                        </a>

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
