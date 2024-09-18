<?php

namespace App\Livewire\Power\Payroll;

use App\Enums\Bulan;
use App\Models\Insentif;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
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
use PowerComponents\LivewirePowerGrid\Responsive;

final class InsentifTabel extends PowerGridComponent
{
    use WithExport;

    #[Locked]
    public string $tableName = 'payroll_insentif';

    public bool $deferLoading = true;
    public string $strRandom  = '';

    public function hydrate(): void
    {
        sleep(1);
    }

    protected function queryString(): array
    {
        return [
            'search' => ['except' => ''],
            // 'page' => ['except' => 1],
            ...$this->powerGridQueryString(),
        ];
    }

    public function header(): array
    {
        return [
            Button::add('segarkan')
                ->slot('<x-wireui-mini-button sm rounded secondary icon="arrow-path" wire:click="$refresh" spinner />'),
            Button::add('bulk-delete')
                ->slot('<x-cui-cil-trash class="w-5 h-5" />(<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->confirm('Anda yakin hapus data?')
                ->dispatch('bulkDelete.' . $this->tableName, []),
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

        $this->persist(
            tableItems: ['columns', 'filters', 'sorting'],
            prefix: 'payroll_insentif_table_' . Auth::id(),
        );
        $this->strRandom = Str::random(4);

        return [
            Exportable::make('export_payroll_insentif_' . Carbon::now()->format('Y-M-d_') . $this->strRandom)
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
                ->csvSeparator(',')
                ->csvDelimiter('"'),
            Header::make()
                ->showToggleColumns()
                ->withoutLoading()
                ->showSoftDeletes(showMessage: false),
            Footer::make()
                ->pageName('insentifPage')
                ->showPerPage(perPageValues: [25, 50, 100]),
            Responsive::make()
                ->fixedColumns('nama_pegawai', 'npp_insentif', 'has_blast_label', 'status_blast_label', Responsive::ACTIONS_COLUMN_NAME),
        ];
    }

    public function datasource(): Builder
    {
        return Insentif::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
                   ->add('id')
                   ->add('npp_insentif')
                   ->add('nama_pegawai')
                   ->add('status_pegawai')
                   ->add('no_hp')
                   ->add('email')
                   ->add('level_insentif')
                   ->add('penempatan')
                   ->add('jabatan')
                   ->add('unit')
                   ->add('nominal_max_insentif_kinerja')
                   ->add('kinerja_keuangan_perusahaan')
                   ->add('nilai_kpi')
                   ->add('insentif_kinerja')
                   ->add('pembulatan')
                   ->add('diterimakan')
                   ->add('insentif_periode_bulan', fn($insentif)    => Bulan::from($insentif->insentif_periode_bulan)->labels())
                   ->add('insentif_pembayaran_bulan', fn($insentif) => Bulan::from($insentif->insentif_pembayaran_bulan)->labels())
                   ->add('insentif_tahun')
                   ->add('has_blast')
                   ->add('has_blast_label', function ($insentif) {
                       return $insentif->has_blast ? 'Iya' : 'Belum';
                   })
                   ->add('status_blast')
                   ->add('status_blast_label', function ($insentif) {
                       return $insentif->status_blast ? 'Terkirim' : 'Belum';
                   })
                   ->add('created_at')
                   ->add('updated_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->hidden(isHidden: true, isForceHidden: true)
                ->visibleInExport(true),
            Column::make('Tahun', 'insentif_tahun')
                ->sortable()
                ->searchable(),
            Column::make('Periode', 'insentif_periode_bulan')
                ->sortable(),
            Column::make('Pembayaran', 'insentif_pembayaran_bulan')
                ->sortable(),
            Column::make('Npp', 'npp_insentif')
                ->sortable()
                ->searchable(),
            Column::make('Nama', 'nama_pegawai')
                ->sortable()
                ->searchable(),
            Column::make('Status', 'status_pegawai')
                ->sortable(),
            Column::make('No hp', 'no_hp'),
            Column::make('Email', 'email'),
            Column::make('Level', 'level_insentif')
                ->sortable(),
            Column::make('Penempatan', 'penempatan')
                ->sortable(),
            Column::make('Jabatan', 'jabatan')
                ->sortable(),
            Column::make('Unit', 'unit')
                ->sortable()
                ->searchable(),
            Column::make('Nominal max insentif kinerja', 'nominal_max_insentif_kinerja')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Kinerja keuangan perusahaan', 'kinerja_keuangan_perusahaan')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Nilai kpi', 'nilai_kpi')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Insentif kinerja', 'insentif_kinerja')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Pembulatan', 'pembulatan')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Diterimakan', 'diterimakan')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Blast', 'has_blast')
                ->sortable(),
            Column::make('Terkirim', 'status_blast')
                ->sortable()
                ->visibleInExport(false),
            Column::make('dibuat', 'created_at')
                ->hidden(isHidden: true)
                ->sortable()
                ->visibleInExport(false),
            Column::make('diperbarui', 'updated_at')
                ->hidden(isHidden: true)
                ->sortable(),
            Column::action('Aksi')
                ->visibleInExport(false),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('npp_insentif')->placeholder('cari npp'),
            Filter::inputText('nama_pegawai')->placeholder('cari nama'),
            Filter::enumSelect('insentif_periode_bulan', 'insentif_periode_bulan')
                ->dataSource(Bulan::cases())
                ->optionLabel('insentif_periode_bulan'),
            Filter::enumSelect('insentif_pembayaran_bulan', 'insentif_pembayaran_bulan')
                ->dataSource(Bulan::cases())
                ->optionLabel('insentif_pembayaran_bulan'),
            FIlter::boolean('has_blast', 'has_blast')
                ->label('Iya', 'Belum'),
            FIlter::boolean('status_blast', 'status_blast')
                ->label('Terkirim', 'Belum'),
        ];
    }

    public function actions(Insentif $row): array
    {
        return [
            Button::add('hapus')
                ->slot('<x-cui-cil-trash class="w-4 h-4" />')
                ->id()
                ->tooltip('hapus')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('hapus', ['rowId' => $row->id]),
            Button::add('pulihkan')
                ->slot('<x-cui-cil-data-transfer-up class="w-4 h-4" />')
                ->id()
                ->tooltip('pulihkan')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('pulihkan', ['rowId' => $row->id]),
            Button::add('permanen-delete')
                ->slot('<x-cui-cil-delete class="w-4 h-4" />')
                ->tooltip('permanent hapus')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('permanenDelete', ['rowId' => $row->id]),
            Button::add('blast')
                ->slot('<x-cui-cib-whatsapp class="w-4 h-4" />')
                ->tooltip('Blast Ke Wa')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('infoBlast', ['rowId' => $row->id]),
            Button::add('repeat')
                ->slot('<x-cui-cib-whatsapp class="w-4 h-4" />')
                ->tooltip('Ulangi Blast Ke Wa')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('infoBlast', ['rowId' => $row->id]),
        ];
    }

    #[On('bulkBlastWa.{tableName}')]
    public function bulkBlastWa(): void
    {
        try {
            if ($this->checkboxValues) {
                $cariInsentif = Insentif::whereIn('id', Arr::flatten($this->checkboxValues))->get();
                foreach ($cariInsentif as $insentif) {
                    $this->dispatch('infoBulkBlast', rowId: $insentif->id);
                    sleep(16);
                }

                $this->js('window.pgBulkActions.clearAll()');
            }
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Insentif', description: $th->getMessage());
        }
    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        try {
            if ($this->checkboxValues) {
                $insentif = Insentif::whereIn('id', Arr::flatten($this->checkboxValues));
                $insentif->delete();
                $this->js('window.pgBulkActions.clearAll()');
            }
            $this->dispatch('notifikasi', icon: 'info', title: 'Insentif', description: 'data berhasil dihapus!.');
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Insentif', description: $th->getMessage());
        }
    }

    public function actionRules($row): array
    {
        return [
            Rule::button('hapus')
                ->when(fn(Insentif $insentif) => $insentif->trashed() == true || $insentif->has_blast == true)
                ->hide(),
            Rule::button('bulk-delete')
                ->when(fn(Insentif $insentif) => $insentif->trashed() == false)
                ->hide(),
            Rule::button('pulihkan')
                ->when(fn(Insentif $insentif) => $insentif->trashed() == false)
                ->hide(),
            Rule::button('permanen-delete')
                ->when(fn(Insentif $insentif) => $insentif->trashed() == false)
                ->hide(),
            Rule::button('blast')
                ->when(fn(Insentif $insentif) => $insentif->trashed() == true || $insentif->has_blast == true)
                ->hide(),
            Rule::button('repeat')
                ->when(fn(Insentif $insentif) => $insentif->has_blast == false || $insentif->status_blast == false)
                ->hide(),
            Rule::checkbox()
                ->when(fn(Insentif $insentif) => $insentif->trashed() == true)
                ->hide(),
        ];
    }
}
