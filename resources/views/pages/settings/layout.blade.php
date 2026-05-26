<div class="flex items-start gap-6 max-md:flex-col">

    <!-- Sidebar -->

    <div class="w-full md:w-[200px]">

        <flux:navlist aria-label="{{ __('Settings') }}">

            <flux:navlist.item
                :href="route('profile.edit')"
                wire:navigate>

                {{ __('Profile') }}

            </flux:navlist.item>

            <flux:navlist.item
                :href="route('security.edit')"
                wire:navigate>

                {{ __('Security') }}

            </flux:navlist.item>

          
        </flux:navlist>

    </div>


    <div class="flex-1">

        <flux:heading class="mb-1">

            {{ $heading ?? '' }}

        </flux:heading>

        <flux:subheading>

            {{ $subheading ?? '' }}

        </flux:subheading>

        <div class="mt-4 w-full">

            {{ $slot }}

        </div>

    </div>

</div>