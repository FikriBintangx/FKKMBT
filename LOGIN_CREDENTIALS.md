# 🔐 DATA LOGIN UNTUK TESTING - FKKMBT

## 📋 CARA SETUP:

1. Import database: `database_final_fixed.sql`
2. **PENTING:** Jalankan SQL: `update_add_email_column.sql` (untuk tambah kolom email)
3. Import data: `insert_users_final.sql`
4. Import data: `data_seeder.sql`

---

## 👨‍💼 ADMIN LOGIN

### Admin 1: Staff FKKMBT

```
Email/Username: StaffFkkmbt
Password: staff123
```

**Akses:**

- URL: `http://localhost/fkkmbt/auth/login`
- Atau: `http://localhost/fkkmbt/admin/dashboard`

**Fitur yang bisa diakses:**

- Dashboard Admin
- Kelola Warga (CRUD)
- Kelola Kegiatan
- Kelola Organisasi
- Kelola Iuran
- Verifikasi Pembayaran
- Pengaduan
- SOS/Panic
- E-Surat
- Lapak Warga
- Keuangan

---

## 👤 WARGA LOGIN

### Warga 1: Aceva Arie Sadewa (Ketua FKKMMBT)

```
Email: aceva.arie.sadewa@fkkmbt.or.id
Username: aceva
Password: 160704
Blok: J No. 4
No HP: 087786720942
```

### Warga 2-6: Blok A

```
Email: agus.setiawan@fkkmbt.or.id
Username: warga_a1
Password: 123456
Nama: Agus Setiawan
Blok: A No. 1
```

```
Email: ani.wijaya@fkkmbt.or.id
Username: warga_a2
Password: 123456
Nama: Ani Wijaya
Blok: A No. 2
```

```
Email: bambang.sutrisno@fkkmbt.or.id
Username: warga_a3
Password: 123456
Nama: Bambang Sutrisno
Blok: A No. 3
```

```
Email: citra.dewi@fkkmbt.or.id
Username: warga_a4
Password: 123456
Nama: Citra Dewi
Blok: A No. 4
```

```
Email: dedi.kurniawan@fkkmbt.or.id
Username: warga_a5
Password: 123456
Nama: Dedi Kurniawan
Blok: A No. 5
```

### Warga 7-11: Blok B

```
Username: warga_b1 sampai warga_b5
Password: 123456 (semua sama)
Nama: Eko Prasetyo, Fitri Handayani, Gunawan Wibowo, Hani Kusuma, Irfan Hakim
Blok: B No. 1-5
```

### Warga 12-16: Blok C

```
Username: warga_c1 sampai warga_c5
Password: 123456 (semua sama)
Nama: Joko Widodo, Kartika Sari, Lukman Hakim, Maya Anggraini, Nugroho Santoso
Blok: C No. 1-5
```

### Warga 17-21: Blok D

```
Username: warga_d1 sampai warga_d5
Password: 123456 (semua sama)
Nama: Omar Bakri, Putri Ayu, Qomar Zaman, Rina Susanti, Surya Pratama
Blok: D No. 1-5
```

### Warga 22-26: Blok E

```
Username: warga_e1 sampai warga_e5
Password: 123456 (semua sama)
Nama: Tono Sumarno, Uci Sanusi, Vino Bastian, Wulan Guritno, Yudi Latif
Blok: E No. 1-5
```

### Warga 27-29: Blok J (tetangga Aceva)

```
Username: warga_j2, warga_j3, warga_j5
Password: 123456 (semua sama)
Nama: Zainal Abidin, Aisha Putri, Bima Sakti
Blok: J No. 2, 3, 5
```

**Akses Warga:**

- URL: `http://localhost/fkkmbt/auth/login`
- Atau: `http://localhost/fkkmbt/user/dashboard`

**Fitur yang bisa diakses:**

