<?php

namespace App\Enums;

enum Bulan: string
{
    // case ALL = '0';
    case JANUARI   = '01';
    case FEBRUARI  = '02';
    case MARET     = '03';
    case APRIL     = '04';
    case MEI       = '05';
    case JUNI      = '06';
    case JULI      = '07';
    case AGUSTUS   = '08';
    case SEPTEMBER = '09';
    case OKTOBER   = '10';
    case NOVEMBER  = '11';
    case DESEMBER  = '12';

    public function labels(): string
    {
        return match ($this) {
            // self::ALL => 'Semua',
            self::JANUARI   => 'JANUARI',
            self::FEBRUARI  => 'FEBRUARI',
            self::MARET     => 'MARET',
            self::APRIL     => 'APRIL',
            self::MEI       => 'MEI',
            self::JUNI      => 'JUNI',
            self::JULI      => 'JULI',
            self::AGUSTUS   => 'AGUSTUS',
            self::SEPTEMBER => 'SEPTEMBER',
            self::OKTOBER   => 'OKTOBER',
            self::NOVEMBER  => 'NOVEMBER',
            self::DESEMBER  => 'DESEMBER',
        };
    }

    public function labelPowergridFilter(): string
    {
        return $this->labels();
    }
}
