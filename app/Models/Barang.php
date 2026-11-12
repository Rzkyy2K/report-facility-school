<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $lokasi_id
 * @property string|null $kode_barang
 * @property string $nama_barang
 * @property string|null $kategori
 * @property-read Lokasi|null $lokasi
 * @property-read Collection<int, Laporan> $laporan
 */
#[Fillable(['lokasi_id', 'kode_barang', 'nama_barang', 'kategori'])]
class Barang extends Model
{
    protected $table = 'barang';

    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'lokasi_id' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Lokasi, $this>
     */
    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    /**
     * @return HasMany<Laporan, $this>
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'barang_id');
    }
}
