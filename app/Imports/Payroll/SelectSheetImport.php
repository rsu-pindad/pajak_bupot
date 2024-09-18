<?php

namespace App\Imports\Payroll;

use App\Imports\Payroll\InsentifImport;
use App\Imports\Payroll\KehadiranImport;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SelectSheetImport implements WithMultipleSheets
{
    use WithConditionalSheets;

    protected $bulan_periode;
    protected $bulan_pembayaran;
    protected $tahun;
    protected $mulai;
    protected $akhir;

    public function __construct($bulan_periode, $bulan_pembayaran, $tahun, $mulai, $akhir)
    {
        $this->bulan_periode    = $bulan_periode;
        $this->bulan_pembayaran = $bulan_pembayaran;
        $this->tahun            = $tahun;
        $this->mulai            = $mulai;
        $this->akhir            = $akhir;
    }

    public function conditionalSheets(): array
    {
        return [
            'tj kehadiran' => new KehadiranImport(5, $this->bulan_periode, $this->bulan_pembayaran, $this->tahun, $this->mulai, $this->akhir),
            'INSENTIF FIX' => new InsentifImport(4, $this->bulan_periode, $this->bulan_pembayaran, $this->tahun, $this->mulai, $this->akhir),
        ];
    }
}
