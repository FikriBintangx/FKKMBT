# FKKMBT - IMPLEMENTATION ROADMAP

## Fitur-Fitur yang Akan Diimplementasi

### ✅ SUDAH SELESAI:

1. ✅ Admin Mobile Responsiveness CSS
2. ✅ Admin Header/Footer Templates
3. ✅ Login Page Mobile Redesign
4. ✅ Landing Page Navbar Fix
5. ✅ Footer Whitespace Fix
6. ✅ Text Visibility Improvements
7. ✅ Insert Users SQL Script

### 🚧 SEDANG DIKERJAKAN:

**Phase 1: Mobile Responsiveness (PRIORITY 1)**

- [ ] Update semua halaman admin untuk gunakan header/footer template baru
  - [ ] kegiatan.php
  - [ ] organisasi.php
  - [ ] pengaduan.php
  - [ ] panic.php
  - [ ] surat.php
  - [ ] lapak.php
  - [ ] keuangan.php

**Phase 2: Core Features Implementation (PRIORITY 2)**

- [ ] **Manajemen Iuran (CRUD)**

  - [ ] Controller: `admin/Iuran.php`
  - [ ] Model: `Iuran_model.php`
  - [ ] Views: `admin/iuran.php` (list, add, edit)
  - [ ] Database: Sudah ada (`iuran_master`, `pembayaran_iuran`)

- [ ] **Upload & Verifikasi Pembayaran Iuran**

  - [ ] User: Form upload bukti transfer
  - [ ] Admin: Halaman verifikasi pembayaran
  - [ ] Notifikasi status pembayaran

- [ ] **Profil Warga (User Dashboard)**
  - [ ] Controller: `user/Profil.php`
  - [ ] View: `user/profil.php` (view & edit)
  - [ ] Upload foto profil
  - [ ] Change password

**Phase 3: Additional Features (PRIORITY 3)**

- [ ] **E-Surat**

  - [ ] Controller: `admin/Surat.php` & `user/Surat.php`
  - [ ] Model: `Surat_model.php`
  - [ ] Database: Table `surat` (id, warga_id, jenis_surat, keperluan, status, file_pdf, created_at)
  - [ ] Views: Form pengajuan (user), List & approval (admin)

- [ ] **Pengaduan Warga**

  - [ ] Controller: `admin/Pengaduan.php` & `user/Pengaduan.php`
  - [ ] Model: `Pengaduan_model.php`
  - [ ] Database: Table `pengaduan` (id, warga_id, judul, isi, foto, status, tanggapan, created_at)
  - [ ] Views: Form pengaduan (user), List & tanggapi (admin)

- [ ] **Panic Button / SOS**

  - [ ] Controller: `Panic.php`
  - [ ] Model: `Panic_model.php`
  - [ ] Database: Table `panic_log` (id, warga_id, lokasi, keterangan, status, created_at)
  - [ ] Real-time notification (optional: use WebSocket or polling)

- [ ] **Lapak Warga (Marketplace)**

  - [ ] Controller: `admin/Lapak.php` & `Lapak.php` (public)
  - [ ] Model: `Lapak_model.php`
  - [ ] Database: Table `lapak` (id, warga_id, judul, deskripsi, harga, foto, kategori, status, created_at)
  - [ ] Views: List produk, detail, form tambah/edit

- [ ] **Keuangan/Transparansi Dana**
  - [ ] Controller: `admin/Keuangan.php`
  - [ ] Model: `Keuangan_model.php`
  - [ ] Database: Table `transaksi_keuangan` (id, jenis, keterangan, debit, kredit, saldo, tanggal)
  - [ ] Views: Laporan keuangan, grafik pemasukan/pengeluaran

**Phase 4: Security & UX Improvements (PRIORITY 4)**

- [ ] **Forgot Password**

  - [ ] Email reset link (atau SMS jika ada budget)
  - [ ] Token-based password reset

- [ ] **Change Password**

  - [ ] Form change password di profil
  - [ ] Validasi password lama

- [ ] **Session Timeout**

  - [ ] Config session timeout (30 menit)
  - [ ] Auto logout dengan warning

- [ ] **CSRF Protection**
  - [ ] Enable CSRF di config
  - [ ] Update semua form dengan CSRF token

**Phase 5: Data Seeder (PRIORITY 5)**

- [ ] **Seeder Kegiatan**

  - [ ] 10-15 kegiatan dummy dengan foto
  - [ ] Berbagai organisasi (FKKMBT, PKK, Karang Taruna)

- [ ] **Seeder Iuran**

  - [ ] Iuran bulanan, iuran kebersihan, iuran keamanan
  - [ ] Data pembayaran dummy

- [ ] **Seeder Struktur Organisasi**

  - [ ] Data pengurus FKKMBT
  - [ ] Data pengurus FKKMMBT (Muda-Mudi)

- [ ] **Seeder Warga**
  - [ ] 50-100 warga dummy
  - [ ] Berbagai blok (A-T)

**Phase 6: Export & Reporting (PRIORITY 6)**

- [ ] **Export Excel**

  - [ ] Library: PhpSpreadsheet
  - [ ] Export data warga, kegiatan, iuran

- [ ] **Export PDF**
  - [ ] Library: TCPDF atau mPDF
  - [ ] Laporan keuangan, surat

---

## ESTIMASI WAKTU:

- Phase 1: 1-2 jam ✅ (DONE)
- Phase 2: 3-4 jam
- Phase 3: 4-5 jam
- Phase 4: 2-3 jam
- Phase 5: 1-2 jam
- Phase 6: 2-3 jam

**TOTAL: ~15-20 jam development time**

---

## NEXT STEPS (IMMEDIATE):

1. Finish Phase 1 (update remaining admin pages)
2. Start Phase 2 (Manajemen Iuran - most requested feature)
3. Create data seeders (Phase 5) - untuk demo yang bagus
