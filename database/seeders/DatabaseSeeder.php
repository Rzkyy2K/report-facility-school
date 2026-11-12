<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Lokasi;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $akunAwal = [
            [
                'nama_lengkap' => 'Ahmad Siswa',
                'nomor_induk' => '2026001',
                'email' => 'siswa@sekolah.test',
                'password' => 'password',
                'role' => 'siswa',
                'no_telepon' => '081234567001',
            ],
            [
                'nama_lengkap' => 'Budi Santoso, S.Pd',
                'nomor_induk' => '198501012010011001',
                'email' => 'guru@sekolah.test',
                'password' => 'password',
                'role' => 'guru',
                'no_telepon' => '081234567002',
            ],
            [
                'nama_lengkap' => 'Siti Aminah (Sarpras)',
                'nomor_induk' => '198803152014022002',
                'email' => 'sarana@sekolah.test',
                'password' => 'password',
                'role' => 'sarana',
                'no_telepon' => '081234567003',
            ],
            [
                'nama_lengkap' => 'Drs. Hendra Wijaya, M.Pd',
                'nomor_induk' => '197506102000031001',
                'email' => 'kepsek@sekolah.test',
                'password' => 'password',
                'role' => 'kepala_sekolah',
                'no_telepon' => '081234567004',
            ],
            [
                'nama_lengkap' => 'Dedi Kurniawan (Teknisi)',
                'nomor_induk' => '199209202019031005',
                'email' => 'teknisi@sekolah.test',
                'password' => 'password',
                'role' => 'teknisi',
                'no_telepon' => '081234567005',
            ],
        ];

        foreach ($akunAwal as $akun) {
            Pengguna::firstOrCreate(
                ['email' => $akun['email']],
                $akun,
            );
        }

        $labKomputer = Lokasi::firstOrCreate([
            'nama_ruangan' => 'Lab Komputer 1',
            'gedung' => 'Gedung A',
            'lantai' => 2,
        ]);

        $kelasX = Lokasi::firstOrCreate([
            'nama_ruangan' => 'Kelas X IPA 1',
            'gedung' => 'Gedung B',
            'lantai' => 1,
        ]);

        $perpustakaan = Lokasi::firstOrCreate([
            'nama_ruangan' => 'Perpustakaan',
            'gedung' => 'Gedung Utama',
            'lantai' => 1,
        ]);

        $barangAwal = [
            [
                'kode_barang' => 'BRG-LAB1-001',
                'lokasi_id' => $labKomputer->id,
                'nama_barang' => 'Proyektor Epson EB-X500',
                'kategori' => 'Elektronik',
            ],
            [
                'kode_barang' => 'BRG-LAB1-002',
                'lokasi_id' => $labKomputer->id,
                'nama_barang' => 'AC Split Daikin 2 PK',
                'kategori' => 'Pendingin Ruangan',
            ],
            [
                'kode_barang' => 'BRG-XIPA1-001',
                'lokasi_id' => $kelasX->id,
                'nama_barang' => 'Meja Siswa Kayu',
                'kategori' => 'Furnitur',
            ],
            [
                'kode_barang' => 'BRG-PERPUS-001',
                'lokasi_id' => $perpustakaan->id,
                'nama_barang' => 'Rak Buku Besi 5 Susun',
                'kategori' => 'Furnitur',
            ],
        ];

        foreach ($barangAwal as $barang) {
            Barang::firstOrCreate(
                ['kode_barang' => $barang['kode_barang']],
                $barang,
            );
        }
    }
}
