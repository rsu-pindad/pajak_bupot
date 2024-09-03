<?php

namespace App\Imports;

use App\Models\Personalia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PersonaliaImport implements ToModel, WithHeadingRow, WithUpserts
{
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
            'npp' => $row['npp'],
            'nik' => $row['nik'],
            'npwp' => $row['npwp'],
            'status_ptkp' => $row['status_ptkp'],
            'email' => $row['email'],
            'no_hp' => $row['no_hp']
        ]);
    }
}
