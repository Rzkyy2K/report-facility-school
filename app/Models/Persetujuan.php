<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $laporan_id
 * @property int $pengguna_id
 * @property string $status_persetujuan
 * @property string|null $catatan_pimpinan
 * @property string|null $estimasi_biaya
 * @property Carbon|null $tanggal_persetujuan
 * @property-read Laporan $laporan
 * @property-read Pengguna $pengguna
 */
#[Fillable([
    'laporan_id',
    'pengguna_id',
    'status_persetujuan',
    'catatan_pimpinan',
    'estimasi_biaya',
])]
class Persetujuan extends Model
{
    protected $table = 'persetujuan';

    public const CREATED_AT = 'tanggal_persetujuan';

    public const UPDATED_AT = null;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'laporan_id' => 'integer',
            'pengguna_id' => 'integer',
            'estimasi_biaya' => 'decimal:2',
            'tanggal_persetujuan' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Laporan, $this>
     */
    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    /**
     * @return BelongsTo<Pengguna, $this>
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
