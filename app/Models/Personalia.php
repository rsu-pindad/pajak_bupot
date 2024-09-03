<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personalia extends Model
{
    use HasFactory;

    protected $table = 'personalias';

    protected $fillable = [
        'npp',
        'nik',
        'npwp',
        'status_ptkp',
        'email',
        'no_hp'
    ];
}
