<x-layouts.dashboard>

    <div class="space-y-8">

        <div>

            <h1 class="text-3xl font-bold">

                System Settings

            </h1>

            <p class="text-zinc-500">

                Configure store information and system preferences

            </p>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition
                    class="mt-4 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-900 dark:bg-green-950 dark:text-green-400">

                    {{ session('success') }}

                </div>
            @endif

        </div>


        <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8">

            <form action="{{ route('settings.system.update') }}" method="POST" class="space-y-6">

                @csrf


                <flux:input name="store_name" label="Store Name"
                    :value="old(
                                                                            'store_name',
                                                                            $settings?->store_name
                                                                            )" />


                <flux:input name="store_email" label="Store Email"
                    :value="old(
                                                                                'store_email',
                                                                                $settings?->store_email
                                                                                )" />


                <flux:input name="store_phone" label="Store Phone"
                    :value="old(
                                                                                'store_phone',
                                                                                $settings?->store_phone
                                                                                )" />


                <div>

                    <label class="mb-2 block">

                        Currency

                    </label>

                    <select name="currency"
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-3">

                        <option value="IDR" {{ $settings?->currency == 'IDR' ? 'selected' : '' }}>

                            Indonesian Rupiah (IDR)

                        </option>

                        <option value="USD" {{ $settings?->currency == 'USD' ? 'selected' : '' }}>

                            US Dollar (USD)

                        </option>

                    </select>

                </div>



                <div>

                    <label class="mb-2 block">

                        Timezone

                    </label>

                    <select name="timezone"
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-3">

                        <option value="Asia/Jakarta" {{ $settings?->timezone == 'Asia/Jakarta' ? 'selected' : '' }}>

                            Asia/Jakarta

                        </option>

                        <option value="Asia/Singapore" {{ $settings?->timezone == 'Asia/Singapore' ? 'selected' : '' }}>

                            Asia/Singapore

                        </option>

                    </select>

                </div>


                <div class="space-y-4">

                    <label class="flex items-center gap-3">

                        <input type="checkbox" name="maintenance_mode" value="1"
                            {{ $settings?->maintenance_mode ? 'checked' : '' }} class="h-5 w-5 rounded">

                        <span>

                            Maintenance Mode

                        </span>

                    </label>



                    <label class="flex items-center gap-3">

                        <input type="checkbox" name="auto_backup" value="1"
                            {{ $settings?->auto_backup ? 'checked' : '' }} class="h-5 w-5 rounded">

                        <span>

                            Automatic Backup

                        </span>

                    </label>

                </div>


                <div class="flex justify-end">

                    <flux:button variant="primary" type="submit">

                        Save Changes

                    </flux:button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.dashboard>
