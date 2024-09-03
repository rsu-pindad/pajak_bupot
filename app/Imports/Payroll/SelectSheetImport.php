<?php

namespace App\Imports\Payroll;

use App\Imports\Payroll\KehadiranImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

class SelectSheetImport implements WithMultipleSheets
{
    use WithConditionalSheets;

    // protected $heading;

    // public function __construct(int $heading)
    // {
    //     $this->heading = $heading;
    // }

    public function conditionalSheets() : array
    {
        return [
            'tj kehadiran' => new KehadiranImport(6),
        ];
    }
}
