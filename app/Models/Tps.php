<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tps extends Model
{
    use HasFactory;

    protected $table = 'tps';

    protected $fillable = [
        'nomor_tps',
        'nama_lokasi',
        'dusun',
        'kuota_pemilih',
        'keterangan',
    ];

    /**
     * Relasi One-to-Many ke Voter
     */
    public function voters(): HasMany
    {
        return $this->hasMany(Voter::class, 'tps_id');
    }
}
