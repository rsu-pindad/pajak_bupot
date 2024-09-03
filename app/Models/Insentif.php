<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insentif extends Model
{
    use HasFactory;

    protected $table = 'payroll_insentif';

    protected $fillable = [
        'npp_insentif',
        'level_insentif',
        'penempatan',
        'jabatan',
        'unit',
        'nominal_max_insentif_kinerja',
        'kinerja_keuangan_perusahaan',
        'nilai_kpi',
        'insentif_kinerja',
        'pembulatan',
        'diterimakan'
    ];
}
