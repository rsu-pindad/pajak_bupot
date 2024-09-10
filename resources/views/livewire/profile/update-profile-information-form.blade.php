<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $npp = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->npp = Auth::user()->npp;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'npp' => ['required', 'string', 'digits:5'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', npp: $user->npp);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME);

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ __('Informasi Profil') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
    </p>
  </header>

  <form wire:submit="updateProfileInformation"
        class="mt-6 space-y-6">
    <div>
      <x-input-label for="npp"
                     :value="__('Npp')" />
      <x-text-input id="npp"
                    wire:model="npp"
                    npp="npp"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="npp" />
      <x-input-error class="mt-2"
                     :messages="$errors->get('npp')" />
    </div>

    <div>
      <x-input-label for="email"
                     :value="__('Email')" />
      <x-text-input id="email"
                    wire:model="email"
                    name="email"
                    type="email"
                    class="mt-1 block w-full"
                    required />
      <x-input-error class="mt-2"
                     :messages="$errors->get('email')" />

      @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
        <div>
          <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
            {{ __('Alamat email Anda belum diverifikasi.') }}

            <button wire:click.prevent="sendVerification"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800">
              {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
            </button>
          </p>

          @if (session('status') === 'verification-link-sent')
            <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
              {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email Anda.') }}
            </p>
          @endif
        </div>
      @endif
    </div>

    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Simpan') }}</x-primary-button>

      <x-action-message class="me-3"
                        on="profile-updated">
        {{ __('Tersimpan.') }}
      </x-action-message>
    </div>
  </form>
</section>
