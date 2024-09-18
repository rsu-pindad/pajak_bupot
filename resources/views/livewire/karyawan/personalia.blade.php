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
            // $this->formatLatestUpdate = Carbon::parse($latestUpdate->updated_at)->formatLocalized('Y F D h:i:s');
            $this->formatLatestUpdate = Carbon::parse($latestUpdate->updated_at)->formatLocalized('%G-%B, %A %T');
        } else {
            $this->formatLatestUpdate = 'belum ada data';
        }
    }

    public function import()
    {
        $this->validate();
        try {
            $excelImport = Excel::import(new PersonaliaImport(), $this->fileUpload->path());
            if ($excelImport) {
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
                    wire:loading.attr="disabled"
                    type="button"
                    class="inline-flex items-center rounded-lg bg-blue-700 px-3 py-2 text-center text-xs font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              <span wire:loading.remove>Unggah</span>
              <span wire:loading>Mengunggah</span>
              <x-cui-cil-cloud-upload wire:loading.remove
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
  <div class="h-32 overflow-x-hidden rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-auto">
    <div class="p-6">
      <div
           class="flex-column flex flex-wrap items-center justify-between space-y-4 bg-white py-4 dark:bg-gray-900 md:flex-row md:space-y-0">
        <div wire:ignore>
          <h6>Terakhir unggah data : {{ $this->formatLatestUpdate }}</h6>
        </div>
        <div>
          <button id="dropdownActionButton"
                  data-dropdown-toggle="dropdownAction"
                  class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                  type="button">
            <span class="sr-only">Action button</span>
            Menu
            <x-cui-cil-chevron-circle-down-alt class="size-3 ml-2 fill-current" />
          </button>
          <!-- Dropdown menu -->
          <div id="dropdownAction"
               class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownActionButton">
              <li>
                <a href="#"
                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Coming soon</a>
              </li>
              <li>
                <a href="#"
                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Coming soon</a>
              </li>
              <li>
                <a href="#"
                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Coming soon</a>
              </li>
            </ul>
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
