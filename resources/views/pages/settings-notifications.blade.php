<x-layouts.dashboard>

    <div class="space-y-8">

        <div>

            <h1 class="text-3xl font-bold">

                Notifications

            </h1>

            <p class="text-zinc-500">

                Manage notification preferences

            </p>

        </div>


        @if (session('success'))
            <div class="rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700">

                {{ session('success') }}

            </div>
        @endif


        <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8">

            <form action="{{ route('settings.notifications.update') }}" method="POST" class="space-y-6">

                @csrf


                <label class="flex items-center gap-3">

                    <input type="checkbox" name="low_stock_notification" value="1"
                        {{ $settings?->low_stock_notification ? 'checked' : '' }}>

                    <span>

                        Low Stock Alert

                    </span>

                </label>



                <label class="flex items-center gap-3">

                    <input type="checkbox" name="backup_notification" value="1"
                        {{ $settings?->backup_notification ? 'checked' : '' }}>

                    <span>

                        Backup Notifications

                    </span>

                </label>



                <label class="flex items-center gap-3">

                    <input type="checkbox" name="email_notification" value="1"
                        {{ $settings?->email_notification ? 'checked' : '' }}>

                    <span>

                        Email Notifications

                    </span>

                </label>

                <label class="flex items-center gap-3">

                    <input type="checkbox" name="new_order_notification" value="1"
                        {{ $settings?->new_order_notification ? 'checked' : '' }}>

                    <span>

                        New Orders

                    </span>

                </label>


                <label class="flex items-center gap-3">

                    <input type="checkbox" name="order_status_notification" value="1"
                        {{ $settings?->order_status_notification ? 'checked' : '' }}>

                    <span>

                        Order Status Updates

                    </span>

                </label>


                <label class="flex items-center gap-3">

                    <input type="checkbox" name="payment_notification" value="1"
                        {{ $settings?->payment_notification ? 'checked' : '' }}>

                    <span>

                        Payment Notifications

                    </span>

                </label>


                <div class="flex justify-end">

                    <flux:button variant="primary" type="submit">

                        Save Changes

                    </flux:button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.dashboard>
