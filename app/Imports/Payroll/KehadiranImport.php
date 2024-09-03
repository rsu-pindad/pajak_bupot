<?php

namespace App\Imports\Payroll;

use App\Models\Kehadiran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class KehadiranImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{

    protected $heading;

    public function __construct(int $heading)
    {
        $this->heading = $heading;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {

        // HeadingRowFormatter::default('none');

        return new Kehadiran([
            'npp_kehadiran' => $row[2],
            'nama_pegawai' => $row[3],
            'tunjangan_kehadiran' => $row[4],
            'jumlah_hari_kerja' => $row[5],
            'jumlah_jam_terbuang' => $row[6],
            'jumlah_cuti' => $row[7],
            'potongan_absensi' => $row[8],
            'jumlah_pendapatan' => $row[9],
            'jumlah_pembulatan' => $row[10],
            'jumlah_diterimakan' => $row[11],
        ]);
    }

    public function headingRow(): int
    {
        return $this->heading;
    }
}
