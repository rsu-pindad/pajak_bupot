<?php

use App\Imports\PersonaliaImport;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

new
  #[Layout('layouts.karyawan')]
  #[Title('Halaman Karyawan Personalia')]
  class extends Component {

    use WithFileUploads;

    #[Validate('file')]
    public $fileUpload;

    public function import()
    {
      // dd($this->fileUpload->path());
      $excelImport = Excel::import(new PersonaliaImport, $this->fileUpload->path());
      $this->fileUpload;
      dd($excelImport);
    }
  };
?>

<div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-1">
  <div class="h-24 overflow-x-auto rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-48">

    <div class="p-6">
      <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Unggah Berkas</label>
        <input wire:model="fileUpload" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">XLSX, XLS</p>
      </div>

      <div>
        <button wire:click="import" type="button" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          <x-cui-cil-cloud-upload class="size-4 fill-current" />
          Unggah
        </button>
      </div>
    </div>
  </div>
  <div class="h-32 overflow-x-hidden rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-auto">
    <div class="p-6">
      <livewire:power.personalia-tabel />
    </div>
  </div>
</div>