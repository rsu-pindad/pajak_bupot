<?php

namespace App\Imports\Payroll;

use App\Imports\Payroll\KehadiranImport;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SelectSheetImport implements WithMultipleSheets
{
    use WithConditionalSheets;

    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function conditionalSheets(): array
    {
        return [
            'tj kehadiran' => new KehadiranImport(5, $this->bulan, $this->tahun),
        ];
    }
}
