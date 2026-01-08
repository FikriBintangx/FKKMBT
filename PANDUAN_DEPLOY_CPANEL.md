# Panduan Konfigurasi Deploy ke cPanel (FKKMBT)

Berikut adalah langkah-langkah untuk menghubungkan repositori GitHub Anda ke cPanel dan membuat website aktif.

## 1. Persiapan di cPanel

1. Login ke cPanel hosting Anda.
2. Cari menu **"Git Version Control"**.
3. Klik **Create**.
   - **Clone URL**: `https://github.com/FikriBintangx/FKKMBT.git`
   - **Repository Path**: Biarkan default (misal: `repositories/FKKMBT`) atau sesuaikan.
   - **Repository Name**: FKKMBT
4. Klik **Create**. Tunggu hingga proses cloning selesai.

## 2. Deploy File ke Folder Public

Setelah repository di-clone:

1. Masuk ke **File Manager** di cPanel.
2. Buka folder repository Anda (misal `repositories/FKKMBT`).
3. Pilih semua file (**Select All**) -> Klik **Copy**.
4. Arahkan copy destination ke folder public Anda, biasanya `public_html` atau `public_html/subfolder` (jika menggunakan subdomain/subfolder).

> **Alternatif Otomatis:** Anda bisa membuat file `.cpanel.yml` untuk auto-deploy, tapi cara manual copy di atas lebih aman untuk pemula agar paham struktur file.

## 3. Konfigurasi Database

Aplikasi ini sudah dikonfigurasi untuk koneksi database otomatis di `application/config/database.php`. Anda HANYA perlu membuat database dengan nama dan user yang SAMA PERSIS seperti di konfigurasi, ATAU ubah konfigurasinya menyesuaikan cPanel Anda.

**Opsi A: Ikuti Konfigurasi yang Sudah Ada (Disarankan)**

1. Buka menu **MySQL Database Wizard** di cPanel.
2. Buat Database baru: `ti2b8143_fkkmbt` (Pastikan prefix `ti2b8143_` sesuai dengan username cPanel Anda. Jika username cPanel Anda BEDA, lihat Opsi B).
3. Buat User baru:
   - Username: `ti2b8143_fkkmbt_admin` (Sesuaikan prefix jika perlu)
   - Password: `@fkkmbtjayajaya`
4. Berikan akses **ALL PRIVILEGES** user tersebut ke database yang baru dibuat.

**Opsi B: Sesuaikan Config dengan cPanel Anda**
Jika username cPanel Anda bukan `ti2b8143`, maka Anda harus mengedit file `application/config/database.php` di cPanel (via File Manager):

1. Buka `application/config/database.php`.
2. Cari bagian `// LIVE SERVER (cPanel)`.
3. Ubah `'username'`, `'password'`, dan `'database'` sesuai dengan yang Anda buat di cPanel.

## 4. Import Database

1. Buka menu **phpMyAdmin** di cPanel.
2. Pilih database yang baru dibuat (misal `ti2b8143_fkkmbt`).
3. Klik menu **Import**.
4. Upload file `database_final_fixed.sql` yang ada di dalam folder project Anda (yang baru saja di-copy ke File Manager).
5. Klik **Go** / **Kirim**.

## 5. Cek Website

1. Buka domain/subdomain Anda di browser.
2. Aplikasi seharusnya sudah berjalan.
3. Coba login dengan akun default:
   - **User**: `warga1` / `123456`
   - **Admin**: `admin` / `123456`

## Troubleshooting

- **Error 404 / Page Not Found**: Pastikan file `.htaccess` ikut ter-copy ke `public_html`. File ini sering tersembunyi (hidden). Di File Manager, klik **Settings** (pojok kanan atas) -> Centang **Show Hidden Files**.
- **Database Error**: Cek kembali nama database, username, dan password di `application/config/database.php`.
- **Tampilan Rusak (CSS Hilang)**: Cek `application/config/config.php` dan pastikan `$config['base_url']` sudah dinamis (script yang saya buat sudah otomatis, jadi seharusnya aman).

Selamat mencoba!
