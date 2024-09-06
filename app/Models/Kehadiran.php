<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class Kehadiran extends Model
{
    use HasFactory, SoftDeletes;

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
        'jumlah_diterimakan',
        'kehadiran_bulan',
        'kehadiran_tahun',
        'has_blast',
        'status_blast'
    ];

    protected $casts = [
        'npp_kehadiran'       => 'string',
        'nama_pegawai'        => 'string',
        'tunjangan_kehadiran' => 'float',
        'jumlah_hari_kerja'   => 'integer',
        'jumlah_jam_terbuang' => 'integer',
        'jumlah_cuti'         => 'integer',
        'potongan_absensi'    => 'float',
        'jumlah_pendapatan'   => 'float',
        'jumlah_pembulatan'   => 'float',
        'jumlah_diterimakan'  => 'float',
        'has_blast'           => 'boolean',
        'status_blast'        => 'boolean',
    ];

    protected static function booted(): void
    {
        static::created(fn(Kehadiran $kehadiran) => self::clearCache());
        static::updated(fn(Kehadiran $kehadiran) => self::clearCache());
        static::deleted(fn(Kehadiran $kehadiran) => self::clearCache());
    }

    private static function clearCache(): void
    {
        // Clear the PowerGrid cache tag
        Cache::tags(['payroll_kehadiran_table_' . Auth::id()])->flush();
    }
}
