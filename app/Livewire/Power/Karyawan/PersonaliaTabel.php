<?php

namespace App\Livewire\Power\Karyawan;

use App\Models\Personalia;
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

final class PersonaliaTabel extends PowerGridComponent
{
    use WithExport;

    #[Locked]
    public string $tableName = 'personalias';

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
            // Button::add('bulk-delete-force')
            //     ->slot('<x-heroicons::outline.x-circle class="w-5 h-5" />(<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
            //     ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
            //     ->confirmPrompt('Anda yakin hapus data?, data akan terhapus dari database! masukan HAPUSDATA', 'HAPUSDATA')
            //     ->dispatch('bulkDeleteForce.' . $this->tableName, []),
        ];
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        $this->persist(
            tableItems: ['columns', 'filters', 'sorting'],
            prefix: 'personalia_table_' . Auth::id(),
        );
        $this->strRandom = Str::random(4);

        return [
            Exportable::make('export_personalia' . Carbon::now()->format('Y-M-d_') . $this->strRandom)
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
                ->csvSeparator(',')
                ->csvDelimiter('"'),
            // ->queues(3)
            Header::make()
                ->showToggleColumns()
                ->showSoftDeletes(showMessage: false),
            Footer::make()
                ->showPerPage(perPage: 5, perPageValues: [5, 25, 50, 100, 500])
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Personalia::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
                   ->add('id')
                   ->add('npp')
                   ->add('nik')
                   ->add('npwp')
                   ->add('status_ptkp')
                   ->add('email')
                   ->add('no_hp')
                   ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->hidden(isHidden: true, isForceHidden: true)
                ->visibleInExport(true),
            Column::make('Npp', 'npp')
                ->sortable()
                ->searchable(),
            Column::make('Nik', 'nik')
                ->sortable()
                ->searchable(),
            Column::make('Npwp', 'npwp')
                ->sortable()
                ->searchable(),
            Column::make('PTKP', 'status_ptkp')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),
            Column::make('Handphone', 'no_hp')
                ->sortable()
                ->searchable(),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),
            Column::action('Aksi')
                ->visibleInExport(false),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('npp')->placeholder('cari npp'),
            Filter::inputText('nik')->placeholder('cari nik'),
            Filter::inputText('npwp')->placeholder('cari npwp'),
            // Filter::datepicker('tanggal_perolehan'),
            // Filter::select('satuan_id_formatted', 'satuan_id')
            //     ->dataSource(Satuan::all())
            //     ->optionLabel('nama_satuan')
            //     ->optionValue('id'),
            // Filter::select('vendor_id_formatted', 'vendor_id')
            //     ->dataSource(Vendor::all())
            //     ->optionLabel('nama_vendor')
            //     ->optionValue('id'),
            // Filter::select('pivot_tipe_merek_id_format_tipe', 'pivot_tipe_merek_id')
            //     ->dataSource(Tipe::all())
            //     ->optionLabel('nama_tipe')
            //     ->optionValue('id'),
            // Filter::select('pivot_tipe_merek_id_format_merek', 'pivot_tipe_merek_id')
            //     ->dataSource(Merek::all())
            //     ->optionLabel('nama_merek')
            //     ->optionValue('id'),
            // Filter::select('unit_id_formatted', 'unit_id')
            //     ->dataSource(Unit::all())
            //     ->optionLabel('nama_unit')
            //     ->optionValue('id'),
        ];
    }

    public function actions(Personalia $row): array
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
        ];
    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        try {
            if ($this->checkboxValues) {
                $satuan = Personalia::whereIn('id', Arr::flatten($this->checkboxValues));
                $satuan->delete();
                $this->js('window.pgBulkActions.clearAll()');
            }
            $this->dispatch('notifikasi', title: 'Personalia', icon: 'info', description: 'Personalia berhasil dihapus!.');
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', title: 'Personalia', icon: 'error', description: $th->getMessage());
        }
    }

    public function actionRules($row): array
    {
        return [
            Rule::button('hapus')
                ->when(fn(Personalia $personalia) => $personalia->trashed() == true)
                ->hide(),
            Rule::button('bulk-delete')
                ->when(fn(Personalia $personalia) => $personalia->trashed() == false)
                ->hide(),
            Rule::button('pulihkan')
                ->when(fn(Personalia $personalia) => $personalia->trashed() == false)
                ->hide(),
            Rule::button('permanen-delete')
                ->when(fn(Personalia $personalia) => $personalia->trashed() == false)
                ->hide(),
            Rule::checkbox()
                ->when(fn(Personalia $personalia) => $personalia->trashed() == true)
                ->hide(),
        ];
    }
}
