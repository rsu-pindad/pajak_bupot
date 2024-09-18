<?php

use App\Models\Insentif;
use App\Models\Personalia;
use Livewire\Volt\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Carbon;
use DevRaeph\PDFPasswordProtect\Facade\PDFPasswordProtect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;
use YorCreative\UrlShortener\Services\UrlService;
use function Spatie\LaravelPdf\Support\pdf;

new 
#[Layout('layouts.employee')] 
#[Title('Halaman Berkas Insentif')] 
class extends Component {
    public $bulanPembayaranInsentif;
    public $tahunInsentif;
    public $bulan = [];

    public $tautanBerkas = false;
    public $urlBerkas = '';
    public $signedUrl = '';

    public function mount()
    {
        setlocale(LC_ALL, 'IND');
        for ($m = 1; $m <= 12; $m++) {
            $this->bulan[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }
    }

    public function cariKehadiran()
    {
        $dataKehadiran = Insentif::select()
            ->where('npp_insentif', Auth::user()->npp)
            ->where('insentif_pembayaran_bulan', $this->bulanPembayaranInsentif)
            ->where('insentif_tahun', $this->tahunInsentif)
            ->first();
        if (!$dataKehadiran) {
            $this->tautanBerkas = false;
            $this->urlBerkas = '';
            $this->signedUrl = '';
            return $this->dispatch('notifikasi', icon: 'info', title: 'Berkas', description: 'berkas insentif tidak ditemukan!.');
        }
        $this->signedUrl = URL::temporarySignedRoute('berkas-insentif-karyawan', now()->addDays(1), ['user' => Auth::user()->npp, 'bulan' => $this->bulanPembayaranInsentif, 'tahun' => $this->tahunInsentif]);
        $this->urlBerkas = UrlService::shorten($this->signedUrl)
            ->withOpenLimit(2)
            ->build();
        $this->tautanBerkas = true;
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
            <x-cui-cil-home class="me-2 h-4 w-4" />
            Berkas
          </a>
        </li>
        <li class="flex items-center">
          <a href="#"
             class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
            <x-cui-cil-caret-right class="mx-1 h-4 w-4 text-gray-400" />
            Slip Insentif
          </a>
        </li>
      </ol>
    </nav>
    <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-1">
      <div
           class="h-auto overflow-x-auto rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-auto">
        <div class="p-6">

          <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2">
            <div>
              <label for="bulan_pembayaran_kehadiran"
                     class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                Bulan Insentif
              </label>
              <select id="bulan_pembayaran_kehadiran"
                      wire:model="bulanPembayaranInsentif"
                      class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                <option hidden>Pilih Bulan Insentif</option>
                @foreach ($this->bulan as $bulan)
                  <option value="{{ Carbon::parse($bulan)->format('m') }}">
                    {{ Carbon::parse($bulan)->formatLocalized('%B') }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="tahun_insentif"
                     class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tahun
                Insentif</label>
              <input id="tahun_insentif"
                     wire:model="tahunInsentif"
                     placeholder="{{ Carbon::now()->format('Y') }}"
                     type="text"
                     class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
            </div>
          </div>

          <div class="mt-4">
            <button wire:click="cariKehadiran"
                    wire:loading.remove
                    class="inline-flex items-center rounded-lg bg-blue-700 px-3 py-2 text-center text-xs font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              Cari
              <x-cui-cil-magnifying-glass class="size-4 ml-4 fill-current" />
            </button>
          </div>
        </div>
      </div>
    </div>

    @if ($this->tautanBerkas)
      <div class="grid grid-cols-1 gap-4">
        <div
             class="h-auto overflow-x-auto rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-auto">
          <div class="p-6">
            <h4 class="ml-4 text-green-500">Berkas ditemukan !!</h4>
            <a href="{{ $this->urlBerkas }}"
               target="_blank"
               class="inline-flex items-center justify-center rounded-lg bg-gray-50 p-5 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
              <x-cui-cil-file class="me-3 h-5 w-5" />
              <span class="w-full">Lihat Berkas bulan {{ $this->bulanPembayaranInsentif }} tahun
                {{ $this->tahunInsentif }}</span>
              <x-cui-cil-arrow-right class="ms-2 h-4 w-4" />
            </a>
          </div>
        </div>
      </div>
    @endif
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
