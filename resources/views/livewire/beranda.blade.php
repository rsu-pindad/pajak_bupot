<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Kehadiran;
use App\Models\Personalia;
use App\Models\Insentif;
use Illuminate\Support\Carbon;

new 
#[Layout('layouts.pajak')] 
#[Title('Beranda')] 
class extends Component {

    public $jumlahKehadiran;
    public $jumlahKehadiranBulanIni;
    public $jumlahKehadiranTerkirim;
    public $jumlahKehadiranBelumTerkirim;

    public $jumlahInsentif;
    public $jumlahInsentifBulanIni;
    public $jumlahInsentifTerkirim;
    public $jumlahInsentifBelumTerkirim;

    public $jumlahPersonalia;
    public $jumlahPersonaliaEpin;
    public $jumlahPersonaliaNonEpin;

    public function mount()
    {
      if(Auth::user()->hasRole('payroll')){
        $this->jumlahKehadiran = Kehadiran::all()->count();
        $this->jumlahKehadiranTerkirim = Kehadiran::all()->where('has_blast', 1)->count();
        $this->jumlahKehadiranBelumTerkirim = Kehadiran::all()->where('has_blast', 0)->count();
        $this->jumlahKehadiranBulanIni = Kehadiran::select('id')
            // ->whereMonth('created_at', Carbon::now()->month)
            ->where('kehadiran_pembayaran_bulan', Carbon::now()->format('m'))
            ->get()->count();
        $this->jumlahInsentif = Insentif::all()->count();
        $this->jumlahInsentifTerkirim = Insentif::all()->where('has_blast', 1)->count();
        $this->jumlahInsentifBelumTerkirim = Insentif::all()->where('has_blast', 0)->count();
        $this->jumlahInsentifBulanIni = Insentif::select('id')
            // ->whereMonth('created_at', Carbon::now()->month)
            ->where('insentif_pembayaran_bulan', Carbon::now()->format('m'))
            ->get()->count();
      }
      if(Auth::user()->hasRole('personalia')){
        $this->jumlahPersonalia = Personalia::all()->count();
        $this->jumlahPersonaliaEpin = Personalia::all()->where('epin', '!=', null)->count();
        $this->jumlahPersonaliaNonEpin = Personalia::all()->where('epin', null)->count();
      }
    }

}; ?>

<section class="bg-white py-6 antialiased dark:bg-gray-900 md:py-6">
  <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">
    <nav class="mb-4 flex"
         aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 rtl:space-x-reverse md:space-x-2">
        <li class="inline-flex items-center">
          <a href="#"
             class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
            <x-cui-cil-home class="me-2 h-4 w-4"/>
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
        <a href="{{route('payroll-kehadiran')}}" wire:navigate="false">
        <x-cui-cil-calendar-check class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Data Kehadiran</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahKehadiran}}
        </span>
        </a>
      </div>
      <div>
        <x-cui-cil-description class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Kehadiran Bulan ({{Carbon::now()->format('F')}})</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahKehadiranBulanIni}}
        </span>
      </div>
      <div>
        <x-cui-cil-envelope-letter class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Slip Terkirim</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahKehadiranTerkirim}}
          </span>
        </span>
      </div>
      <div>
        <x-cui-cil-envelope-closed class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Slip Belum Terkirim</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahKehadiranBelumTerkirim}}
        </span>
      </div>
    </div>
    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl md:mb-6 border-1">Insentif</h2>
    <div
         class="grid grid-cols-2 gap-6 border-b border-t border-gray-200 py-4 dark:border-gray-700 md:py-8 lg:grid-cols-4 xl:gap-16">
      <div>
        <a href="{{route('payroll-insentif')}}" wire:navigate="false">
          <x-cui-cil-thumb-up class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
          <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Data Insentif</h3>
          <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahInsentif}}
          </span>
        </a>
      </div>
      <div>
        <x-cui-cil-description class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Insentif Bulan ({{Carbon::now()->format('F')}})</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahInsentifBulanIni}}
        </span>
      </div>
      <div>
        <x-cui-cil-envelope-letter class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Slip Terkirim</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahInsentifTerkirim}}
          </span>
        </span>
      </div>
      <div>
        <x-cui-cil-envelope-closed class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Slip Belum Terkirim</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahInsentifBelumTerkirim}}
        </span>
      </div>
    </div>
    @endhasexactroles
    @hasexactroles('personalia')
    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl md:mb-6 border-1">Karyawan</h2>
    <div class="grid grid-cols-2 gap-6 border-b border-t border-gray-200 py-4 dark:border-gray-700 md:py-8 lg:grid-cols-4 xl:gap-16">
      <div>
        <x-cui-cil-group class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Data Karyawan</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahPersonalia}}
        </span>
      </div>
      <div>
        <x-cui-cil-check-circle class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Karyawan memiliki E-Pin</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahPersonaliaEpin}}
        </span>
      </div>
      <div>
        <x-cui-cil-warning class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
        <h3 class="mb-2 text-gray-500 dark:text-gray-400">Total Karyawan tidak memiliki E-Pin</h3>
        <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
            {{$this->jumlahPersonaliaNonEpin}}
          </span>
        </span>
      </div>
    </div>
    @endhasexactroles
  </div>
</section>
