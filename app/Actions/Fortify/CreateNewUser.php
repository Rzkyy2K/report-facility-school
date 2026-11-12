<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string|null>  $input
     */
    public function create(array $input): Pengguna
    {
        $validated = Validator::make($input, [
            ...$this->profileRules(),
            'role' => ['nullable', Rule::in(['siswa', 'guru'])],
            'password' => $this->passwordRules(),
        ])->validate();

        $nomorInduk = isset($validated['nomor_induk']) && $validated['nomor_induk'] !== ''
            ? $validated['nomor_induk']
            : null;
        $noTelepon = isset($validated['no_telepon']) && $validated['no_telepon'] !== ''
            ? $validated['no_telepon']
            : null;

        return Pengguna::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nomor_induk' => $nomorInduk,
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'] ?? 'siswa',
            'no_telepon' => $noTelepon,
        ]);
    }
}
