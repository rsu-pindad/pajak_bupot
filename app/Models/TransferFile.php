<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class TransferFile extends Model
{
    // use HasFactory;

    protected $fillable = [
        'disk',
        'path',
        'size',
        'publish'
    ];

    protected $casts = [
        'disk' => 'string',
        'path' => 'string',
        'size' => 'integer',
        'publish' => 'boolean',
    ];

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }
}
