<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'payroll_kehadiran';

    protected $fillable = [
        'npp_kehadiran',
        'nama_pegawai',
        'tunjangan_kehadiran',
        'jumlah_hari_kerja',
        'jumlah_jam_terbuang',
        'jumlah_cuti',
        'potongan_absensi',
        'jumlah_pendapatan',
        'jumlah_pembulatan',
        'jumlah_diterimakan'
    ];

    protected $casts = [
        'npp_kehadiran' => 'string',
        'nama_pegawai' => 'string',
        'tunjangan_kehadiran' => 'float',
        'jumlah_hari_kerja' => 'integer',
        'jumlah_jam_terbuang' => 'integer',
        'jumlah_cuti' => 'integer',
        'potongan_absensi' => 'float',
        'jumlah_pendapatan' => 'float',
        'jumlah_pembulatan' => 'float',
        'jumlah_diterimakan' => 'float',
    ];

}
