# JAFAPP — Project Progress Tracker
> **Sistem Pemesanan & Manajemen Produksi Toko Furniture Jati Akbar**
> Dokumen ini adalah sumber kebenaran tunggal (single source of truth) untuk progres pengembangan.
> **Selalu baca file ini di awal setiap conversation baru sebelum melakukan pekerjaan apapun.**

---

## 🗂️ Ringkasan Proyek

| Atribut | Detail |
|---|---|
| **Nama Proyek** | JAFAPP – Jati Akbar Furniture App |
| **PRD** | `PRD_JAFAPP.md` (v1.1.0) |
| **Stack** | Laravel 13.12.0 + Blade + TailwindCSS + MySQL + Midtrans |
| **PHP** | 8.4.11 |
| **Node.js** | v22.14.0 / NPM v10.9.2 |
| **Database** | MySQL 8.0.30 (Laragon) — DB Name: `jafapp` |
| **Root Dir** | `d:\@KULIAH!!\@Semester 6\Manajemen Project TI\JAFF` |
| **Git Branch Aktif** | `develop` |
| **GitHub** | Sudah terhubung (`origin`) |
| **Bahasa UI** | Bahasa Indonesia |

---

## 🎨 Design Tokens (WAJIB KONSISTEN)

| Token | Nilai |
|---|---|
| Primary Brown | `#6B3A2A` |
| Light Brown | `#A0522D` |
| Cream | `#F5F0E8` |
| Off-White | `#FAFAF7` |
| Dark Green | `#2D4A3E` |
| Text Primary | `#1A1A1A` |
| Text Secondary | `#6B7280` |
| Border | `#E5E0D8` |
| Font Heading | Playfair Display |
| Font Body | Inter |

---

## 🔐 Akun Seeded

| Role | Email | Password |
|---|---|---|
| Super Admin | `superadmin@jafapp.com` | `superadmin123` |
| Admin | `admin@jafapp.com` | `admin123` |

---

## 📦 Package Terinstall

### Composer
- `midtrans/midtrans-php` v2.6.2
- `barryvdh/laravel-dompdf` v3.1.2
- `maatwebsite/excel` v1.1.5

### NPM
- TailwindCSS (via Vite default Laravel setup)
- 63 packages total terinstall

---

## 🗄️ Database Schema (Selesai — Phase 1)

Semua tabel sudah dibuat dan dimigrasikan:

| Tabel | Status | Keterangan |
|---|---|---|
| `users` | ✅ Modified | + role, phone, address, is_active, is_guest, activation_token |
| `categories` | ✅ Created | id, name, slug, timestamps |
| `products` | ✅ Created | + images (JSON), is_active, dimensions, price, stock |
| `orders` | ✅ Created | status enum (10 nilai), shipping_cost manual by admin |
| `order_items` | ✅ Created | Snapshot harga, hanya created_at (no updated_at) |
| `custom_orders` | ✅ Created | ref_images (JSON), agreed_price, status enum |
| `payments` | ✅ Created | Midtrans fields, snap_token, raw_response (JSON) |
| `production_logs` | ✅ Created | Sequential status, foto progress, updated_by |
| `cache` | ✅ Default | |
| `jobs` | ✅ Default | |
| `sessions` | ✅ Default | |

---

## 🏗️ Models Dibuat (Phase 1)

| Model | File | Status |
|---|---|---|
| User | `app/Models/User.php` | ✅ Modified — role helpers, relationships |
| Category | `app/Models/Category.php` | ✅ Created — auto-slug |
| Product | `app/Models/Product.php` | ✅ Created — auto-slug, active scope |
| Order | `app/Models/Order.php` | ✅ Created — status constants, production sequence |
| OrderItem | `app/Models/OrderItem.php` | ✅ Created — snapshot price, no updated_at |
| CustomOrder | `app/Models/CustomOrder.php` | ✅ Created — ref_images JSON |
| Payment | `app/Models/Payment.php` | ✅ Created — Midtrans, raw_response JSON |
| ProductionLog | `app/Models/ProductionLog.php` | ✅ Created — sequential validation |

---

## 🔧 Infrastruktur (Phase 1)

