<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use App\Services\CloudinaryImageStorage;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules;
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $photo;
    public string $cloudinaryPhoto = '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        // Validasi semua sekaligus
        $rules = $this->profileRules($user->id);

        if ($this->photo) {
            $rules['photo'] = 'image|max:2048';
        }

        $validated = $this->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($this->cloudinaryPhoto !== '') {
            $previousPhoto = $user->profile_photo;
            $user->profile_photo = app(CloudinaryImageStorage::class)
                ->acceptDirectReference($this->cloudinaryPhoto, 'profiles', 'cloudinaryPhoto');
            $this->cloudinaryPhoto = '';
        } elseif ($this->photo) {
            $previousPhoto = $user->profile_photo;
            $user->profile_photo = app(CloudinaryImageStorage::class)
                ->store($this->photo, 'profiles', 'photo');
            $this->photo = null; // Reset setelah upload
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if (isset($previousPhoto)) {
            app(CloudinaryImageStorage::class)->delete($previousPhoto);
        }

        Flux::toast(variant: 'success', text: 'Profile updated successfully.');
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: 'Verification email sent.');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && !Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return true;
    }
}; ?>

<section class="w-full">

    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Profile Settings')" :subheading="__('Manage your account information')">

        <div class="space-y-6">

            <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">

                <div class="flex items-center gap-5">

                    {{-- Container foto dengan ukuran fixed --}}
                    <div class="relative h-20 w-20 flex-shrink-0 overflow-hidden rounded-full">

                        @if($photo)
                            <img
                                src="{{ $photo->temporaryUrl() }}"
                                alt="Preview foto"
                                id="cloudinary-profile-current"
                                class="h-full w-full object-cover">

                        @elseif(auth()->user()->profile_photo)
                            <img
                                src="{{ media_url(auth()->user()->profile_photo) }}"
                                alt="Foto profil"
                                id="cloudinary-profile-current"
                                class="h-full w-full object-cover">

                        @else
                            <div id="cloudinary-profile-current" class="flex h-full w-full items-center justify-center bg-blue-500 text-3xl font-bold text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <img id="cloudinary-profile-preview" alt="Preview foto"
                            class="h-full w-full object-cover" hidden>

                        <label for="photo"
                            class="absolute bottom-0 right-0 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-blue-500 text-white shadow hover:bg-blue-600 transition">
                            ✎
                        </label>

                        @if (config('services.cloudinary.driver') === 'cloudinary')
                            <input id="photo" type="file" accept="image/*" class="hidden"
                                data-cloudinary-upload-url="{{ route('cloudinary.sign.admin') }}"
                                data-cloudinary-directory="profiles"
                                data-cloudinary-reference-target="#cloudinary-profile-reference"
                                data-cloudinary-preview-target="#cloudinary-profile-preview"
                                data-cloudinary-current-target="#cloudinary-profile-current"
                                data-cloudinary-status-target="#cloudinary-profile-status"
                                data-csrf-token="{{ csrf_token() }}">
                            <input id="cloudinary-profile-reference" type="hidden" wire:model="cloudinaryPhoto">
                        @else
                            <input id="photo" type="file" wire:model="photo" accept="image/*" class="hidden">
                        @endif

                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            {{ Auth::user()->name }}
                        </h2>
                        <p class="text-zinc-500">
                            {{ Auth::user()->email }}
                        </p>
                        <div class="mt-2">
                            <span class="rounded-full bg-green-500/10 px-3 py-1 text-xs font-medium text-green-500">
                                Active
                            </span>
                        </div>
                    </div>

                </div>

                {{-- Loading indicator saat upload --}}
                <div id="cloudinary-profile-status" class="mt-3 text-sm text-blue-500"></div>
                <div wire:loading wire:target="photo" class="mt-3 text-sm text-blue-500">
                    Memuat foto...
                </div>

            </div>

            <form wire:submit="updateProfileInformation" class="space-y-6">

                <flux:input wire:model.live="name" :value="$name" :label="__('Full Name')" type="text" required />

                <flux:input wire:model.live="email" :value="$email" :label="__('Email Address')" type="email" required />

                @if ($this->hasUnverifiedEmail)
                    <flux:text class="text-yellow-500">
                        Email address not verified.
                        <flux:link wire:click.prevent="resendVerificationNotification">
                            Resend verification
                        </flux:link>
                    </flux:text>
                @endif

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updateProfileInformation">Save Changes</span>
                        <span wire:loading wire:target="updateProfileInformation">Menyimpan...</span>
                    </flux:button>
                </div>

            </form>

            @if ($this->showDeleteUser)
                <div class="pt-6 border-t border-zinc-200 dark:border-zinc-800">
                    <livewire:pages::settings.delete-user-form />
                </div>
            @endif

        </div>

    </x-pages::settings.layout>

</section>