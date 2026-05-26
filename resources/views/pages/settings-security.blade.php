<x-layouts.dashboard>

<div class="space-y-8">

    <div>

        <h1 class="text-3xl font-bold">

            Security Settings

        </h1>

        <p class="text-zinc-500">

            Manage account password and security preferences

        </p>

    </div>


    <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8">

        <form
            action="{{ route('settings.password') }}"
            method="POST"
            class="space-y-6">

            @csrf

            <flux:input
                type="password"
                name="current_password"
                label="Current Password"
                viewable
            />

            @error('current_password')

            <p class="text-sm text-red-500">

                {{ $message }}

            </p>

            @enderror


            <flux:input
                type="password"
                name="password"
                label="New Password"
                viewable
            />

            @error('password')

            <p class="text-sm text-red-500">

                {{ $message }}

            </p>

            @enderror


            <flux:input
                type="password"
                name="password_confirmation"
                label="Confirm Password"
                viewable
            />


            <div
                class="rounded-2xl bg-zinc-100 dark:bg-zinc-800 p-4">

                <h3 class="font-semibold">

                    Login Activity

                </h3>

                <p class="mt-2 text-sm text-zinc-500">

                    Last login:

                    {{ now()->format('d M Y H:i') }}

                </p>

            </div>


            <div class="flex justify-end">

                <flux:button
                    variant="primary"
                    type="submit">

                    Update Password

                </flux:button>

            </div>

        </form>

    </div>

</div>

</x-layouts.dashboard>