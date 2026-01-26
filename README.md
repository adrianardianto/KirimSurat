# ✉️ KirimSurat

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)

**KirimSurat** adalah Sistem Informasi Manajemen Persuratan berbasis web yang dirancang untuk memodernisasi dan menyederhanakan alur kerja administrasi surat-menyurat dalam organisasi. Dari pembuatan draf hingga persetujuan dan pengarsipan, KirimSurat menyediakan solusi _end-to-end_ yang efisien.

---

## 🌟 Fitur Unggulan

Aplikasi ini dibangun dengan fokus pada efisiensi dan kemudahan penggunaan:

### 📝 Manajemen Surat (Surat Masuk & Keluar)

- **Pembuatan Surat Digital**: Editor formulir yang intuitif untuk membuat surat dinas.
- **Penomoran Otomatis**: Generate nomor surat otomatis berdasarkan format kategori (misal: `001/IZN/2024`) untuk memastikan konsistensi.
- **Export ke PDF**: Unduh surat yang telah disetujui langsung ke format PDF siap cetak.
- **Status Tracking**: Pantau status surat secara real-time (`Pending`, `Approved`, `Rejected`).

### 🏷️ Manajemen Kategori Dinamis

- **Kategorisasi Surat**: Kelola jenis surat (Izin, Tugas, Undangan, dll) dengan mudah.
- **Kode Surat Kustom**: Atur kode singkatan surat (misal: 'IZN', 'DSP') yang akan otomatis disisipkan ke nomor surat.

### 👥 Role-Based Access Control (RBAC)

- **Administrator**:
    - Mengelola seluruh pengguna (User Management CRUD).
    - Menyetujui atau menolak surat (Approval Workflow).
    - Mengakses log aktivitas sistem.
    - Mengelola kategori surat.
- **User / Staff**:
    - Mengajukan surat baru.
    - Melihat riwayat surat pribadi.
    - Mengunduh surat yang telah disetujui.

### 🛡️ Keamanan & Monitoring

- **Audit Logs**: Merekam jejak aktivitas pengguna untuk transparansi dan keamanan data.
- **Secure Authentication**: Login aman menggunakan sistem otentikasi Laravel.

---

## 🛠️ Teknologi

**Backend:**

- [Laravel 12](https://laravel.com) - Framework PHP modern.
- MySql / SQLite - Penyimpanan data relasional.

**Frontend:**

- [Blade Templates](https://laravel.com/docs/blade) - Engine templating server-side.
- [Tailwind CSS](https://tailwindcss.com) - Framework CSS untuk styling antarmuka.
- [Alpine.js](https://alpinejs.dev) - Interaktivitas frontend yang ringan.

**Utilities:**

- `barryvdh/laravel-dompdf` - Pembuatan dokumen PDF.
- `Vite` - Build tool aset frontend.

---

## 🚀 Instalasi & Konfigurasi

Ikuti langkah langkah ini untuk menjalankan proyek di lokal komputer Anda.

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js & NPM

### Langkah Instalasi

1.  **Clone Repository**

    ```bash
    git clone https://github.com/adrianardianto/KirimSurat.git
    cd KirimSurat
    ```

2.  **Install Dependencies Backend & Frontend**

    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file contoh konfigurasi dan buat file `.env` baru.

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan sesuaikan pengaturan database Anda (DB_DATABASE, dll).

    ```bash
    # Contoh untuk SQLite (Default)
    DB_CONNECTION=sqlite
    # Hapus DB_DATABASE, DB_USERNAME, dll jika menggunakan SQLite default Laravel 11/12
    ```

4.  **Generate App Key**

    ```bash
    php artisan key:generate
    ```

5.  **Setup Database**
    Jalankan migrasi untuk membuat struktur tabel.

    ```bash
    php artisan migrate
    ```

    _(Opsional) Jalankan seeder jika tersedia untuk data dummy:_

    ```bash
    php artisan db:seed
    ```

6.  **Jalankan Aplikasi**
    Buka dua terminal terpisah untuk menjalankan server lokal dan build assets.

    _Terminal 1 (Laravel Server):_

    ```bash
    php artisan serve
    ```

    _Terminal 2 (Vite Development):_

    ```bash
    npm run dev
    ```

🎉 **Selesai!** Buka browser dan akses aplikasi di `http://127.0.0.1:8000`.

---

## 📸 Antarmuka Aplikasi

_(Tambahkan screenshot aplikasi di sini nanti)_

|                                   Dashboard                                    |                                Surat Editor                                |
| :----------------------------------------------------------------------------: | :------------------------------------------------------------------------: |
| ![Dashboard Placehoder](https://via.placeholder.com/400x200?text=Dashboard+UI) | ![Editor Placeholder](https://via.placeholder.com/400x200?text=Surat+Form) |

---

## 🤝 Kontribusi

Kontribusi selalu diterima! Silakan buat **Pull Request** baru untuk perbaikan bug atau penambahan fitur.

## 📄 Lisensi

KirimSurat didistribusikan di bawah lisensi [MIT](https://opensource.org/licenses/MIT).
