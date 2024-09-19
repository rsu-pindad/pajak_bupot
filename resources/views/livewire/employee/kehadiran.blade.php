<?php

use App\Models\Kehadiran;
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
#[Title('Halaman Berkas Kehadiran')] 
class extends Component {
    public $bulanPembayaranKehadiran;
    public $tahunKehadiran;
    public $bulan = [];

    public $tautanBerkas = false;
    public $urlBerkas = '';
    public $signedUrl = '';
    public $otp = '';

    public $tahun;

    public function mount()
    {
        setlocale(LC_ALL, 'IND');
        for ($m = 1; $m <= 12; $m++) {
            $this->bulan[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }
        $this->tahun = collect(range(10, 0))->map(function ($item) {
            return (string) date('Y') - $item;
        });
    }

    public function cariKehadiran()
    {
        $dataKehadiran = Kehadiran::select()
            ->where('npp_kehadiran', Auth::user()->npp)
            ->where('kehadiran_pembayaran_bulan', $this->bulanPembayaranKehadiran)
            ->where('kehadiran_tahun', $this->tahunKehadiran)
            ->first();
        if (!$dataKehadiran) {
            $this->tautanBerkas = false;
            $this->urlBerkas = '';
            $this->signedUrl = '';
            return $this->dispatch('notifikasi', icon: 'info', title: 'Berkas', description: 'berkas kehadiran tidak ditemukan!.');
        }
        $this->otp = Str::random(4);
        $this->signedUrl = URL::temporarySignedRoute('berkas-kehadiran-karyawan', now()->addDays(1), ['user' => Auth::user()->npp, 'bulan' => $this->bulanPembayaranKehadiran, 'tahun' => $this->tahunKehadiran, 'otp' => $this->otp]);
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
            Slip Kehadiran
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
                Bulan Kehadiran
              </label>
              <select id="bulan_pembayaran_kehadiran"
                      wire:model="bulanPembayaranKehadiran"
                      class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                <option hidden>Pilih Bulan Kehadiran</option>
                @foreach ($this->bulan as $bulan)
                  <option value="{{ Carbon::parse($bulan)->format('m') }}">
                    {{ Carbon::parse($bulan)->formatLocalized('%B') }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="tahun_insentif"
                     class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tahun Kehadiran</label>
              <select id="tahun_insentif"
                      wire:model="tahunKehadiran"
                      wire:loading.attr="disabled"
                      class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                <option hidden>Pilih Tahun Kehadiran</option>
                @foreach ($this->tahun as $t)
                  <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mt-4">
            <button wire:click="cariKehadiran"
                    wire:loading.attr="disabled"
                    type="button"
                    class="inline-flex items-center rounded-lg bg-blue-700 px-3 py-2 text-center text-xs font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              <span wire:loading.remove>Cari</span>
              <span wire:loading>Mencari..</span>
              <x-cui-cil-magnifying-glass wire:loading.remove
                                      class="size-4 ml-4 fill-current" />
              <div wire:loading
                   role="status">
                <svg aria-hidden="true"
                     class="ml-4 inline h-8 w-8 animate-spin fill-blue-600 text-gray-200 dark:text-gray-600"
                     viewBox="0 0 100 101"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                  <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
              </div>
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
              <span class="w-full">Lihat Berkas bulan {{ $this->bulanPembayaranKehadiran }} tahun
                {{ $this->tahunKehadiran }}</span>
              <x-cui-cil-arrow-right class="ms-2 h-4 w-4" />
            </a>
            <h4 class="ml-4 font-semibold">
              OTP : {{$this->otp}}
            </h4>
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
