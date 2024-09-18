<?php

use App\Models\User;
use App\Models\Personalia;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Illuminate\Support\Str;
use WireUi\Traits\WireUiActions;

new 
#[Layout('layouts.guest')] 
#[Title('Halaman Daftar')] 
class extends Component {
    use WireUiActions;
    public string $npp = '';
    // public string $email = '';
    // public string $password = '';
    // public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        $validated = $this->validate([
            'npp' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            // 'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $personalia = Personalia::where('npp', $validated['npp'])->first();
        if (!$personalia) {
          return $this->dispatch('notifikasi', icon: 'error', title: 'NPP', description: 'npp tidak ditemukan!.');
        }
        $cariUser = User::where('npp', $validated['npp'])->first();
        if ($cariUser) {
          return $this->dispatch('notifikasi', icon: 'info', title: 'NPP', description: 'npp sudah terdaftar!.');
        }
        try {
            $randomPassword = Str::random(8);
            $validated['password'] = Hash::make($randomPassword);
            $sendOtp = json_decode($this->sendOtp($personalia, $randomPassword), true);
            $status = $sendOtp['status'];

            if ($status == true) {
                $validated['email'] = $personalia->email;
                event(new Registered(($user = User::create($validated))));
                return $this->dispatch('notifikasi', icon: 'success', title: 'NPP', description: 'Password berhasil dikirim via whatsapp');
            }
        } catch (\Throwable $th) {
            return $this->dispatch('notifikasi', icon: 'error', title: 'NPP', description: 'terjadi kesalahan hubungi admin');
        }
        // return $this->dispatch('notifikasi', icon: 'error', title: 'NPP', description: 'terjadi kesalahan pengiriman');

        // Auth::login($user);

        // $this->redirect(RouteServiceProvider::HOME, navigate: false);
    }

    public function sendOtp($personalia, $password)
    {
        $pesan = PHP_EOL . 'Halo sdr/i berikut password :' . PHP_EOL;
        $pesan .= PHP_EOL . $password . PHP_EOL;
        $pesan .= PHP_EOL . 'gunakan NPP & Password untuk masuk' . PHP_EOL;
        $pesan .= PHP_EOL . 'Terimakasih' . PHP_EOL;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                // 'target'      => $personalia['no_hp'],
                'target' => $personalia->no_hp,
                'message' => $pesan,
                'delay' => '5',
                'countryCode' => '62',
            ],
            CURLOPT_HTTPHEADER => ['Authorization: ' . config('app.FONNTE')],
        ]);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            return $error_msg;
        }

        return $response;
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
        <h1 class="text-center text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-2xl">
          Daftar
        </h1>
        <form wire:submit="register"
              class="space-y-4 md:space-y-6">
          <div>
            <label for="npp"
                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">NPP</label>
            <input id="npp"
                   wire:model="npp"
                   type="text"
                   name="npp"
                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                   placeholder="12345">
            <x-input-error :messages="$errors->get('npp')"
                           class="mt-2" />
          </div>
          <button type="submit"
                  wire:loading.remove
                  class="w-full rounded-lg bg-primary-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            Cari NPP
          </button>
          <p class="mt-6 text-sm font-light text-gray-500 dark:text-gray-400">
            <a href="{{ route('login') }}"
               wire:navigate="false"
               class="font-medium text-primary-600 hover:underline dark:text-primary-500">
              Kembali
            </a>
          </p>
        </form>
      </div>
    </div>
  </div>
</section>

@once
  @push('customScript')
    <script type="module">
      Livewire.on('notifikasi', async (event) => {
        $wireui.notify({
          icon: event.icon,
          title: event.title,
          description: event.description,
        });
      });
    </script>
  @endpush
@endonce
