<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new 
#[Layout('layouts.guest')] 
class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4"
                         :status="session('status')" />

  <form wire:submit="login">
    <!-- Email Address -->
    <div>
      <x-input-label for="email"
                     :value="__('Email')" />
      <x-text-input id="email"
                    wire:model="form.email"
                    class="mt-1 block w-full"
                    type="email"
                    name="email"
                    required
                    autofocus
                    autocomplete="username" />
      <x-input-error :messages="$errors->get('form.email')"
                     class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-input-label for="password"
                     :value="__('Password')" />

      <x-text-input id="password"
                    wire:model="form.password"
                    class="mt-1 block w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />

      <x-input-error :messages="$errors->get('form.password')"
                     class="mt-2" />
    </div>

    <!-- Remember Me -->
    <div class="mt-4 block">
      <label for="remember"
             class="inline-flex items-center">
        <input id="remember"
               wire:model="form.remember"
               type="checkbox"
               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
               name="remember">
        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
      </label>
    </div>

    <div class="mt-4 flex items-center justify-end">
      @if (Route::has('password.request'))
        <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
           href="{{ route('password.request') }}"
           wire:navigate>
          {{ __('Forgot your password?') }}
        </a>
      @endif

      <x-primary-button class="ms-3">
        {{ __('Log in') }}
      </x-primary-button>
    </div>
  </form>
</div>
