<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalIbadah extends Model
{
    protected $table = 'jadwal_ibadah';

    protected $fillable = [
        'tanggal',
        'waktu',
        'tempat',
        'petugas_ibadah',
        'liturgi_text',
        'liturgi_file',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}