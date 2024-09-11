<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new 
#[Layout('layouts.guest')] 
#[Title('Halaman Masuk')] 
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

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: false);
    }
}; ?>

<section class="bg-gray-50 dark:bg-gray-900">
  <div class="mx-auto flex flex-col items-center justify-center px-6 py-8 md:h-screen lg:py-0">
    <a href="#"
       class="mb-6 flex items-center text-2xl font-semibold text-gray-900 dark:text-white">
      <img class="mr-2 h-8 w-8"
           src="{{ asset('pmu.png') }}"
           alt="logo">
      Pindad Medika Utama
    </a>
    <div
         class="w-full rounded-lg bg-white shadow dark:border dark:border-gray-700 dark:bg-gray-800 sm:max-w-md md:mt-0 xl:p-0">
      <div class="space-y-4 p-6 sm:p-8 md:space-y-6">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-2xl text-center">
          Masuk
        </h1>
        <form wire:submit="login" class="space-y-4 md:space-y-6">
          <div>
            <label for="npp"
                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">NPP</label>
            <input id="npp"
                   wire:model="form.npp"
                   type="text"
                   name="npp"
                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                   placeholder="12345">
            <x-input-error :messages="$errors->get('form.npp')"
                           class="mt-2" />
          </div>
          <div>
            <label for="password"
                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Kata Sandi</label>
            <input id="password"
                   wire:model="form.password"
                   type="password"
                   name="password"
                   placeholder="••••••••"
                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
          </div>
          <div class="flex items-center justify-between">
            <div class="flex items-start">
              <div class="flex h-5 items-center">
                <input id="remember"
                       wire:model="form.remember"
                       aria-describedby="remember"
                       type="checkbox"
                       class="focus:ring-3 h-4 w-4 rounded border border-gray-300 bg-gray-50 focus:ring-primary-300 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600">
              </div>
              <div class="ml-3 text-sm">
                <label for="remember"
                       class="text-gray-500 dark:text-gray-300">Ingat saya</label>
              </div>
            </div>
          </div>
          <button type="submit"
                  class="w-full rounded-lg bg-primary-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Masuk</button>
        </form>
      </div>
    </div>
  </div>
</section>

{{-- <div>
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
</div> --}}
