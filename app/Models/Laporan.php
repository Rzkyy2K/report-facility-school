<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $pengguna_id
 * @property int $lokasi_id
 * @property int|null $barang_id
 * @property string $nama_barang
 * @property string $deskripsi_rusak
 * @property string $foto_kerusakan
 * @property string|null $tingkat_keparahan
 * @property string|null $prioritas
 * @property string|null $status
 * @property Carbon|null $tanggal_lapor
 * @property Carbon|null $updated_at
 * @property-read Pengguna $pengguna
 * @property-read Lokasi $lokasi
 * @property-read Barang|null $barang
 * @property-read Collection<int, Perbaikan> $perbaikan
 * @property-read Collection<int, Persetujuan> $persetujuan
 */
#[Fillable([
    'pengguna_id',
    'lokasi_id',
    'barang_id',
    'nama_barang',
    'deskripsi_rusak',
    'foto_kerusakan',
    'tingkat_keparahan',
    'prioritas',
    'status',
])]
class Laporan extends Model
{
    protected $table = 'laporan';

    public const CREATED_AT = 'tanggal_lapor';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pengguna_id' => 'integer',
            'lokasi_id' => 'integer',
            'barang_id' => 'integer',
            'tanggal_lapor' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Pengguna, $this>
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    /**
     * @return BelongsTo<Lokasi, $this>
     */
    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    /**
     * @return BelongsTo<Barang, $this>
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * @return HasMany<Perbaikan, $this>
     */
    public function perbaikan(): HasMany
    {
        return $this->hasMany(Perbaikan::class, 'laporan_id');
    }

    /**
     * @return HasMany<Persetujuan, $this>
     */
    public function persetujuan(): HasMany
    {
        return $this->hasMany(Persetujuan::class, 'laporan_id');
    }
}
