<?php

use App\Imports\Payroll\SelectSheetImport;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Maatwebsite\Excel\Facades\Excel;

new
    #[Layout('layouts.karyawan')]
    #[Title('Halaman Payroll Kehadiran')]
    class extends Component {

        use WithFileUploads;

        #[Validate('file')]
        public $fileUpload;

        #[Validate('required')]
        #[Validate('numeric')]
        public $heading;

        // #[Validate('required')]
        // #[Validate('numeric')]
        // public $mulai;

        public function import()
        {
            $import = new SelectSheetImport($this->heading);
            $import->onlySheets('tj kehadiran');

            $excelImport = Excel::import($import, $this->fileUpload->path());
            // dd($excelImport);
            // $this->fileUpload;

        }
    }; ?>

<div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-1">
    <div class="h-24 overflow-x-auto rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-48">

        <div class="p-6">
            <div>
                <label wire:model="heading" for="heading-row" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tabel Heading:</label>
                <div class="relative flex items-center max-w-[8rem]">
                    <button type="button" id="decrement-button" data-input-counter-decrement="heading-row" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                        <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                        </svg>
                    </button>
                    <input type="text" id="heading-row" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required />
                    <button type="button" id="increment-button" data-input-counter-increment="heading-row" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                        <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                        </svg>
                    </button>
                </div>
                <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Masukan Baris Heading.</p>
            </div>
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
            <livewire:power.payroll.kehadiran-tabel />
        </div>
    </div>
</div>