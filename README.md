<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a></p>

# Tiketku

Tiketku adalah aplikasi pemesanan tiket (booking) berbasis Laravel. Pengunjung dapat menjelajahi tiket berdasarkan kota penjual/kategori, melihat detail tiket, melakukan booking, membayar, hingga mengecek status booking. Admin mengelola data (kategori, seller, tiket, transaksi) melalui panel admin berbasis [Filament](https://filamentphp.com).

## Fitur Utama

- **Halaman depan (Front)**: listing tiket, explore berdasarkan kota seller, browse berdasarkan kategori, dan detail tiket.
- **Booking**: form booking tiket, pembayaran, halaman selesai booking, serta cek status booking berdasarkan invoice.
- **Notifikasi email otomatis** (via queue job):
  - `SendBookingConfirmedEmail` → email `OrderConfirmed` saat booking baru dibuat.
  - `SendBookingApprovedEmail` → email `OrderApproved` saat booking disetujui/lunas.
- **Panel admin (Filament)** di `/admin` untuk mengelola kategori, seller, tiket, foto tiket, dan transaksi booking.

## Tech Stack

- PHP 8.2+, Laravel 11
- Filament 5 (admin panel)
- MySQL (lihat konfigurasi `.env`)
- Vite + Tailwind CSS (asset frontend)
- Queue: database driver (untuk proses pengiriman email booking)

## Alur Instalasi (Setup dari Awal)

1. **Clone project & install dependency**
   ```bash
   git clone <url-repo> tiketku
   cd tiketku
   composer install
   npm install
   ```

2. **Siapkan file environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Lalu sesuaikan koneksi database di `.env` (default menggunakan MySQL):
   ```env
   DB_CONNECTION=mysql
   DB_DATABASE=tiketku
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Pastikan database `tiketku` sudah dibuat di MySQL sebelum lanjut ke langkah berikutnya.

3. **Jalankan migrasi & seeder**
   ```bash
   php artisan migrate --seed
   ```
   Seeder akan membuat:
   - Data awal (`DatabaseSeeder`)
   - Akun admin (`AdminUserSeeder`) untuk login ke panel Filament di `/admin`

4. **Buat storage link** (untuk menampilkan gambar/foto tiket yang diupload)
   ```bash
   php artisan storage:link
   ```

5. **Build asset frontend**
   ```bash
   npm run dev      # mode development (watch)
   # atau
   npm run build    # build untuk production
   ```

## Menjalankan Project (Sehari-hari)

Karena project ini menggunakan **Laravel Herd**, server web sudah otomatis berjalan — tidak perlu `php artisan serve`. Cukup pastikan:

1. **Herd aktif** di sistem, dan project sudah terdaftar sehingga bisa diakses lewat domain `.test` (lihat `APP_URL` di `.env`, contoh: `http://tiketku.test`).
2. **Jalankan queue worker**, karena pengiriman email booking diproses lewat queue (`QUEUE_CONNECTION=database`):
   ```bash
   php artisan queue:work
   ```
   Tanpa worker ini aktif, email konfirmasi/approval booking tidak akan terkirim.
3. **Jalankan Vite dev server** jika sedang mengembangkan tampilan:
   ```bash
   npm run dev
   ```
4. Akses aplikasi di browser:
   - Halaman utama: `http://tiketku.test`
   - Panel admin: `http://tiketku.test/admin`

> Jika tidak menggunakan Herd (misalnya di environment lain), jalankan server bawaan Laravel sebagai gantinya: `php artisan serve`.

## Alur Penggunaan Aplikasi

1. Pengunjung membuka halaman utama, bisa explore tiket per kota seller (`/explore/{kota}`) atau per kategori (`/browse/{kategori}`).
2. Pengunjung membuka detail tiket (`/details/{ticket}`) lalu melakukan booking (`/booking/{ticket}`).
3. Setelah booking dibuat, sistem mengirim email konfirmasi (job `SendBookingConfirmedEmail`) dan mengarahkan ke halaman pembayaran (`/booking/payment`).
4. Setelah pembayaran diproses, pengunjung diarahkan ke halaman selesai booking (`/booking/finished/{bookingTransaction}`).
5. Pengunjung dapat mengecek status booking kapan saja lewat `/check-booking` menggunakan nomor invoice.
6. Admin login ke `/admin` untuk memverifikasi/menyetujui transaksi booking, yang akan memicu email approval (job `SendBookingApprovedEmail`).

## Menjalankan Test

```bash
php artisan test
```

## Struktur Kode Penting

- `app/Http/Controllers/FrontController.php` — logika halaman depan (listing, explore, category, detail).
- `app/Http/Controllers/BookingController.php` — logika booking, pembayaran, cek status.
- `app/Models/` — `Ticket`, `Seller`, `Category`, `TicketPhoto`, `BookingTransaction`, `User`.
- `app/Jobs/` & `app/Mail/` — proses queue dan template email booking.
- `app/Filament/` & `app/Providers/Filament/AdminPanelProvider.php` — konfigurasi panel admin.
- `routes/web.php` — daftar route aplikasi.

## License

Project ini dibangun di atas framework [Laravel](https://laravel.com) yang open-source dan berlisensi [MIT](https://opensource.org/licenses/MIT).
