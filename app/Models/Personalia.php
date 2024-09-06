<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personalia extends Model
{
    use HasFactory, SoftDeletes;

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
