<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insentif extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payroll_insentif';

    protected $fillable = [
        'npp_insentif',
        'nama_pegawai',
        'status_pegawai',
        'no_hp',
        'email',
        'level_insentif',
        'penempatan',
        'jabatan',
        'unit',
        'nominal_max_insentif_kinerja',
        'kinerja_keuangan_perusahaan',
        'nilai_kpi',
        'insentif_kinerja',
        'pembulatan',
        'diterimakan',
        'insentif_periode_bulan',
        'insentif_pembayaran_bulan',
        'insentif_tahun',
        'has_blast',
        'status_blast'
    ];
}
