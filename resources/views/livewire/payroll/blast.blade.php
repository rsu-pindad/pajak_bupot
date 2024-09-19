<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Models\Insentif;
use App\Livewire\Forms\Payroll\BlastForm;

new 
#[Layout('layouts.karyawan')] 
#[Title('Halaman Brodcast')] 
class extends Component {

  public BlastForm $form;

  #[On('bulkBlastWhatsApp')]
  public function tabelBulkBlast($rowId)
  {
    $this->dispatch('notifikasi', icon: 'info', title: 'Blast', description: $rowId);
  }

  #[On('blastWhatsApp')]
  public function tabelBlast($rowId)
  {
    $blast = $this->form->blast($rowId);
    $this->dispatch('notifikasi', icon: 'info', title: 'Blast', description: $blast);
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
              <x-cui-cil-share-alt class="mx-1 h-4 w-4 text-gray-400" />
              Broadcast
            </a>
          </li>
        </ol>
      </nav>
      <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-1">
            <div
                class="h-64 overflow-x-hidden rounded-lg border-2 border-dashed border-gray-300 p-6 dark:border-gray-600 md:h-auto">
                <livewire:power.payroll.blast-tabel />
            </div>
        </div>
    </div>
</section>

@once
  @push('customScript')
    <script type="module">
      Livewire.on('notifikasi', async (event) => {
        await Livewire.dispatch('pg:eventRefresh-payroll_blast');
        $wireui.notify({
          icon: event.icon,
          title: event.title,
          description: event.description,
        });
      });
      Livewire.on('infoBlast', async (event) => {
        console.log(event);
        window.$wireui.confirmDialog({
          title: 'informasikan via whatsapp?',
          description: 'Berkas Insentif / Kehadiran ?.',
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
      });
    </script>
  @endpush
@endonce
