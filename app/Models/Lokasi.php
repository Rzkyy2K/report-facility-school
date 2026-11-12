<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nama_ruangan
 * @property string|null $gedung
 * @property int|null $lantai
 * @property-read Collection<int, Barang> $barang
 * @property-read Collection<int, Laporan> $laporan
 */
#[Fillable(['nama_ruangan', 'gedung', 'lantai'])]
class Lokasi extends Model
{
    protected $table = 'lokasi';

    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'lantai' => 'integer',
        ];
    }

    /**
     * @return HasMany<Barang, $this>
     */
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'lokasi_id');
    }

    /**
     * @return HasMany<Laporan, $this>
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'lokasi_id');
    }
}
