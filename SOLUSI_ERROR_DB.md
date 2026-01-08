# Solusi Error Database: Access Denied

Error yang Anda alami:
`Access denied for user 'ti2b8143_fkkmbt_admin'@'localhost' to database 'ti2b8143_fkkmbt'`

Artinya: Username dan Database sudah benar, tetapi password salah atau user belum mendapatkan izin (privileges) ke database tersebut.

Silakan ikuti langkah perbaikan ini satu per satu di cPanel:

## Langkah 1: Pastikan User Sudah Ditambahkan ke Database (Sering Terlewat!)

1. Buka menu **MySQL Databases** di cPanel.
2. Scroll ke bagian paling bawah: **"Add User to Database"**.
3. Pilih User: `ti2b8143_fkkmbt_admin`
4. Pilih Database: `ti2b8143_fkkmbt`
5. Klik tombol **Add**.
6. Di halaman selanjutnya, centang **ALL PRIVILEGES**.
7. Klik **Make Changes**.
8. Coba refresh website Anda. Jika berhasil, selesai. Jika belum, lanjut Langkah 2.

## Langkah 2: Reset Password Database

Jika Langkah 1 sudah dilakukan tapi masih error, berarti passwordnya salah. Kita samakan password di cPanel dengan yang ada di script.

1. Di menu **MySQL Databases**, scroll ke bagian **Current Users**.
2. Cari user `ti2b8143_fkkmbt_admin`.
3. Klik **Change Password**.
4. Masukkan password ini (SAMA PERSIS):
   `@fkkmbtjayajaya`
5. Klik **Change Password**.
6. Coba refresh website Anda.

## Langkah 3 (Jalur Darurat): Edit Config Manual

Jika Anda ingin menggunakan password sendiri (berbeda dari `@fkkmbtjayajaya`):

1. Buka **File Manager** di cPanel.
2. Masuk ke folder: `public_html/fkkmbt.ti24se1.my.id/application/config/`
3. Edit file `database.php`.
4. Cari bagian `// LIVE SERVER (cPanel)`.
5. Ubah bagian `'password'` sesuai dengan password yang Anda buat di cPanel.
