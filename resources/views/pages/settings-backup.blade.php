<x-layouts.dashboard>

    <div class="space-y-8">

        <div>

            <h1 class="text-3xl font-bold">

                Backup & Data

            </h1>

            <p class="text-zinc-500">

                Manage database backup and system data

            </p>

        </div>


        @if (session('success'))
            <div
                class="rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-900 dark:bg-green-950 dark:text-green-400">

                {{ session('success') }}

            </div>
        @endif



        <div class="grid gap-6 md:grid-cols-2">

            <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8">

                <h2 class="text-lg font-semibold">

                    Database Backup

                </h2>

                <p class="mt-2 text-zinc-500">

                    Create a backup of products, users, orders and settings.

                </p>


                <div class="mt-6 flex items-center justify-between">

                    <div>

                        <p class="text-sm text-zinc-500">

                            Last Backup

                        </p>

                        <p class="font-medium">

                            {{ cache('last_backup', 'Never') }}

                        </p>

                    </div>



                    <div class="mt-6 flex gap-3">

                        <form action="{{ route('settings.backup.create') }}" method="POST">

                            @csrf

                            <flux:button variant="primary" type="submit">

                                Create Backup

                            </flux:button>

                        </form>

                    </div>

                </div>

            </div>




            <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8">

                <div class="mt-8">

                    <h3 class="mb-4 text-lg font-semibold">

                        Backup History

                    </h3>


                    <div class="space-y-3">

                        @forelse($backups as $backup)
                            <div
                                class="flex items-center justify-between rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">

                                <div>

                                    <p class="font-medium">

                                        {{ $backup->getFilename() }}

                                    </p>

                                    <p class="text-sm text-zinc-500">

                                        {{ date('d M Y H:i', $backup->getMTime()) }}

                                    </p>

                                </div>


                                <form action="{{ route('settings.backup.restore',$backup->getFilename()) }}"
                                    method="POST">

                                    @csrf

                                    <flux:button variant="primary" type="submit">


                                        Restore

                                    </flux:button>

                                </form>

                            </div>

                        @empty

                            <p class="text-zinc-500">

                                No backups available

                            </p>
                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>

    </div>

</x-layouts.dashboard>
