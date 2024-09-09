<?php

namespace App\Imports\Payroll;

use App\Models\Kehadiran;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithStartRow;

// use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class KehadiranImport implements ToModel, WithHeadingRow, WithCalculatedFormulas, WithStartRow, WithChunkReading, WithSkipDuplicates, SkipsEmptyRows
{
    use RemembersRowNumber;

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
        return 7;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // HeadingRowFormatter::default('none');
        $currentRowNumber = $this->getRowNumber();

        return new Kehadiran([
            'npp_kehadiran'              => $row['n_p_k'],
            'nama_pegawai'               => $row['nama_pegawai'],
            'status_pegawai'             => $row['status_karyawan'],
            'tunjangan_kehadiran'        => $row['tunjangan_kehadiran'],
            'jumlah_hari_kerja'          => $row['jumlah_hari_kerja'],
            'jumlah_jam_terbuang'        => $row['jumlah_jam_terbuang'],
            'jumlah_cuti'                => $row['jumlah_cuti'],
            'potongan_absensi'           => $row['potongan_absensi'],
            'jumlah_pendapatan'          => $row['jumlah_pendapatan'],
            'jumlah_pembulatan'          => $row['jumlah_pembulatan'],
            'jumlah_diterimakan'         => $row['jumlah_diterimakan'],
            'kehadiran_periode_bulan'    => $this->bulan_periode,
            'kehadiran_pembayaran_bulan' => $this->bulan_pembayaran,
            'kehadiran_tahun'            => $this->tahun,
            'no_hp'                      => $row['handphone_karyawan'],
            'email'                      => $row['email_karyawan']
        ]);
    }

    public function headingRow(): int
    {
        return $this->heading;
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
