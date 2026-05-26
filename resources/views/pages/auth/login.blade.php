<x-layouts::auth :title="__('Log in')">

<div class="flex flex-col gap-6">

    <div class="text-center mb-4">

        <h1 class="text-4xl font-bold text-blue-500">

            ZORIE

        </h1>

        <p class="mt-3 text-zinc-500">

            Welcome back 👋

        </p>

        <p class="text-sm text-zinc-400">

            Sign in to continue to your dashboard

        </p>

    </div>


    <x-auth-session-status
        class="text-center"
        :status="session('status')" />


    <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-lg">

        <form
            method="POST"
            action="{{ route('login.store') }}"
            class="flex flex-col gap-6">

            @csrf


            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />


            <div class="relative">

                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    viewable
                />

                @if (Route::has('password.request'))

                    <flux:link
                        class="absolute top-0 end-0 text-sm"
                        :href="route('password.request')"
                        wire:navigate>

                        Forgot password?

                    </flux:link>

                @endif

            </div>


            <flux:checkbox
                name="remember"
                :label="__('Remember me')"
                :checked="old('remember')" />


            <flux:button
                variant="primary"
                type="submit"
                class="w-full"
                data-test="login-button">

                Log in

            </flux:button>

        </form>

    </div>


    @if (Route::has('register'))

        <div class="text-center text-sm text-zinc-500">

            Don't have an account?

            <flux:link
                :href="route('register')"
                wire:navigate>

                Sign up

            </flux:link>

        </div>

    @endif

</div>

</x-layouts::auth>