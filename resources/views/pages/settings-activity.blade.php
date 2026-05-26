<x-layouts.dashboard>

    <div class="space-y-8">

        <div>

            <h1 class="text-3xl font-bold">

                Activity Logs

            </h1>

            <p class="text-zinc-500">

                View account activity history

            </p>

        </div>


        <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8">

            <div class="space-y-5">

                @forelse($activities as $activity)
                    <div
                        class="flex items-center justify-between rounded-2xl border border-zinc-200 dark:border-zinc-800 p-4">

                        <div class="flex items-center gap-4">

                            <div class="rounded-xl bg-blue-500/10 p-3">

                                <i data-lucide="{{ $activity->icon }}" class="h-5 w-5 text-blue-500">
                                </i>

                            </div>


                            <div>

                                <h3 class="font-medium">

                                    {{ $activity->action }}

                                </h3>

                                <p class="text-sm text-zinc-500">

                                    {{ $activity->user?->name ?? 'Unknown User' }}

                                </p>

                            </div>

                        </div>


                        <p class="text-sm text-zinc-500">

                            {{ $activity->created_at->diffForHumans() }}

                        </p>

                    </div>

                @empty

                    <div class="rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-700 p-8 text-center">

                        <p class="text-zinc-500">

                            No activity logs available

                        </p>

                    </div>
                @endforelse


                @if ($activities->hasPages())
                    <div class="mt-6">

                        {{ $activities->links() }}

                    </div>
                @endif

            </div>

        </div>

    </div>

</x-layouts.dashboard>
