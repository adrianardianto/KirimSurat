<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Import this

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents; // Use the trait

    public function run(): void
    {
        // ... users and categories creation ...

        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // User
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Categories
        // Tipe Surat (Categories)
        Category::create([
            'name' => 'Surat Izin Tidak Masuk',
            'code' => 'izin',
            'format_code' => 'IZN',
            'description' => 'Digunakan untuk siswa yang berhalangan hadir.'
        ]);
        Category::create([
            'name' => 'Pengajuan Dispensasi',
            'code' => 'dispensasi',
            'format_code' => 'DSP',
            'description' => 'Untuk kegiatan sekolah atau lomba di luar.'
        ]);
        Category::create([
            'name' => 'Surat Keterangan Sakit',
            'code' => 'sakit',
            'format_code' => 'SKT',
            'description' => 'Wajib melampirkan bukti/surat dokter.'
        ]);
        Category::create([
            'name' => 'Pengajuan Beasiswa',
            'code' => 'beasiswa',
            'format_code' => 'BSW',
            'description' => 'Permohonan keringanan atau beasiswa prestasi.'
        ]);

        $this->call(SuratSeeder::class);
    }
}