| Komponen | File | Status |
|---|---|---|
| RoleMiddleware | `app/Http/Middleware/RoleMiddleware.php` | ✅ Created — alias 'role' |
| Midtrans Config | `config/midtrans.php` | ✅ Created |
| API Routes | `routes/api.php` | ✅ Created — webhook route |
| Bootstrap/App | `bootstrap/app.php` | ✅ Updated — CSRF exclusion, role alias |
| Storage Link | `public/storage` | ✅ Created |

---

## ✅ STATUS FASE PENGEMBANGAN

### PHASE 1 — Setup & Fondasi [✅ SELESAI]
> Commit: "Phase 1: Initial Laravel 13 setup with JAFAPP database schema, models, RBAC middleware, Midtrans config, and seeders"

- [x] Install Laravel 13, konfigurasi .env
- [x] Install Composer packages (Midtrans, DomPDF, Excel)
- [x] Install NPM packages (TailwindCSS via Vite)
- [x] Buat semua migration (8 file custom)
- [x] Jalankan semua migration
- [x] Buat semua Eloquent Model (8 model)
- [x] Buat RoleMiddleware + register di bootstrap/app.php
- [x] Buat config/midtrans.php
- [x] Buat routes/api.php (webhook Midtrans)
- [x] Buat SuperAdminSeeder, CategorySeeder, ProductSeeder
- [x] Jalankan semua seeder
- [x] Buat storage:link
- [x] Git init, commit awal, branch main & develop
- [x] Hubungkan ke GitHub

---

### PHASE 2 — Halaman Publik & Katalog [🔄 DALAM RENCANA]

**Tujuan**: Membuat semua halaman yang bisa diakses oleh pengunjung umum (tanpa login).

**Branch Git**: `feature/public-pages` (belum dibuat)

- [ ] **2.1** Layout Blade utama (`resources/views/layouts/app.blade.php`)
- [ ] **2.2** Komponen Navbar dengan ikon keranjang belanja
- [ ] **2.3** Komponen Footer
- [ ] **2.4** Halaman Beranda (`/`) — hero section, CTA, produk unggulan
- [ ] **2.5** Halaman Katalog (`/katalog`) — grid produk, filter kategori, pencarian
- [ ] **2.6** Komponen Product Card (reusable Blade component)
- [ ] **2.7** Halaman Detail Produk (`/produk/{slug}`) — galeri foto, lightbox, tombol tambah ke keranjang
- [ ] **2.8** Halaman Tentang Kami / Kontak (`/tentang`)
- [ ] **2.9** Halaman Tracking Publik (`/tracking`) — cek status pesanan via nomor pesanan
- [ ] **2.10** Komponen Status Badge (untuk status pesanan)
- [ ] **2.11** Komponen Production Stepper (visualisasi langkah produksi)
- [ ] **2.12** Halaman Keranjang Belanja (`/keranjang`) — session-based cart
- [ ] **2.13** PublicController + routes web.php untuk semua halaman di atas
- [ ] **2.14** QA Responsivitas (mobile, tablet, desktop)

---

### PHASE 3 — Autentikasi & Alur Pemesanan [⏳ BELUM DIMULAI]

**Tujuan**: Sistem login/register, guest checkout, dan alur pemesanan lengkap.

- [ ] **3.1** Halaman Login (`/login`)
- [ ] **3.2** Halaman Register (`/register`) — buat akun aktif
- [ ] **3.3** Guest Checkout flow (5 kondisi berdasarkan email lookup dari PRD)
- [ ] **3.4** Halaman Checkout (`/checkout`) — isi alamat, lihat total + ongkos kirim
- [ ] **3.5** Integrasi Midtrans Snap — generate snap_token, tampilkan payment popup
- [ ] **3.6** PaymentController (webhook handler dari Midtrans)
- [ ] **3.7** Halaman Konfirmasi Pesanan (`/pesanan/{order_number}`)
- [ ] **3.8** Halaman Riwayat Pesanan (untuk user yang login)
- [ ] **3.9** Halaman Detail Pesanan (status + production log)
- [ ] **3.10** Fitur Custom Order (`/custom-order`) — hanya untuk akun aktif
- [ ] **3.11** Email notifikasi (opsional, sesuai PRD)

---

### PHASE 4 — Panel Admin [⏳ BELUM DIMULAI]

