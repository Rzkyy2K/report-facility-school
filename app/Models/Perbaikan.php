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
 * @property Carbon $tanggal_mulai
 * @property Carbon|null $tanggal_selesai
 * @property string|null $foto_bukti_selesai
 * @property string|null $keterangan_tindakan
 * @property string|null $status_pekerjaan
 * @property-read Laporan $laporan
 * @property-read Pengguna $pengguna
 */
#[Fillable([
    'laporan_id',
    'pengguna_id',
    'tanggal_mulai',
    'tanggal_selesai',
    'foto_bukti_selesai',
    'keterangan_tindakan',
    'status_pekerjaan',
])]
class Perbaikan extends Model
{
    protected $table = 'perbaikan';

    public $timestamps = false;

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
            'tanggal_mulai' => 'datetime',
            'tanggal_selesai' => 'datetime',
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
