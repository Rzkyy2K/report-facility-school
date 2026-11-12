<?php

namespace App\Concerns;

use App\Models\Pengguna;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

trait ProfileValidationRules
{
    /**
     * Get the validation rules used to validate user profiles.
     *
     * @return array<string, array<int, Unique|ValidationRule|array<mixed>|string>>
     */
    protected function profileRules(?int $userId = null): array
    {
        return [
            'nama_lengkap' => $this->namaLengkapRules(),
            'nomor_induk' => $this->nomorIndukRules($userId),
            'email' => $this->emailRules($userId),
            'no_telepon' => $this->noTeleponRules(),
        ];
    }

    /**
     * Get the validation rules used to validate user full names.
     *
     * @return array<int, Unique|ValidationRule|array<mixed>|string>
     */
    protected function namaLengkapRules(): array
    {
        return ['required', 'string', 'max:100'];
    }

    /**
     * Get the validation rules used to validate student/employee ID numbers.
     *
     * @return array<int, Unique|ValidationRule|array<mixed>|string>
     */
    protected function nomorIndukRules(?int $userId = null): array
    {
        return [
            'nullable',
            'string',
            'max:30',
            $userId === null
                ? Rule::unique(Pengguna::class, 'nomor_induk')
                : Rule::unique(Pengguna::class, 'nomor_induk')->ignore($userId),
        ];
    }

    /**
     * Get the validation rules used to validate user emails.
     *
     * @return array<int, Unique|ValidationRule|array<mixed>|string>
     */
    protected function emailRules(?int $userId = null): array
    {
        return [
            'required',
            'string',
            'email',
            'max:100',
            $userId === null
                ? Rule::unique(Pengguna::class, 'email')
                : Rule::unique(Pengguna::class, 'email')->ignore($userId),
        ];
    }

    /**
     * Get the validation rules used to validate user phone numbers.
     *
     * @return array<int, Unique|ValidationRule|array<mixed>|string>
     */
    protected function noTeleponRules(): array
    {
        return ['nullable', 'string', 'max:20'];
    }
}
