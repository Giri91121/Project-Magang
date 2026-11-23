# Dokumentasi Struktur Sistem Portal BRIDA Kota Makassar

Dokumen ini dibuat sebagai panduan baca untuk memahami struktur **Backend**, **Frontend**, **Infrastruktur**, serta **Alur Kerja Sistem** pada proyek Laravel `brida-portal`. File ini hanya bersifat dokumentasi dan tidak memengaruhi jalannya website.

---

## 1. Bagian Backend (Logika, Database, Keamanan, & Rute)

Backend bertugas memproses data, validasi form, autentikasi pengguna, hak akses, dan komunikasi dengan database.

- **`app/Http/Controllers/`** — Otak pemroses setiap permintaan (request):
  - `HomeController.php`: Mengatur halaman publik (Beranda, Pemerintahan, Layanan, Informasi Publik, Berita, Kontak).
  - `LandingCmsController.php`: Mengatur seluruh tab Editor Landing Page di Dashboard Admin (Hero, Slideshow, Navbar, Layanan, Pemerintahan, Berita, Kontak, Informasi Publik, Pimpinan, Instagram).
  - `PermohonanRisetController.php`: Mengelola pengajuan izin riset, verifikasi status, dan unduh berkas terlampir secara aman.
  - `InovasiDaerahController.php`, `BeritaController.php`, `RegulasiController.php`: Mengelola data inovasi, berita, dan dokumen regulasi.
  - `UserController.php`: Mengelola Role (`Admin`, `User`) dan Sub-Role (`verif_riset`, `verif_berita`).
  - `Auth/GoogleAuthController.php`: Mengatur login & registrasi otomatis menggunakan Google OAuth 2.0.
- **`app/Models/`** — Representasi tabel database (Eloquent ORM):
  - `User.php`, `Setting.php`, `NavbarMenu.php`, `HeroSlide.php`, `LandingService.php`, `Berita.php`, `KomentarBerita.php`, `PermohonanRiset.php`, `InovasiDaerah.php`, `Regulasi.php`, `ActivityLog.php`.
- **`app/Http/Middleware/`** — Filter keamanan sebelum request masuk ke Controller:
  - `HoneypotProtection.php`: Melindungi form publik & komentar dari spam/bot.
- **`app/Services/`** — Layanan eksternal/tambahan:
  - `InstagramFeedService.php`: Mengambil postingan Instagram `@bridakotamakassar` secara otomatis dengan cache.
- **`routes/web.php`** — Daftar seluruh URL/rute website beserta middleware hak aksesnya (`auth`, `role:Admin`, `honeypot`, dll.).
- **`database/`** — Struktur tabel (`migrations/`) dan file database SQLite (`database.sqlite`).

---

## 2. Bagian Frontend (Tampilan UI, HTML, CSS, & Interaksi)

Frontend bertugas menampilkan antarmuka website yang dilihat dan diinteraksikan oleh pengguna di browser.

- **`resources/views/layouts/`** — Kerangka dasar halaman:
  - `landing.blade.php`: Kerangka halaman publik (Topbar, Navbar, Konten, Footer).
  - `app.blade.php`: Kerangka halaman Dashboard Admin & Pengguna (Sidebar, Topbar Profil, Konten).
  - `guest.blade.php`: Kerangka halaman Login / Register.
- **`resources/views/landing/`** — Halaman publik yang dilihat masyarakat:
  - `index.blade.php` (Beranda), `pemerintahan.blade.php`, `struktur-organisasi.blade.php`, `layanan.blade.php`, `informasi-publik.blade.php`, `berita.blade.php`, `berita-detail.blade.php`, `kontak.blade.php`.
- **`resources/views/dashboard/`** — Halaman pengelolaan internal:
  - `landing-cms/index.blade.php`: Editor Landing Page (7 Tab berbasis menu + Smart Save Button).
  - `users/index.blade.php`: Manajemen Role & Sub-Role Pengguna.
  - `riset/`, `inovasi/`, `berita/`, `regulasi/`, `komentar/`, `notifications/`.
- **`resources/views/components/`** — Komponen kecil yang dipakai ulang:
  - `honeypot.blade.php` (jebakan bot tersembunyi), `popup-alert.blade.php` (notifikasi SweetAlert2).
- **`resources/css/` & `resources/js/`** — Sumber CSS (Tailwind) & JS (Alpine.js) sebelum di-compile oleh Vite ke `public/build/`.
- **`public/`** — Folder yang langsung diakses browser (`images/`, `build/`, dan symlink `storage/`).

---

## 3. Folder & File Pendukung (Infrastruktur)

- **`config/`**: Pengaturan sistem Laravel (`app.php`, `database.php`, `services.php` untuk Google OAuth, `permission.php` untuk Spatie Role).
- **`.env`**: Konfigurasi rahasia & lingkungan lokal (koneksi database, `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, dll.).
- **`storage/`**: Tempat penyimpanan fisik file upload (`storage/app/public/`), log aplikasi (`storage/logs/laravel.log`), dan cache.
- **`vendor/` & `composer.json`**: Library PHP pihak ketiga (Laravel, Spatie Permission, Socialite, dll.).
- **`node_modules/` & `package.json`**: Library JavaScript/CSS (Tailwind CSS, Vite, Alpine.js).
- **`artisan`**: Alat baris perintah (CLI) Laravel (misalnya `php artisan serve`, `php artisan migrate`).

---

## 4. Alur Kerja Singkat Request (Dari Browser ke Database)

1. Pengguna membuka URL (misalnya `/berita` atau `/dashboard/landing-cms`).
2. **`routes/web.php`** mencocokkan URL dan mengecek keamanan (**Middleware** `auth`, `role`, atau `honeypot`).
3. **`Controller`** mengambil/menyimpan data melalui **`Model`** ke **`database/database.sqlite`** (atau file di **`storage/`**).
4. **`Controller`** mengirimkan data tersebut ke tampilan **`resources/views/...blade.php`** untuk dirender menjadi HTML dan ditampilkan ke browser.
