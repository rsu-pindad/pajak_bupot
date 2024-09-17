<?php

namespace App\Imports\Karyawan;

use App\Models\Personalia;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

class PersonaliaImport implements ToModel, WithHeadingRow, WithUpserts, WithChunkReading, WithSkipDuplicates, SkipsEmptyRows
{
    use RemembersRowNumber;

    public function uniqueBy()
    {
        return 'nik';
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Personalia([
            'npp'         => $row['npp'],
            'nik'         => $row['nik'],
            'npwp'        => $row['npwp'],
            'status_ptkp' => $row['status_ptkp'],
            'email'       => $row['email'],
            'no_hp'       => $row['no_hp']
        ]);
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
