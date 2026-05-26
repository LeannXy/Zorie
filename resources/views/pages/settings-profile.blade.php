<x-layouts.dashboard>

    <div class="space-y-8">

        <div>

            <h1 class="text-3xl font-bold">

                Settings

            </h1>

            <p class="text-zinc-500">

                Manage account information

            </p>

        </div>


        <div class="grid gap-6 xl:grid-cols-3">

            <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

                <div class="flex flex-col items-center">

                    <div
                        class="flex h-28 w-28 items-center justify-center overflow-hidden rounded-full border border-zinc-200 dark:border-zinc-700">

                        @if (auth()->user()->profile_photo)
                            <img src="{{ Storage::url(auth()->user()->profile_photo) }}"
                                class="h-full w-full object-cover">
                        @else
                            <div
                                class="flex h-full w-full items-center justify-center bg-blue-500 text-4xl font-bold text-white">

                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                            </div>
                        @endif

                    </div>

                    <h2 class="mt-4 text-xl font-bold text-zinc-900 dark:text-white">

                        {{ auth()->user()->name }}

                    </h2>

                    <p class="text-zinc-500">

                        {{ auth()->user()->email }}

                    </p>

                </div>



            </div>



            <div
                class="xl:col-span-2 rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8">

                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">

                    @csrf


                    <flux:input name="name" label="Full Name" :value="old('name',auth()->user()->name)" required />

                    @error('name')
                        <p class="text-sm text-red-500">

                            {{ $message }}

                        </p>
                    @enderror



                    <flux:input name="email" label="Email Address" :value="old('email',auth()->user()->email)"
                        required />

                    @error('email')
                        <p class="text-sm text-red-500">

                            {{ $message }}

                        </p>
                    @enderror



                    <div>

                        <label class="mb-2 block text-sm font-medium">

                            Profile Photo

                        </label>

                        <input type="file" name="profile_photo" accept="image/*"
                            class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-3">

                        @error('profile_photo')
                            <p class="mt-1 text-sm text-red-500">

                                {{ $message }}

                            </p>
                        @enderror

                    </div>



                    <div class="flex justify-end">

                        <flux:button variant="primary" type="submit">

                            Save Changes

                        </flux:button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-layouts.dashboard>
