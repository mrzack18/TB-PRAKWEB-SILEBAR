# SILEBAR - Sistem Lelang Barang

Sistem Lelang Barang (SILEBAR) adalah aplikasi web berbasis Laravel 12 dan Tailwind CSS untuk mengelola proses lelang barang secara online.

## 📋 Daftar Isi
- [Deskripsi](#deskripsi)
- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Prasyarat](#prasyarat)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Struktur Database](#struktur-database)
- [Hak Akses](#hak-akses)
- [Panduan Penggunaan](#panduan-penggunaan)
- [Pengembangan](#pengembangan)
- [Testing](#testing)
- [Lisensi](#lisensi)

## Deskripsi

SILEBAR adalah sistem lelang online yang dirancang untuk memfasilitasi proses lelang barang secara digital. Aplikasi ini menyediakan platform bagi penjual untuk melelang barang mereka dan pembeli untuk menawar barang yang tersedia, dengan pengawasan dan verifikasi dari admin.

## Fitur Utama

- **Tiga Jenis Pengguna**: Admin, Penjual, dan Pembeli
- **Sistem Lelang Real-time**: Dukungan untuk penawaran langsung
- **Manajemen Barang Lelang**: Upload foto, deskripsi, kategori
- **Verifikasi Admin**: Proses verifikasi barang dan pembayaran
- **Notifikasi Log-based**: Sistem notifikasi berbasis log (tidak real-time) untuk semua role
- **Laporan Transaksi**: Laporan harian, bulanan, tahunan
- **Sistem Pembayaran**: Integrasi dengan gateway pembayaran
- **Manajemen Pengiriman**: Pelacakan status pengiriman barang
- **Filter Status Lelang**: Filter untuk menampilkan lelang aktif dan selesai
- **Otomatisasi Status Lelang**: Lelang otomatis berubah menjadi 'completed' saat waktu habis
- **Sistem Pembayaran Lengkap**: Proses pembayaran dan verifikasi pembayaran
- **Notifikasi Lengkap**: Notifikasi komprehensif untuk admin, penjual, dan pembeli

## Teknologi yang Digunakan

- **Backend**: Laravel 12 (PHP 8.3+)
- **Database**: MySQL 8.0+
- **Frontend**: Tailwind CSS 4.x, Alpine.js
- **Queue**: Redis
- **Build Tools**: Node.js, NPM/Yarn

## Prasyarat

Sebelum memulai, pastikan sistem Anda telah terinstall:

- PHP 8.3+
- Composer
- MySQL 8.0+
- Node.js
- NPM atau Yarn
- Redis (untuk queue)
- Git

## Instalasi

1. Clone repository ini:
   ```bash
   git clone https://github.com/username-anda/TB-PRAKWEB-SILEBAR.git
   cd TB-PRAKWEB-SILEBAR
   ```

2. Install dependensi PHP:
   ```bash
   composer install
   ```

3. Install dependensi frontend:
   ```bash
   npm install
   # atau
   yarn install
   ```

4. Salin file environment dan konfigurasi:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Konfigurasi database di file `.env`

7. Jalankan migrasi database:
   ```bash
   php artisan migrate --seed
   ```

8. Buat symlink untuk akses file storage:
   ```bash
   php artisan storage:link
   ```

9. Jalankan aplikasi:
   ```bash
   php artisan serve
   ```

## Konfigurasi

### Database
Pastikan konfigurasi database di file `.env` telah diisi dengan benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password
```

### Storage Link
Untuk mengakses file yang diupload (gambar lelang, bukti pembayaran, dll), buat symlink dari `public/storage` ke `storage/app/public`:

```bash
php artisan storage:link
```

Jika symlink sudah ada dan bermasalah, hapus dulu lalu buat ulang:
```bash
# Di Windows
rmdir /s /q public\storage
php artisan storage:link

# Di Linux/Mac
rm -rf public/storage
php artisan storage:link
```

### Email
Konfigurasi layanan email untuk notifikasi:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
```

### Queue Worker
Untuk menjalankan queue worker (penting untuk proses otomatisasi):

```bash
# Untuk development
php artisan queue:work

# Atau untuk production
php artisan queue:work --daemon
```

### Scheduler
Untuk menjalankan scheduler (penting untuk proses otomatisasi lelang):

```bash
# Tambahkan ke crontab sistem
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Struktur Database

Aplikasi ini menggunakan 7 tabel utama:

- `users`: Data pengguna (admin, seller, buyer)
- `categories`: Kategori barang lelang
- `auction_items`: Barang-barang yang dilelang
- `auction_images`: Gambar-gambar barang lelang
- `bids`: Penawaran yang ditempatkan
- `transactions`: Transaksi lelang yang berhasil
- `notifications`: Notifikasi untuk pengguna

## Hak Akses

### Admin
- Mengelola pengguna (tambah, edit, hapus)
- Mengelola kategori barang
- Verifikasi barang yang dilelang
- Verifikasi pembayaran
- Generate laporan transaksi (harian, bulanan, tahunan)
- Manajemen sistem
- Melihat dan mengelola semua pembayaran

### Penjual
- Menambah/mengelola barang lelang
- Melihat penawaran pada barang mereka
- Mengelola status pengiriman barang
- Melihat riwayat transaksi
- Melihat dan mengelola halaman pengiriman

### Pembeli
- Melihat/menawar barang lelang
- Melihat status penawaran
- Melihat transaksi yang berhasil
- Melacak status pengiriman barang
- Melakukan pembayaran untuk barang yang dimenangkan

## Panduan Penggunaan

### 1. Registrasi dan Login
- Pengguna dapat mendaftar sebagai seller atau buyer
- Admin biasanya dibuat melalui seeding database
- Gunakan fitur login untuk mengakses dashboard sesuai peran

### 2. Bagi Penjual
- Login ke dashboard penjual
- Klik "Buat Lelang" untuk membuat lelang baru
- Isi informasi barang, harga awal, durasi lelang
- Tunggu verifikasi admin sebelum lelang aktif
- Kelola lelang yang sedang berlangsung
- Setelah pembayaran diverifikasi, kelola pengiriman barang

### 3. Bagi Pembeli
- Jelajahi lelang yang tersedia
- Lihat detail barang dan waktu tersisa
- Tempatkan tawaran jika lelang masih aktif
- Jika menang lelang, ikuti proses pembayaran
- Pantau status pengiriman barang

### 4. Bagi Admin
- Verifikasi barang lelang dari seller
- Verifikasi pembayaran dari buyer
- Kelola pengguna dan kategori
- Generate laporan transaksi

### 5. Proses Lelang Otomatis
- Lelang otomatis berakhir saat waktu habis
- Status lelang berubah menjadi 'completed'
- Pemenang lelang ditentukan berdasarkan tawaran tertinggi
- Jika ada tawaran di akhir waktu, waktu lelang diperpanjang (anti-sniping)

### 6. Proses Pembayaran
- Setelah lelang selesai, pemenang dapat melanjutkan ke pembayaran
- Upload bukti pembayaran
- Tunggu verifikasi admin
- Setelah diverifikasi, seller mengirim barang
- Buyer dapat melacak status pengiriman

### 7. Filter Status Lelang
- Di halaman lelang, gunakan filter status untuk menampilkan:
  - Semua status (aktif dan selesai)
  - Hanya lelang aktif
  - Hanya lelang selesai

### 8. Sistem Notifikasi
- Sistem notifikasi sekarang berbasis log (tidak real-time)
- Pengguna dapat melihat notifikasi di halaman notifikasi
- Tidak ada notifikasi pop-up atau notifikasi real-time
- **Notifikasi Admin**:
  - Pemberitahuan tentang barang baru menunggu verifikasi
  - Pemberitahuan tentang pembayaran baru menunggu verifikasi
  - Pembaruan sistem penting
- **Notifikasi Penjual**:
  - Pemberitahuan tentang status verifikasi barang
  - Pemberitahuan tentang lelang yang segera berakhir
  - Pemberitahuan tentang barang terjual
  - Pemberitahuan tentang pembayaran yang diterima
  - Pemberitahuan tentang permintaan pengiriman
  - Pemberitahuan tentang permintaan ulasan
  - Pemberitahuan tentang pembatalan lelang
- **Notifikasi Pembeli**:
  - Pemberitahuan tentang penawaran yang terlampaui
  - Pemberitahuan tentang kemenangan lelang
  - Pemberitahuan tentang status pembayaran
  - Pemberitahuan tentang status pengiriman
  - Pemberitahuan tentang keterlambatan pengiriman
  - Pemberitahuan tentang permintaan ulasan
  - Pemberitahuan tentang pembatalan lelang

## Pengembangan

### Menjalankan Development Server
```bash
# Jalankan development server
php artisan serve

# Jalankan queue worker
php artisan queue:work

# Jalankan scheduler (untuk otomatisasi lelang)
php artisan schedule:run

# Jalankan build assets secara otomatis
npm run dev
```

### Struktur Direktori
```
app/                    # Core application logic
├── Http/               # Controllers, middleware, requests
├── Models/             # Eloquent models
├── Jobs/               # Queue jobs (CheckExpiredAuctions, etc.)
├── Console/            # Commands and schedules
config/                 # Configuration files
database/               # Migrations, seeds, factories
public/                 # Public assets
resources/              # Views, CSS, JS
routes/                 # Application routes
storage/                # File storage
tests/                  # Test files
```

## Testing

Jalankan test suite:

```bash
# Unit dan feature tests
php artisan test

# Atau dengan PHPUnit langsung
./vendor/bin/phpunit
```

## Kontribusi

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/NamaFitur`)
3. Commit perubahan (`git commit -m 'Tambah NamaFitur'`)
4. Push ke branch (`git push origin feature/NamaFitur`)
5. Buat pull request

## Lisensi

MIT License - lihat file [LICENSE](LICENSE) untuk detail selengkapnya.

## Kontak

Jika Anda memiliki pertanyaan, silakan hubungi [email Anda](mailto:email@example.com).