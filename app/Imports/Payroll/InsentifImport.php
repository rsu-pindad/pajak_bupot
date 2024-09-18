<?php

namespace App\Imports\Payroll;

use App\Models\Insentif;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InsentifImport implements ToModel, WithChunkReading, SkipsEmptyRows, WithCalculatedFormulas, WithStartRow, WithSkipDuplicates
{
    use RemembersRowNumber, Importable;

    protected $heading;
    protected $bulan_periode;
    protected $bulan_pembayaran;
    protected $tahun;

    public function __construct(int $heading, $bulan_periode, $bulan_pembayaran, $tahun)
    {
        $this->heading          = $heading;
        $this->bulan_periode    = $bulan_periode;
        $this->bulan_pembayaran = $bulan_pembayaran;
        $this->tahun            = $tahun;
    }

    public function startRow(): int
    {
        return 5;
    }

    // public function mapping(): array
    // {
    //     return [
    //         'npp_baru'                     => 'C5',
    //         'nama'                         => 'B5',
    //         'status_karyawan'              => 'L5',
    //         'handphone_karyawan'           => 'V5',
    //         'email_karyawan'               => 'U5',
    //         'level'                        => 'K5',
    //         'penempatan'                   => 'J5',
    //         'jabatan'                      => 'L5',
    //         'unit'                         => 'M5',
    //         'nominal_max_insentif_kinerja' => 'N5',
    //         'kinerja_keuangan_perusahaan'  => 'O5',
    //         'nilai_scor_kpi'               => 'P5',
    //         'insentif_kinerja'             => 'Q5',
    //         'pembulatan'                   => 'R5',
    //         'diterimakan'                  => 'S5',
    //         // 'insentif_periode_bulan'       => $this->bulan_periode,
    //         // 'insentif_pembayaran_bulan'    => $this->bulan_pembayaran,
    //         // 'insentif_tahun'               => $this->tahun,
    //     ];
    // }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // $currentRowNumber = $this->getRowNumber();

        // dd($row);

        return new Insentif([
            'nama_pegawai'                 => $row['1'],
            'npp_insentif'                 => $row['2'],
            'penempatan'                   => $row['9'],
            'level_insentif'               => $row['8'],
            'jabatan'                      => $row['11'],
            'unit'                         => $row['12'],
            'nominal_max_insentif_kinerja' => $row['13'],
            'kinerja_keuangan_perusahaan'  => $row['14'],
            'nilai_kpi'                    => $row['15'],
            'insentif_kinerja'             => $row['16'],
            'pembulatan'                   => $row['17'],
            'diterimakan'                  => $row['18'],
            'email'                        => $row['20'],
            'no_hp'                        => $row['21'],
            'status_pegawai'               => $row['19'],
            'insentif_periode_bulan'       => $this->bulan_periode,
            'insentif_pembayaran_bulan'    => $this->bulan_pembayaran,
            'insentif_tahun'               => $this->tahun,
            // 'npp_insentif'                 => $row['npp_baru'],
            // 'nama_pegawai'                 => $row['nama'],
            // 'status_pegawai'               => $row['status_karyawan'],
            // 'no_hp'                        => $row['handphone_karyawan'],
            // 'email'                        => $row['email_karyawan'],
            // 'level_insentif'               => $row['level'],
            // 'penempatan'                   => $row['penempatan'],
            // 'jabatan'                      => $row['jabatan'],
            // 'unit'                         => $row['unit'],
            // 'nominal_max_insentif_kinerja' => $row['nominal_max_insentif_kinerja'] == '#N/A' ? 0 : $row['nominal_max_insentif_kinerja'],
            // 'kinerja_keuangan_perusahaan'  => $row['kinerja_keuangan_perusahaan'] == '#N/A' ? 0 : $row['kinerja_keuangan_perusahaan'],
            // 'nilai_kpi'                    => $row['nilai_scor_kpi'],
            // 'insentif_kinerja'             => $row['insentif_kinerja'] == '#N/A' ? 0 : $row['insentif_kinerja'],
            // 'pembulatan'                   => $row['pembulatan'] == '#N/A' ? 0 : $row['pembulatan'],
            // 'diterimakan'                  => $row['diterimakan'] == '#N/A' ? 0 : $row['diterimakan'],
            // 'insentif_periode_bulan'       => $this->bulan_periode,
            // 'insentif_pembayaran_bulan'    => $this->bulan_pembayaran,
            // 'insentif_tahun'               => $this->tahun,
        ]);
    }

    // public function headingRow(): int
    // {
    //     return $this->heading;
    // }

    public function chunkSize(): int
    {
        return 100;
    }

    public function limit(): int
    {
        return 318;
    }
}
