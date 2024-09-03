<?php

namespace App\Livewire\Power\Payroll;

use App\Models\Kehadiran;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class KehadiranTabel extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Kehadiran::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('npp_kehadiran')
            ->add('nama_pegawai')
            ->add('tunjangan_kehadiran')
            ->add('jumlah_hari_kerja')
            ->add('jumlah_jam_terbuang')
            ->add('jumlah_cuti')
            ->add('potongan_absensi')
            ->add('jumlah_pendapatan')
            ->add('jumlah_pembulatan')
            ->add('jumlah_diterimakan')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Npp kehadiran', 'npp_kehadiran')
                ->sortable()
                ->searchable(),

            Column::make('Nama pegawai', 'nama_pegawai')
                ->sortable()
                ->searchable(),

            Column::make('Tunjangan kehadiran', 'tunjangan_kehadiran')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah hari kerja', 'jumlah_hari_kerja')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah jam terbuang', 'jumlah_jam_terbuang')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah cuti', 'jumlah_cuti')
                ->sortable()
                ->searchable(),

            Column::make('Potongan absensi', 'potongan_absensi')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah pendapatan', 'jumlah_pendapatan')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah pembulatan', 'jumlah_pembulatan')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah diterimakan', 'jumlah_diterimakan')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Kehadiran $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
