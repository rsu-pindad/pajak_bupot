<?php

namespace App\Livewire\Power\Payroll;

use App\Enums\Bulan;
use App\Models\Kehadiran;
use App\Models\Personalia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
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

final class KehadiranTabel extends PowerGridComponent
{
    use WithExport;

    #[Locked]
    public string $tableName = 'payroll_kehadiran';

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

    // protected function getListeners() : array
    // {
    //     return [
    //         'pg:softDeletes-'.$this->tableName => '',
    //     ];
    // }

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

        // $this->persist(
        //     tableItems: ['columns', 'filters', 'sorting'],
        //     prefix: 'payroll_kehadiran_table_' . Auth::id(),
        // );
        $this->strRandom = Str::random(4);

        return [
            Exportable::make('export_payroll_kehadiran_' . Carbon::now()->format('Y-M-d_') . $this->strRandom)
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
                ->csvSeparator(',')
                ->csvDelimiter('"'),
            // ->queues(3)
            Header::make()
                ->showToggleColumns()
                ->withoutLoading()
                ->showSoftDeletes(showMessage: false),
            Footer::make()
                ->pageName('kehadiranPage')
                // ->showRecordCount(mode: 'full'), 
                ->showPerPage( perPageValues: [25, 50, 100]),
            // ->showRecordCount(),
            Responsive::make()
                ->fixedColumns('nama_pegawai', 'npp_kehadiran', 'has_blast_label', 'status_blast_label', Responsive::ACTIONS_COLUMN_NAME),
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
                   ->add('no_hp')
                   ->add('email')
                   ->add('tunjangan_kehadiran')
                   ->add('jumlah_hari_kerja')
                   ->add('jumlah_jam_terbuang')
                   ->add('jumlah_cuti')
                   ->add('potongan_absensi')
                   ->add('jumlah_pendapatan')
                   ->add('jumlah_pembulatan')
                   ->add('jumlah_diterimakan')
                   ->add('kehadiran_periode_bulan', fn($kehadiran)    => Bulan::from($kehadiran->kehadiran_periode_bulan)->labels())
                   ->add('kehadiran_pembayaran_bulan', fn($kehadiran) => Bulan::from($kehadiran->kehadiran_pembayaran_bulan)->labels())
                   ->add('kehadiran_tahun')
                   ->add('has_blast')
                   ->add('has_blast_label', function ($kehadiran) {
                       return $kehadiran->has_blast ? 'Iya' : 'Belum';
                   })
                   ->add('status_blast')
                   ->add('status_blast_label', function ($kehadiran) {
                       return $kehadiran->status_blast ? 'Terkirim' : 'Belum';
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
            Column::make('No', 'id')
                ->index()
                ->sortable(),
            Column::make('Tahun', 'kehadiran_tahun')
                ->sortable(),
            Column::make('Periode', 'kehadiran_periode_bulan')
                ->sortable(),
            Column::make('Pembayaran', 'kehadiran_pembayaran_bulan')
                ->sortable(),
            Column::make('Npp', 'npp_kehadiran')
                ->sortable()
                ->searchable(),
            Column::make('Nama', 'nama_pegawai')
                ->sortable()
                ->searchable(),
            Column::make('No Hp', 'no_hp'),
            Column::make('Email', 'email'),
            Column::make('Tunjangan', 'tunjangan_kehadiran')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Jumlah hari kerja', 'jumlah_hari_kerja')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Jumlah jam terbuang', 'jumlah_jam_terbuang')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Jumlah cuti', 'jumlah_cuti')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Potongan absensi', 'potongan_absensi')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Jumlah pendapatan', 'jumlah_pendapatan')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Jumlah pembulatan', 'jumlah_pembulatan')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Jumlah diterimakan', 'jumlah_diterimakan')
                ->bodyAttribute('text-right')
                ->sortable(),
            Column::make('Blast', 'has_blast_label', 'has_blast')
                ->sortable()
                ->visibleInExport(false),
            Column::make('Terkirim', 'status_blast_label', 'status_blast')
                ->sortable()
                ->visibleInExport(false),
            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->sortable(),
            Column::make('dibuat', 'created_at')
                ->hidden(isHidden: true)
                ->sortable()
                ->visibleInExport(false),
            Column::make('diperbarui', 'updated_at')
                ->hidden(isHidden: true)
                ->sortable()
                ->visibleInExport(false),
            Column::action('Aksi')
                ->visibleInExport(false),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('npp_kehadiran')->placeholder('cari npp'),
            Filter::inputText('nama_pegawai')->placeholder('cari nama'),
            Filter::enumSelect('kehadiran_periode_bulan', 'kehadiran_periode_bulan')
                ->dataSource(Bulan::cases())
                ->optionLabel('kehadiran_periode_bulan'),
            Filter::enumSelect('kehadiran_pembayaran_bulan', 'kehadiran_pembayaran_bulan')
                ->dataSource(Bulan::cases())
                ->optionLabel('kehadiran_pembayaran_bulan'),
            FIlter::boolean('has_blast', 'has_blast')
                ->label('Iya', 'Belum'),
            FIlter::boolean('status_blast', 'status_blast')
                ->label('Terkirim', 'Belum'),
        ];
    }

    public function actions(Kehadiran $row): array
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
        // $cariPersonalia = [];
        try {
            if ($this->checkboxValues) {
                $cariKehadiran = Kehadiran::whereIn('id', Arr::flatten($this->checkboxValues))->get();
                // $cariPersonalia = Personalia::whereIn('npp', $cariKehadiran->npp_kehadiran);
                // dd($cariKehadiran);
                // dd($cariKehadiran);
                foreach ($cariKehadiran as $kehadiran) {
                    // dd($kehadiran->npp_kehadiran);
                    // $cariPersonalia = Personalia::where('npp', $kehadiran->npp_kehadiran)->first();
                    $this->dispatch('infoBulkBlast', rowId: $kehadiran->id);
                    sleep(16);
                }
                // $cariKehadiran  = Kehadiran::find($rowId)->first();
                // $sendBlast      = json_decode($this->sendBlast($cariKehadiran, $cariPersonalia), true);
                // $status = $sendBlast['status'];
                // $detail = $sendBlast['detail'];
                // if ($status == true) {
                //     // $cariKehadiran->has_blast    = true;
                //     // $cariKehadiran->status_blast = true;
                //     // $cariKehadiran->save();
                // }

                $this->js('window.pgBulkActions.clearAll()');
            }
            // $this->dispatch('notifikasi',icon: 'error', title: 'Kehadiran',  description: $satuan);
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi',icon: 'error', title: 'Kehadiran',  description: $th->getMessage());
        }
    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        try {
            if ($this->checkboxValues) {
                $kehadiran = Kehadiran::whereIn('id', Arr::flatten($this->checkboxValues));
                $kehadiran->delete();
                $this->js('window.pgBulkActions.clearAll()');
            }
            $this->dispatch('notifikasi', icon: 'info', title: 'Kehadiran', description: 'data berhasil dihapus!.');
        } catch (\Throwable $th) {
            $this->dispatch('notifikasi', icon: 'error', title: 'Kehadiran', description: $th->getMessage());
        }
    }

    public function actionRules($row): array
    {
        return [
            Rule::button('hapus')
                ->when(fn(Kehadiran $kehadiran) => $kehadiran->trashed() == true || $kehadiran->has_blast == true)
                ->hide(),
            Rule::button('bulk-delete')
                ->when(fn(Kehadiran $kehadiran) => $kehadiran->trashed() == false)
                ->hide(),
            Rule::button('pulihkan')
                ->when(fn(Kehadiran $kehadiran) => $kehadiran->trashed() == false)
                ->hide(),
            Rule::button('permanen-delete')
                ->when(fn(Kehadiran $kehadiran) => $kehadiran->trashed() == false)
                ->hide(),
            Rule::button('blast')
                ->when(fn(Kehadiran $kehadiran) => $kehadiran->trashed() == true || $kehadiran->has_blast == true)
                ->hide(),
            Rule::button('repeat')
                ->when(fn(Kehadiran $kehadiran) => $kehadiran->has_blast == false || $kehadiran->status_blast == false)
                ->hide(),
            Rule::checkbox()
                ->when(fn(Kehadiran $kehadiran) => $kehadiran->trashed() == true)
                ->hide(),
        ];
    }
}
