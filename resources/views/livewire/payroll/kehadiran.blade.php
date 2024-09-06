<?php

use App\Imports\Payroll\SelectSheetImport;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Livewire\Forms\Payroll\KehadiranForm;
use Illuminate\Support\Carbon;

new 
#[Layout('layouts.karyawan')] 
#[Title('Halaman Payroll Kehadiran')] 
class extends Component {
    use WithFileUploads;

    #[Validate('file')]
    public $fileUpload;

    #[Validate('required')]
    public $bulanInsentif;

    #[Validate('required')]
    public $tahunInsentif = '';

    public $bulan = [];

    public KehadiranForm $form;

    public function mount()
    {
      setlocale(LC_ALL, 'IND');
      for ($m=1; $m<=12; $m++) {
        $this->bulan[] = Carbon::parse(date('F', mktime(0,0,0,$m, 1, date('Y'))))->formatLocalized('%B');
      }
    }

    public function import()
    {
        $this->validate();
        try {
            $import = new SelectSheetImport($this->bulanInsentif, $this->tahunInsentif);
            $import->onlySheets('tj kehadiran');

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
    public function pulihkan($rowId) {
        try {
            $this->form->restore($rowId);
            $this->dispatch('notifikasi', icon: 'success', title: 'Blast', description: 'data berhasil dipulihkan!.');
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Blast', description: $th->getMessage());
        }
    }

    #[On('executeHapus')]
    public function hapus ($rowId) {
        try {
            $this->form->destroy($rowId);
            $this->dispatch('notifikasi', icon: 'success', title: 'Blast', description: 'data berhasil dihapus!.');
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Blast', description: $th->getMessage());
        }
    }

    #[On('executePermanentHapus')]
    public function permanentHapus($rowId) {
        try {
            $this->form->permanentDestroy($rowId);
            $this->dispatch('notifikasi', icon: 'success', title: 'Kode', description: 'data berhasil dihapus dari database!.');
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Kode', description: $th->getMessage());
        }
    }

}; ?>

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
           class="mt-1 text-sm text-gray-500 dark:text-gray-300">tipe file : xlsx, xls</p>
      </div>

      <div class="mt-4 grid sm:grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="bulan_insentif" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bulan Insentif Kehadiran</label>
          <select wire:model="bulanInsentif" id="bulan_insentif" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option hidden>Pilih Bulan Insentif Kehadiran</option>
            @foreach ($this->bulan as $bulan)
              <option value="{{$bulan}}">{{$bulan}}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="tahun_insentif" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukan Tahun Insentif Kehadiran</label>
          <input wire:model="tahunInsentif" placeholder="{{Carbon::now()->format('Y')}}" type="text" id="tahun_insentif" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
      </div>

      <div class="mt-4">
        <button wire:click="import"
                wire:loading.remove
                type="button"
                class="inline-flex items-center rounded-lg bg-blue-700 px-3 py-2 text-center text-xs font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Unggah
          <x-cui-cil-cloud-upload class="size-4 ml-4 fill-current" />
        </button>
      </div>
    </div>
  </div>
  <div class="h-64 overflow-x-hidden rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-auto">
    <div class="p-6">
      <livewire:power.payroll.kehadiran-tabel />
    </div>
  </div>
</div>

@once
  @push('customScript')
    <script type="module">
      Livewire.on('notifikasi', async (event) => {
        await Livewire.dispatch('pg:eventRefresh-payroll_kehadiran');
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
          description: 'Berkas Kehadiran?',
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
        Livewire.dispatch('pg:eventRefresh-payroll_kehadiran');
      });
      Livewire.on('pulihkan', async (event) => {
        await Livewire.dispatch('executePulihkan', {
          rowId: event
        });
        Livewire.dispatch('pg:eventRefresh-payroll_kehadiran');
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
