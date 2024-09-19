<?php

namespace App\Livewire\Power\Payroll;

use App\Enums\Bulan;
use App\Models\Insentif;
use App\Models\Kehadiran;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Locked;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;

final class BlastTabel extends PowerGridComponent
{
    use WithExport;

    #[Locked]
    public string $tableName = 'payroll_blast';

    public string $primaryKey = 'payroll_insentif.id';

    public bool $deferLoading = false;

    public function hydrate(): void
    {
        sleep(1);
    }

    protected function queryString(): array
    {
        return [
            'search' => ['except' => ''],
            ...$this->powerGridQueryString(),
        ];
    }

    public function header(): array
    {
        return [
            Button::add('segarkan')
                ->slot('<x-wireui-mini-button sm rounded secondary icon="arrow-path" wire:click="$refresh" spinner />'),
            Button::add('bulk-blast')
                ->slot('<x-cui-cib-whatsapp class="w-5 h-5" />(<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->confirm('sebarkan dokumen ke whatsapp ?')
                ->dispatch('bulkBlastWa.' . $this->tableName, [])
        ];
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        // $this->persist(
        //     tableItems: ['columns', 'filters', 'sorting'],
        //     prefix: 'payroll_blast_table_' . Auth::id(),
        // );

        return [
            Header::make()
                ->showToggleColumns()
                ->withoutLoading(),
            Footer::make()
                ->pageName('blastPage')
                ->showPerPage(perPageValues: [25, 50, 100]),
        ];
    }

    public function datasource(): ?Builder
    {
        return Insentif::query()
                   // select('payroll_insentif.id as payroll_id','payroll_insentif.npp_insentif')
                   ->join('payroll_kehadiran', function ($kehadiran) {
                       $kehadiran->on('payroll_kehadiran.npp_kehadiran', '=', 'payroll_insentif.npp_insentif');
                       $kehadiran->on('payroll_kehadiran.kehadiran_periode_bulan', '=', 'payroll_insentif.insentif_periode_bulan');
                       $kehadiran->on('payroll_kehadiran.kehadiran_pembayaran_bulan', '=', 'payroll_insentif.insentif_pembayaran_bulan');
                       $kehadiran->on('payroll_kehadiran.kehadiran_tahun', '=', 'payroll_insentif.insentif_tahun');
                   })
                   ->select([
                       'payroll_insentif.id as id',
                       'payroll_insentif.npp_insentif',
                       'payroll_insentif.nama_pegawai as nama_insentif',
                       'payroll_insentif.no_hp as hp_insentif',
                       'payroll_insentif.has_blast as insentif_blast',
                       'payroll_insentif.status_blast as insentif_status_blast',
                       'payroll_insentif.insentif_periode_bulan',
                       'payroll_insentif.insentif_pembayaran_bulan',
                       'payroll_insentif.insentif_tahun',
                       'payroll_kehadiran.id as kehadiran_id',
                       'payroll_kehadiran.npp_kehadiran',
                       'payroll_kehadiran.nama_pegawai as nama_kehadiran',
                       'payroll_kehadiran.no_hp as hp_kehadiran',
                       'payroll_kehadiran.has_blast as kehadiran_blast',
                       'payroll_kehadiran.status_blast as kehadiran_status_blast',
                       'payroll_kehadiran.kehadiran_periode_bulan',
                       'payroll_kehadiran.kehadiran_pembayaran_bulan',
                       'payroll_kehadiran.kehadiran_tahun',
                   ]);
                //    ->groupBy('npp_insentif');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
                   ->add('id')
                   ->add('insentif_periode_bulan', fn($insentif)    => Bulan::from($insentif->insentif_periode_bulan)->labels())
                   ->add('insentif_pembayaran_bulan', fn($insentif) => Bulan::from($insentif->insentif_pembayaran_bulan)->labels())
                   ->add('insentif_tahun')
                   ->add('insentif_blast')
                   ->add('insentif_blast_label', function ($insentif) {
                       return $insentif->insentif_blast ? 'Iya' : 'Belum';
                   })
                   ->add('insentif_status_blast')
                   ->add('insentif_status_blast_label', function ($insentif) {
                       return $insentif->insentif_status_blast ? 'Terkirim' : 'Belum';
                   })
                   ->add('kehadiran_periode_bulan', fn($kehadiran)    => Bulan::from($kehadiran->kehadiran_periode_bulan)->labels())
                   ->add('kehadiran_pembayaran_bulan', fn($kehadiran) => Bulan::from($kehadiran->kehadiran_pembayaran_bulan)->labels())
                   ->add('kehadiran_tahun')
                   ->add('kehadiran_blast')
                   ->add('kehadiran_blast_label', function ($kehadiran) {
                       return $kehadiran->kehadiran_blast ? 'Iya' : 'Belum';
                   })
                   ->add('kehadiran_status_blast')
                   ->add('kehadiran_status_blast_label', function ($kehadiran) {
                       return $kehadiran->kehadiran_status_blast ? 'Terkirim' : 'Belum';
                   });
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'id')
                ->index()
                ->sortable(),
            Column::make('Insentif ID', 'id'),
            Column::make('Insentif NPP', 'npp_insentif'),
            Column::make('Nama Insentif', 'nama_insentif'),
            Column::make('HP Insentif', 'hp_insentif'),
            Column::make('Blast Insentif', 'insentif_blast_label', 'insentif_blast'),
            Column::make('Status Insentif', 'insentif_status_blast_label', 'insentif_status_blast'),
            Column::make('Kehadiran ID', 'kehadiran_id'),
            Column::make('Kehadiran Npp', 'npp_kehadiran'),
            Column::make('Nama Kehadiran', 'nama_kehadiran'),
            Column::make('HP Kehadiran', 'hp_kehadiran'),
            Column::make('Blast Kehadiran', 'kehadiran_blast_label', 'kehadiran_blast'),
            Column::make('Status Kehadiran', 'kehadiran_status_blast_label', 'kehadiran_status_blast'),
            Column::action('Aksi')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('npp_insentif')->placeholder('cari npp'),
            // Filter::inputText('payroll_insentif.nama_insentif')->placeholder('cari nama'),
            // Filter::inputText('npp_kehadiran')->placeholder('cari npp'),
            // Filter::inputText('nama_kehadiran')->filterRelation('kehadiran','nama_pegawai'),
        ];
    }

    public function actions(Insentif $row): array
    {
        return [
            Button::add('blast')
                ->slot('<x-cui-cib-whatsapp class="w-4 h-4" />')
                ->tooltip('Blast Ke Wa')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('infoBlast', ['rowId' => $row->id]),
        ];
    }

    public function actionRules($row): array
    {
        return [
            Rule::button('blast')
                ->when(fn($insentif) => $insentif->insentif_blast == true || $insentif->kehadiran_blast == true)
                ->hide(),
            Rule::checkbox()
                ->when(fn($insentif) => $insentif->insentif_blast == true || $insentif->kehadiran_blast == true)
                ->hide(),
        ];
    }

    #[On('bulkBlastWa.{tableName}')]
    public function bulkBlastWa(): void
    {
        // dd($this->checkboxValues);
        try {
            if ($this->checkboxValues) {
                // $cariKehadiran = Kehadiran::whereIn('id', Arr::flatten($this->checkboxValues))->get();
                foreach ($this->checkboxValues as $val) {
                    // dd($val);
                    $this->dispatch('infoBulkBlast', rowId: intval($val));
                    // sleep(16);
                }

                $this->js('window.pgBulkActions.clearAll()');
            }
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi',icon: 'error', title: 'Blast',  description: $th->getMessage());
        }
    }
}
