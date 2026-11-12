<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $nama_lengkap
 * @property string|null $nomor_induk
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $no_telepon
 * @property Carbon|null $created_at
 * @property-read Collection<int, Laporan> $laporan
 * @property-read Collection<int, Perbaikan> $perbaikan
 * @property-read Collection<int, Persetujuan> $persetujuan
 */
#[Fillable([
    'nama_lengkap',
    'nomor_induk',
    'email',
    'password',
    'role',
    'no_telepon',
])]
#[Hidden(['password'])]
class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    public const UPDATED_AT = null;

    /**
     * Tabel pengguna tidak memiliki kolom remember_token.
     *
     * @var string
     */
    protected $rememberTokenName = '';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'created_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<Laporan, $this>
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'pengguna_id');
    }

    /**
     * @return HasMany<Perbaikan, $this>
     */
    public function perbaikan(): HasMany
    {
        return $this->hasMany(Perbaikan::class, 'pengguna_id');
    }

    /**
     * @return HasMany<Persetujuan, $this>
     */
    public function persetujuan(): HasMany
    {
        return $this->hasMany(Persetujuan::class, 'pengguna_id');
    }
}
