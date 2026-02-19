<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'user_id',
        'nama',
        'jenis',
        'tanggal_daftar',
        'foto',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}