- Dashboard Warga
- Iuran Saya (Upload Bukti Bayar)
- Riwayat Pembayaran
- Profil Saya
- Ubah Password
- Pengaduan
- E-Surat
- Lapak Warga

---

## 🔄 CARA LOGIN:

### Login dengan EMAIL (Recommended):

```
Email: aceva.arie.sadewa@fkkmbt.or.id
Password: 160704
```

### Login dengan USERNAME (Backward Compatible):

```
Username: aceva
Password: 160704
```

**Keduanya bisa digunakan!** Sistem akan cek email dulu, kalau tidak ada baru cek username.

---

## 📊 DATA YANG SUDAH ADA DI DATABASE:

### ✅ Organisasi (5):

- FKKMBT
- PKK
- Karang Taruna
- Posyandu
- Remaja Masjid

### ✅ Pengurus (12):

- FKKMBT: Haji Kusnantoro (Ketua) + 5 pengurus
- FKKMMBT: Aceva Arie Sadewa (Ketua) + 5 pengurus

### ✅ Kegiatan (15):

- Gotong Royong
- Rapat RT
- Posyandu
- Arisan PKK
- Turnamen Futsal
- HUT RI
- Bakti Sosial
- Kajian Rutin
- Senam Sehat
- Pelatihan Kue
- Nonton Bareng
- Ronda Malam
- Cek Kesehatan
- Penghijauan
- Buka Puasa Bersama

### ✅ Iuran (5):

- Iuran Bulanan RT: Rp 50.000
- Iuran Keamanan: Rp 100.000
- Iuran Kebersihan: Rp 75.000
- Iuran Sosial: Rp 25.000
- Iuran HUT RI: Rp 50.000

### ✅ Warga (34):

- 33 warga dummy + 1 Aceva (real data)
- Tersebar di Blok A, B, C, D, E, J

---

## 🧪 SKENARIO TESTING:

### Test 1: Login Admin

1. Buka `http://localhost/fkkmbt/auth/login`
2. Login: `StaffFkkmbt` / `staff123`
3. Cek dashboard admin
4. Coba buka menu Kelola Warga
5. Coba buka menu Kelola Iuran

### Test 2: Login Warga

1. Logout dari admin
2. Login: `aceva.arie.sadewa@fkkmbt.or.id` / `160704`
3. Cek dashboard warga
4. Buka menu "Iuran Saya"
5. Coba upload bukti bayar (dummy image)

### Test 3: Verifikasi Pembayaran

1. Login sebagai admin
2. Buka menu "Iuran" → "Verifikasi Pembayaran"
3. Lihat pembayaran yang di-upload warga
4. Approve atau Reject

### Test 4: Tambah Warga Baru (Auto-generate Email)

1. Login sebagai admin
2. Buka "Kelola Warga"
3. Klik "Tambah Warga Baru"
4. Isi:
   - Nama: "Budi Santoso"
   - Blok: A
   - No Rumah: 10
   - No HP: 081234567890
5. Submit
6. Lihat email yang auto-generate: `budi.santoso@fkkmbt.or.id`
7. Catat password yang muncul
8. Logout dan coba login dengan email tersebut

### Test 5: Ubah Password

1. Login sebagai warga
2. Buka "Profil Saya"
3. Klik "Ubah Password"
4. Isi password lama dan password baru
5. Submit
6. Logout dan login dengan password baru

---

## ⚠️ CATATAN PENTING:

1. **Password disimpan PLAIN TEXT** untuk kemudahan admin melihat dan mengirim ke warga via WA
2. **Email auto-generate** dari nama warga dengan format: `nama.lengkap@fkkmbt.or.id`
3. **Username** = prefix email (sebelum @)
4. Semua warga dummy password-nya: `123456`
5. Aceva password-nya: `160704`
6. Admin password-nya: `staff123`

---

## 🚀 READY TO TEST!

Semua data sudah siap. Tinggal import SQL files dan langsung bisa test semua fitur!
