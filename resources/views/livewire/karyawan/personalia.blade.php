<?php

use App\Imports\Karyawan\PersonaliaImport;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Volt\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use App\Models\Personalia;
use Illuminate\Support\Carbon;
use WireUi\Traits\WireUiActions;

new 
#[Layout('layouts.karyawan')] 
#[Title('Halaman Karyawan Personalia')] 
class extends Component {

    use WithFileUploads, WireUiActions;

    #[Validate('file')]
    public $fileUpload;

    #[Reactive]
    protected $formatLatestUpdate;

    public function mount()
    {
        $latestUpdate = Personalia::select('updated_at')->orderBy('updated_at', 'DESC')->first();
        if ($latestUpdate) {
            $this->formatLatestUpdate = Carbon::parse($latestUpdate->updated_at)->format('Y m D h:i:s');
        } else {
            $this->formatLatestUpdate = 'belum ada data';
        }
    }

    public function import()
    {
        $this->validate();
        try {
            $excelImport = Excel::import(new PersonaliaImport(), $this->fileUpload->path());
            if($excelImport){
                $this->fileUpload;
                $this->dispatch('notifikasi', icon: 'success', title: 'Import Data Sukses', description: 'data berhasil di import!.');
            }
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Import Data Error', description: $th->getMessage());
        }
    }
};
?>

<div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-1">
  <div class="h-24 overflow-x-auto rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-48">

    <div class="p-6">
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
               for="file_input">Unggah Berkas</label>
        <input id="file_input"
               wire:model="fileUpload"
               class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
               aria-describedby="file_input_help"
               type="file">
        <p id="file_input_help"
           class="mt-1 text-sm text-gray-500 dark:text-gray-300">XLSX, XLS</p>
      </div>

      <div>
        <button wire:click="import"
                wire:loading.remove
                type="button"
                class="inline-flex items-center rounded-lg bg-blue-700 px-3 py-2 text-center text-xs font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          <x-cui-cil-cloud-upload class="size-4 fill-current" />
          Unggah
        </button>
      </div>
    </div>
  </div>
  <div class="h-32 overflow-x-hidden rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-auto">
    <div class="p-6">
      <div
           class="flex-column flex flex-wrap items-center justify-between space-y-4 bg-white py-4 dark:bg-gray-900 md:flex-row md:space-y-0">
        <div>
          <h6>Terakhir pembaruan data : {{ $this->formatLatestUpdate }}</h6>
        </div>
        <div>
          <button id="dropdownActionButton"
                  data-dropdown-toggle="dropdownAction"
                  class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                  type="button">
            <span class="sr-only">Action button</span>
            Menu
            <svg class="ms-2.5 h-2.5 w-2.5"
                 aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 10 6">
              <path stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
          </button>
          <!-- Dropdown menu -->
          <div id="dropdownAction"
               class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownActionButton">
              <li>
                <a href="#"
                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
              </li>
              <li>
                <a href="#"
                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
              </li>
              <li>
                <a href="#"
                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate
                  account</a>
              </li>
            </ul>
            <div class="py-1">
              <a href="#"
                 class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white">Delete
                User</a>
            </div>
          </div>
        </div>
      </div>
      <livewire:power.karyawan.personalia-tabel />
    </div>
  </div>
</div>

@once
  @push('customScript')
  <script type="module">
    Livewire.on('notifikasi', async (event) => {
        await Livewire.dispatch('pg:eventRefresh-personalias');
        $wireui.notify({
          icon: event.icon,
          title: event.title,
          description: event.description,
        });
      });
  </script>
  @endpush
@endonce
