<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Kehadiran;
use Illuminate\Support\Carbon;

new 
#[Layout('layouts.pajak')] 
#[Title('Beranda')] 
class extends Component {
    public $jumlahKehadiran;
    public $jumlahKehadiranBulanIni;
    public $jumlahKehadiranTerkirim;
    public $jumlahKehadiranBelumTerkirim;

    public function mount()
    {
        $this->jumlahKehadiran = Kehadiran::all()->count();
        $this->jumlahKehadiranTerkirim = Kehadiran::all()->where('has_blast', 1)->count();
        $this->jumlahKehadiranBelumTerkirim = Kehadiran::all()->where('has_blast', 0)->count();
        $this->jumlahKehadiranBulanIni = Kehadiran::select('id')
            ->whereMonth('created_at', Carbon::now()->month)
            ->get()->count();
    }

}; ?>

<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
  <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">
    <nav class="mb-4 flex"
         aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 rtl:space-x-reverse md:space-x-2">
        <li class="inline-flex items-center">
          <a href="#"
             class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
            <svg class="me-2 h-4 w-4"
                 aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg"
                 width="24"
                 height="24"
                 fill="none"
                 viewBox="0 0 24 24">
              <path stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
            </svg>
            Beranda
          </a>
        </li>
      </ol>
    </nav>
    @hasexactroles('payroll')
    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl md:mb-6 border-1">Kehadiran</h2>
    <div
         class="grid grid-cols-2 gap-6 border-b border-t border-gray-200 py-4 dark:border-gray-700 md:py-8 lg:grid-cols-4 xl:gap-16">
      <div>
        <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500"
             aria-hidden="true"
             xmlns="http://www.w3.org/2000/svg"
             width="24"
             height="24"
             fill="none"
             viewBox="0 0 24 24">
          <path stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
        </svg>
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Data Kehadiran</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahKehadiran}}
        </span>
      </div>
      <div>
        <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500"
             aria-hidden="true"
             xmlns="http://www.w3.org/2000/svg"
             width="24"
             height="24"
             fill="none"
             viewBox="0 0 24 24">
          <path stroke="currentColor"
                stroke-width="2"
                d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z" />
        </svg>
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Kehadiran Bulan ({{Carbon::now()->format('F')}})</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahKehadiranBulanIni}}
        </span>
      </div>
      <div>
        <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500"
             aria-hidden="true"
             xmlns="http://www.w3.org/2000/svg"
             width="24"
             height="24"
             fill="none"
             viewBox="0 0 24 24">
          <path stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
        </svg>
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Slip Terkirim</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahKehadiranTerkirim}}
          </span>
        </span>
      </div>
      <div>
        <svg class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500"
             aria-hidden="true"
             xmlns="http://www.w3.org/2000/svg"
             width="24"
             height="24"
             fill="none"
             viewBox="0 0 24 24">
          <path stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 9h13a5 5 0 0 1 0 10H7M3 9l4-4M3 9l4 4" />
        </svg>
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Slip Belum Terkirim</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahKehadiranBelumTerkirim}}
        </span>
      </div>
    </div>
    @endhasexactroles
  </div>
</section>