**Tujuan**: Semua fitur manajemen untuk admin dan superadmin.

- [ ] **4.1** Layout Admin (`resources/views/admin/layouts/admin.blade.php`)
- [ ] **4.2** Dashboard Admin — ringkasan pesanan, pendapatan, statistik
- [ ] **4.3** Manajemen Produk — CRUD (+ upload foto dari client)
- [ ] **4.4** Manajemen Kategori — CRUD
- [ ] **4.5** Manajemen Pesanan — list, filter, update ongkos kirim manual
- [ ] **4.6** Manajemen Produksi — update status produksi secara sequential
- [ ] **4.7** Manajemen Custom Order — review, approve/reject, set harga
- [ ] **4.8** Manajemen Pengguna — CRUD (khusus SuperAdmin)
- [ ] **4.9** Laporan & Ekspor — Excel/PDF (pakai DomPDF + Maatwebsite Excel)
- [ ] **4.10** Fitur Upload Foto Progress Produksi

---

### PHASE 5 — Polish, Testing & Deployment [⏳ BELUM DIMULAI]

- [ ] **5.1** Optimasi query (eager loading, index check)
- [ ] **5.2** Unit Test / Feature Test kritis
- [ ] **5.3** Error handling & validasi menyeluruh
- [ ] **5.4** Pengamanan (CSRF, XSS, SQL Injection check)
- [ ] **5.5** Persiapan deployment (Nginx/Apache config, .env production)
- [ ] **5.6** Dokumentasi teknis final

---

## 💡 Keputusan Desain & Konteks Penting

| Topik | Keputusan |
|---|---|
| **Cart** | Session-based (bukan database table) |
| **Ongkos Kirim** | Input manual oleh admin di panel admin (kolom `shipping_cost`) |
| **Foto Produk** | Foto asli dari client (bukan placeholder/generated) |
| **Custom Order** | Hanya untuk akun aktif (sudah verifikasi email) |
| **Guest Checkout** | 5 kondisi berdasarkan lookup email (lihat PRD Section 4.2) |
| **Status Produksi** | WAJIB sequential, tidak boleh skip atau rollback |
| **Notifikasi WhatsApp** | TIDAK diimplementasikan |
| **API Pengiriman** | TIDAK diintegrasikan (manual) |
| **Bahasa** | Seluruh UI dalam Bahasa Indonesia |

---

## ⚠️ Hal yang Perlu Diperhatikan (Known Issues / Notes)

1. **`PaymentController`** direferensikan di `routes/api.php` tapi belum dibuat → akan dibuat di Phase 3. Jika ada error saat testing routing, ini penyebabnya.
2. **MySQL Laragon** perlu dijalankan manual jika belum aktif:
   ```
   Start-Process -FilePath "C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqld.exe" -ArgumentList "--defaults-file=C:\laragon\bin\mysql\mysql-8.0.30-winx64\my.ini","--console" -WindowStyle Hidden
   ```
3. **Git branching**: Selalu buat `feature/*` branch baru dari `develop` sebelum mulai coding fitur baru.
4. **PowerShell**: Gunakan `;` bukan `&&` untuk menggabungkan perintah. Gunakan `&` untuk invoke executable dengan path yang mengandung spasi.

---

## 📝 Log Perubahan

| Tanggal | Fase | Aksi |
|---|---|---|
| 2026-05-28 | Phase 1 | Inisialisasi project Laravel 13, install semua dependensi |
| 2026-05-28 | Phase 1 | Buat 8 migration files + jalankan semua migration |
| 2026-05-28 | Phase 1 | Buat 8 Eloquent Model + RoleMiddleware |
| 2026-05-28 | Phase 1 | Konfigurasi Midtrans, API routes, bootstrap/app.php |
| 2026-05-28 | Phase 1 | Buat & jalankan semua Seeder (SuperAdmin, Kategori, Produk) |
| 2026-05-28 | Phase 1 | Git init, buat branch main & develop, commit awal |
| 2026-05-28 | Phase 1 | Hubungkan ke GitHub (remote origin) |
| 2026-05-28 | Phase 2 | *(Akan dimulai)* |

---

*Terakhir diupdate: 2026-05-28 oleh Agent (Phase 1 → Phase 2 transition)*
