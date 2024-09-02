<?php

namespace App\Imports;

use App\Models\Personalia;
use Maatwebsite\Excel\Concerns\ToModel;

class PersonaliaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Personalia([
        ]);
    }
}
