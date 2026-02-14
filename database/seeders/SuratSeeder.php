<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuratSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('role', 'user')->first();
        $admin = User::where('role', 'admin')->first();

        if (!$user) {
             // Fallback if user doesn't exist
             $user = User::first(); 
        }

        $categories = Category::all();

        // 1. Surat Izin Tidak Masuk
        $catIzin = $categories->where('code', 'izin')->first();
        if ($catIzin) {
            Surat::create([
                'type' => 'surat_masuk',
                'reference_number' => '001/IZN/I/2026',
                'date' => now(),
                'sender' => $user->name,
                'recipient' => 'Kepala Sekolah',
                'subject' => 'Izin Tidak Masuk Sekolah',
                'content' => 'Saya meminta izin tidak masuk karena ada acara keluarga.',
                'status' => 'pending',
                'category_id' => $catIzin->id,
                'user_id' => $user->id,
            ]);
        }

        // 2. Pengajuan Dispensasi
        $catDispensasi = $categories->where('code', 'dispensasi')->first();
         if ($catDispensasi) {
            Surat::create([
                'type' => 'surat_masuk',
                'reference_number' => '002/DSP/I/2026',
                'date' => now()->subDay(),
                'sender' => $user->name,
                'recipient' => 'Wali Kelas',
                'subject' => 'Permohonan Dispensasi Lomba',
                'content' => 'Mengikuti lomba matematika tingkat provinsi.',
                'status' => 'approved',
                'category_id' => $catDispensasi->id,
                'user_id' => $user->id,
                'approved_by' => $admin ? $admin->id : null,
                'approved_at' => now(),
            ]);
        }
        
        // 3. Surat Keterangan Sakit
        $catSakit = $categories->where('code', 'sakit')->first();
        if ($catSakit) {
             Surat::create([
                'type' => 'surat_masuk',
                'reference_number' => '003/SKT/I/2026',
                'date' => now()->subDays(2),
                'sender' => $user->name,
                'recipient' => 'Guru BK',
                'subject' => 'Surat Keterangan Sakit',
                'content' => 'Sakit demam berdarah, terlampir surat dokter.',
                'status' => 'pending',
                'category_id' => $catSakit->id,
                'user_id' => $user->id,
            ]);
        }

        // 4. Pengajuan Beasiswa
        $catBeasiswa = $categories->where('code', 'beasiswa')->first();
        if ($catBeasiswa) {
             Surat::create([
                'type' => 'surat_masuk',
                'reference_number' => '004/BSW/I/2026',
                'date' => now()->subDays(5),
                'sender' => $user->name,
                'recipient' => 'Kepala Sekolah',
                'subject' => 'Pengajuan Beasiswa Berprestasi',
                'content' => 'Mohon bantuan beasiswa karena juara 1 umum.',
                'status' => 'rejected',
                'category_id' => $catBeasiswa->id,
                'user_id' => $user->id,
            ]);
        }

         // 5. Surat Izin Again
         if ($catIzin) {
            Surat::create([
                'type' => 'surat_masuk',
                'reference_number' => '005/IZN/I/2026',
                'date' => now()->subDays(10),
                'sender' => $user->name,
                'recipient' => 'Wali Kelas',
                'subject' => 'Izin Melayat',
                'content' => 'Izin tidak masuk karena nenek meninggal.',
                'status' => 'approved',
                'category_id' => $catIzin->id,
                'user_id' => $user->id,
                'approved_by' => $admin ? $admin->id : null,
                'approved_at' => now(),
            ]);
        }
    }
}
