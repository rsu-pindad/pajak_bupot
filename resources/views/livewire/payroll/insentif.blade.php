<?php

use App\Imports\Payroll\SelectSheetImport;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Livewire\Forms\Payroll\InsentifForm;
use Illuminate\Support\Carbon;

new 
#[Layout('layouts.karyawan')] 
#[Title('Halaman Insentif')] 
class extends Component {
    use WithFileUploads;

    #[Validate('file')]
    public $fileUpload;

    #[Validate('required')]
    public $bulanPeriodeInsentif;

    #[Validate('required')]
    public $bulanPembayaranInsentif;

    #[Validate('required')]
    public $tahunInsentif;

    #[Validate('required')]
    public $barisMulai;

    #[Validate('required')]
    public $barisAkhir;

    public $bulan = [];
    public $tahun;

    public InsentifForm $form;

    public function mount()
    {
        setlocale(LC_ALL, 'IND');
        for ($m = 1; $m <= 12; $m++) {
            // $this->bulan[] = Carbon::parse(date('F', mktime(0,0,0,$m, 1, date('Y'))))->formatLocalized('%B');
            $this->bulan[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }
        $this->tahun = collect(range(10, 0))->map(function ($item) {
            return (string) date('Y') - $item;
        });
    }

    public function import()
    {
        $this->validate();
        try {
            $import = new SelectSheetImport($this->bulanPeriodeInsentif, $this->bulanPembayaranInsentif, $this->tahunInsentif, $this->barisMulai, $this->barisAkhir);
            $import->onlySheets('INSENTIF FIX');

            $excelImport = Excel::import($import, $this->fileUpload->path());
            if ($excelImport) {
                $this->dispatch('notifikasi', icon: 'success', title: 'Import Data Sukses', description: 'data berhasil di import!.');
            }
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Import Data Error', description: $th->getMessage());
        }
    }

    #[On('blastWhatsApp')]
    public function tabelBlast($rowId)
    {
        $blast = $this->form->blast($rowId);
        $this->dispatch('notifikasi', icon: 'info', title: 'Blast', description: $blast);
    }

    #[On('bulkBlastWhatsApp')]
    public function tabelBulkBlast($rowId)
    {
        // $blast = $this->form->bulkBlast($rowId);
        $this->dispatch('notifikasi', icon: 'info', title: 'Blast', description: $rowId);
    }

    #[On('executePulihkan')]
    public function pulihkan($rowId)
    {
        try {
            $this->form->restore($rowId);
            $this->dispatch('notifikasi', icon: 'success', title: 'Blast', description: 'data berhasil dipulihkan!.');
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Blast', description: $th->getMessage());
        }
    }

    #[On('executeHapus')]
    public function hapus($rowId)
    {
        try {
            $this->form->destroy($rowId);
            $this->dispatch('notifikasi', icon: 'success', title: 'Blast', description: 'data berhasil dihapus!.');
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Blast', description: $th->getMessage());
        }
    }

    #[On('executePermanentHapus')]
    public function permanentHapus($rowId)
    {
        try {
            $this->form->permanentDestroy($rowId);
            $this->dispatch('notifikasi', icon: 'success', title: 'Kode', description: 'data berhasil dihapus dari database!.');
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Kode', description: $th->getMessage());
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
            <x-cui-cil-home class="me-2 h-4 w-4" />
            Payroll
          </a>
        </li>
        <li class="flex items-center">
          <a href="#"
             class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
            <x-cui-cil-caret-right class="mx-1 h-4 w-4 text-gray-400" />
            Insentif
          </a>
        </li>
      </ol>
    </nav>
    <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-1">
      <div
           class="h-auto overflow-x-auto rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-auto">
        <div class="p-6">

          <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2">
            <div class="grid-cols-subgrid col-span-2 grid gap-4">
              <div class="col-start-1">
                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                       for="file_input">Unggah Berkas
                </label>
                <input id="file_input"
                       wire:model="fileUpload"
                       wire:loading.attr="disabled"
                       class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                       aria-describedby="file_input_help"
                       type="file">
                <p id="file_input_help"
                   class="mt-1 text-sm text-gray-500 dark:text-gray-300">tipe file : xlsx, xls
                </p>
              </div>
              <div class="col-start-2">
                <label for="tahun_insentif"
                       class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tahun Insentif</label>
                <select id="tahun_insentif"
                        wire:model="tahunInsentif"
                        wire:loading.attr="disabled"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                  <option hidden>Pilih Tahun Insentif</option>
                  @foreach ($this->tahun as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div>
              <label for="bulan_periode_insentif"
                     class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Bulan Periode Insentif</label>
              <select id="bulan_periode_insentif"
                      wire:model="bulanPeriodeInsentif"
                      wire:loading.attr="disabled"
                      class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                <option hidden>Pilih Bulan Periode Insentif</option>
                @foreach ($this->bulan as $bulan)
                  <option value="{{ Carbon::parse($bulan)->format('m') }}">
                    {{ Carbon::parse($bulan)->formatLocalized('%B') }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="bulan_pembayaran_insentif"
                     class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Bulan Pembayaran
                Insentif</label>
              <select id="bulan_pembayaran_insentif"
                      wire:model="bulanPembayaranInsentif"
                      wire:loading.attr="disabled"
                      class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                <option hidden>Pilih Bulan Pembayaran Insentif</option>
                @foreach ($this->bulan as $bulan)
                  <option value="{{ Carbon::parse($bulan)->format('m') }}">
                    {{ Carbon::parse($bulan)->formatLocalized('%B') }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="baris_mulai"
                     class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                Data Excel Baris Mulai</label>
              <input id="baris_mulai"
                     wire:model="barisMulai"
                     wire:loading.attr="disabled"
                     class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                     aria-describedby="file_input_help"
                     type="number">
            </div>
            <div>
              <label for="baris_akhir"
                     class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                Data Excel Baris Akhir</label>
              <input id="baris_akhir"
                     wire:model="barisAkhir"
                     wire:loading.attr="disabled"
                     class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                     aria-describedby="file_input_help"
                     type="number">
            </div>
          </div>

          <div class="mt-4">
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
      <div
           class="h-64 overflow-x-hidden rounded-lg border-2 border-dashed border-gray-300 p-6 dark:border-gray-600 md:h-auto">
           <div
              class="flex-column flex flex-wrap items-center justify-between space-y-4 bg-white py-4 dark:bg-gray-900 md:flex-row md:space-y-0">
              <div wire:ignore>
              </div>
              <div>
                <button id="dropdownActionButton"
                        data-dropdown-toggle="dropdownAction"
                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                        type="button">
                  <span class="sr-only">Button Menu</span>
                  Menu
                  <x-cui-cil-chevron-circle-down-alt class="size-3 ml-2 fill-current" />
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownAction"
                    class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700">
                  <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                      aria-labelledby="dropdownActionButton">
                    <li>
                      <a href="{{route('template-import', ['jenis' => 'insentif'])}}"
                        class="inline-flex items-center justify-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        <x-cui-cil-cloud-download class="h-4 w-4 mr-2" />
                        Template Import
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
           <livewire:power.payroll.insentif-tabel />
      </div>
    </div>
  </div>
</section>

@once
  @push('customScript')
    <script type="module">
      Livewire.on('notifikasi', async (event) => {
        await Livewire.dispatch('pg:eventRefresh-payroll_insentif');
        @this.fileUpload = '';
        $wireui.notify({
          icon: event.icon,
          title: event.title,
          description: event.description,
        });
      });
      Livewire.on('infoBlast', async (event) => {
        window.$wireui.confirmDialog({
          title: 'informasikan via whatsapp?',
          description: 'Berkas Insentif?',
          icon: 'question',
          accept: {
            label: 'Kirim',
            execute: () => Livewire.dispatch('blastWhatsApp', {
              rowId: event
            })
          },
          reject: {
            label: 'Tidak',
          }
        })
      });
      Livewire.on('infoBulkBlast', async (event) => {
        await Livewire.dispatch('blastWhatsApp', {
          rowId: event
        });
        // Livewire.dispatch('pg:eventRefresh-payroll_kehadiran');
      });
      Livewire.on('hapus', async (event) => {
        await Livewire.dispatch('executeHapus', {
          rowId: event
        });
        Livewire.dispatch('pg:eventRefresh-payroll_insentif');
      });
      Livewire.on('pulihkan', async (event) => {
        await Livewire.dispatch('executePulihkan', {
          rowId: event
        });
        Livewire.dispatch('pg:eventRefresh-payroll_insentif');
      });
      Livewire.on('permanenDelete', async (event) => {
        window.$wireui.confirmDialog({
          title: 'Permanent Delete',
          description: 'anda yakin ? data akan dihapus dari database & tidak dapat dikembalikan',
          icon: 'warning',
          accept: {
            label: 'iya',
            execute: () => Livewire.dispatch('executePermanentHapus', {
              rowId: event
            })
          },
          reject: {
            label: 'batal',
          }
        });
      });
    </script>
  @endpush
@endonce
