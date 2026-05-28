# 📋 Product Requirements Document (PRD)
## JAFAPP — Sistem Informasi Pemesanan & Manajemen Produksi Jati Akbar Furniture

---

> **Versi**: 1.1.0
> **Tanggal**: Mei 2026
> **Project Manager**: Muhammad Arju Ridho Maulana
> **Status**: Draft — Pending Approval
> **Referensi Dokumen**: Project Charter JAFAPP v1.0
> **Changelog v1.1.0**: Mengubah pendekatan autentikasi customer dari "wajib registrasi" menjadi **"Login Opsional — Auto Guest Account"**. Pelanggan dapat memesan tanpa registrasi manual; sistem otomatis membuat guest account dan mengirim kredensial via email. Berdampak pada: Section 4, 5, 6, 8, 9, 12, 15.

---

## 📑 Daftar Isi

1. [Ringkasan Eksekutif](#1-ringkasan-eksekutif)
2. [Konteks Bisnis & Latar Belakang](#2-konteks-bisnis--latar-belakang)
3. [Tujuan Produk & Success Metrics](#3-tujuan-produk--success-metrics)
4. [User Roles & Personas](#4-user-roles--personas)
5. [User Stories](#5-user-stories)
6. [Functional Requirements](#6-functional-requirements)
7. [Non-Functional Requirements](#7-non-functional-requirements)
8. [ERD & Database Schema](#8-erd--database-schema)
9. [API Specification](#9-api-specification)
10. [Integrasi Midtrans — Detail Teknis](#10-integrasi-midtrans--detail-teknis)
11. [Wireframe Notes & UI Guidelines](#11-wireframe-notes--ui-guidelines)
12. [Acceptance Criteria per Fitur](#12-acceptance-criteria-per-fitur)
13. [Out of Scope](#13-out-of-scope)
14. [Assumptions & Dependencies](#14-assumptions--dependencies)
15. [Glossary](#15-glossary)

---

## 1. Ringkasan Eksekutif

JAFAPP adalah sistem informasi berbasis web responsif yang dikembangkan untuk **Jati Akbar Furniture**, sebuah usaha produksi furniture kayu jati di Jepara, Jawa Tengah. Sistem ini mendigitalisasi seluruh alur operasional bisnis — dari pemesanan pelanggan, pengelolaan produksi, pembayaran digital, hingga pelaporan — menggantikan proses manual berbasis buku catatan dan WhatsApp.

Sistem ini dibangun dengan pendekatan **MVP (Minimum Viable Product) yang fully functional**, menggunakan stack Laravel 11 + Blade + TailwindCSS + MySQL, dan diintegrasikan dengan payment gateway **Midtrans**.

Sistem mengadopsi pendekatan **"Login Opsional — Auto Guest Account"**: pelanggan tidak diwajibkan membuat akun secara manual. Cukup mengisi nama, email, dan nomor HP saat checkout — sistem otomatis membuat guest account dan mengirimkan kredensial login ke email pelanggan. Pelanggan bebas mengaktifkan akun tersebut kapanpun untuk mengakses riwayat pesanan dan fitur tambahan.

---

## 2. Konteks Bisnis & Latar Belakang

### 2.1 Profil Klien

| Atribut | Detail |
|---|---|
| Nama Usaha | Jati Akbar Furniture |
| Lokasi | Jepara, Jawa Tengah, Indonesia |
| Bidang | Produksi furniture berbahan kayu jati |
| Direktur / Sponsor | Renaldi Akbar Khana |
| Project Manager | Muhammad Arju Ridho Maulana |

### 2.2 Pain Points yang Diselesaikan

| # | Masalah Saat Ini | Dampak Bisnis |
|---|---|---|
| 1 | Pemesanan & pencatatan produksi masih manual (buku + WhatsApp) | Potensi data hilang, kesalahan pencatatan |
| 2 | Tidak ada transparansi status produksi ke pelanggan | Pelanggan sering menghubungi manual untuk cek status |
| 3 | Koordinasi internal tidak terpusat | Antar tim sering miskomunikasi soal prioritas pesanan |
| 4 | Laporan direkap manual | Butuh waktu lama, rawan human error |
| 5 | Tidak ada sistem pembayaran digital | Proses pembayaran lambat & tidak terdokumentasi otomatis |

### 2.3 Solusi yang Ditawarkan

Sistem JAFAPP menyediakan platform terintegrasi yang memungkinkan:
- Pelanggan memesan, membayar, dan memantau produksi secara mandiri via web.
- Admin mengelola produk, pesanan, dan status produksi dari satu dashboard.
- Owner mendapatkan laporan bisnis otomatis tanpa rekap manual.

---

## 3. Tujuan Produk & Success Metrics

### 3.1 Tujuan Produk

| Kategori | Tujuan |
|---|---|
| **Bisnis** | Meningkatkan efisiensi operasional dan kepuasan pelanggan melalui digitalisasi |
| **Teknis** | Membangun sistem web responsif yang reliable, aman, dan mudah di-maintain |
| **User Experience** | Memudahkan pelanggan memesan dan memantau produksi tanpa perlu telepon/WhatsApp |

### 3.2 Success Metrics / KPI

| Metrik | Target | Cara Ukur |
|---|---|---|
| Waktu proses pesanan manual vs digital | Turun ≥ 70% | Perbandingan waktu rata-rata sebelum & sesudah |
| Tingkat keluhan pelanggan terkait status produksi | Turun ≥ 60% | Jumlah pertanyaan manual ke admin per bulan |
| Akurasi pencatatan pesanan | ≥ 99% | Jumlah error/discrepancy data per bulan |
| Uptime sistem | ≥ 99% | Monitoring server |
| Waktu load halaman (page load time) | < 3 detik | Lighthouse / GTMetrix |
| Pembayaran berhasil diproses via Midtrans | ≥ 95% success rate | Midtrans dashboard |
| Admin dapat generate laporan bulanan | < 1 menit | User acceptance test |
| Sistem responsive di mobile (Chrome & Safari) | 100% fitur utama accessible | Manual QA test |

---

## 4. User Roles & Personas

### 4.1 Role Overview

| Role | Deskripsi | Akses Level |
|---|---|---|
| **Guest / Tamu** | Pengunjung yang belum pernah pesan — akses katalog & informasi publik | Public only |
| **Pelanggan — Guest Account** | Customer yang checkout tanpa registrasi manual; akun otomatis dibuat sistem | Authenticated (terbatas) |
| **Pelanggan — Akun Aktif** | Customer yang sudah aktivasi akun via email | Authenticated (penuh) |
| **Admin** | Staff internal yang mengelola sistem | Authenticated — Admin panel |
| **Super Admin / Owner** | Pemilik bisnis dengan akses penuh | Authenticated — Full access |

> **Catatan**: "Guest Account" dan "Akun Aktif" keduanya menggunakan tabel `users` yang sama. Perbedaannya hanya pada kolom `is_guest` dan `email_verified_at`. Secara teknis, tidak ada perbedaan struktur data — hanya perbedaan status aktivasi.

### 4.2 Personas

#### 🧑 Persona 1: Pelanggan — "Budi, Pelanggan Repeat Order"
- **Usia**: 35 tahun, wiraswasta di Semarang
- **Kebutuhan**: Pesan kursi kayu jati custom untuk rumah barunya, mau bayar transfer, dan ingin tahu kapan barangnya jadi tanpa harus tanya-tanya
- **Frustrasi saat ini**: Harus chat WhatsApp bolak-balik untuk tanya status; malas buat akun baru di setiap platform
- **Goal**: Bisa pesan dan bayar hanya dengan isi email & HP — tanpa perlu registrasi panjang. Tapi tetap bisa pantau status produksi kapanpun.

#### 👩‍💼 Persona 2: Admin — "Sari, Staff Operasional"
- **Usia**: 28 tahun, karyawan Jati Akbar
- **Kebutuhan**: Update status produksi pesanan dengan cepat, lihat antrian pesanan yang harus diproses
- **Frustrasi saat ini**: Sering salah rekap pesanan karena datanya di banyak tempat
- **Goal**: Semua data pesanan & produksi ada di satu tempat, mudah diupdate

#### 👨‍💼 Persona 3: Owner — "Renaldi, Direktur"
- **Usia**: 42 tahun, pemilik bisnis
- **Kebutuhan**: Lihat laporan pendapatan bulanan, pantau kinerja bisnis, kelola akun staf
- **Frustrasi saat ini**: Laporan harus minta manual ke staf, data sering terlambat
- **Goal**: Dashboard yang langsung menampilkan kondisi bisnis secara real-time

---

## 5. User Stories

### 5.1 Pelanggan (Customer)

| ID | User Story | Priority |
|---|---|---|
| US-C01 | Sebagai pelanggan, saya ingin melihat katalog produk beserta foto, deskripsi, dan harga, agar saya bisa memilih produk yang sesuai kebutuhan saya. | High |
| US-C02 | Sebagai pelanggan, saya ingin bisa filter dan search produk berdasarkan kategori dan nama, agar saya lebih mudah menemukan produk yang dicari. | High |
| US-C03 | Sebagai pelanggan, saya ingin melakukan pemesanan **tanpa harus membuat akun terlebih dahulu** — cukup mengisi nama, email, dan nomor HP saat checkout, agar proses pesan menjadi cepat dan tidak ada hambatan. | High |
| US-C04 | Sebagai pelanggan yang checkout sebagai tamu, saya ingin menerima **email konfirmasi otomatis** berisi nomor pesanan, detail transaksi, dan link tracking, agar saya tidak kehilangan informasi pesanan saya. | High |
| US-C05 | Sebagai pelanggan yang checkout sebagai tamu, saya ingin menerima **email berisi kredensial akun** yang otomatis dibuat sistem, agar saya bisa login kapanpun untuk melihat riwayat pesanan tanpa harus input ulang data. | High |
| US-C06 | Sebagai pelanggan, saya ingin mengajukan custom order, agar saya bisa mendapatkan furniture sesuai desain saya. | High |
| US-C07 | Sebagai pelanggan, saya ingin membayar pesanan secara digital (transfer, e-wallet, QRIS), agar proses pembayaran lebih mudah dan cepat. | High |
| US-C08 | Sebagai pelanggan, saya ingin memantau status produksi pesanan saya **tanpa perlu login** — cukup menggunakan nomor pesanan, agar saya tahu kapan barang saya selesai. | High |
| US-C09 | Sebagai pelanggan yang sudah aktivasi akun, saya ingin melihat **seluruh riwayat pesanan** saya di satu halaman, termasuk pesanan yang dibuat saat guest, agar saya tidak perlu ingat-ingat nomor pesanan lama. | Medium |
| US-C10 | Sebagai pelanggan yang sudah aktivasi akun, saya ingin bisa **mengubah password** akun saya, agar keamanan akun saya terjaga. | Medium |
| US-C11 | Sebagai pelanggan, saya ingin melihat profil dan kontak Jati Akbar Furniture, agar saya bisa menghubungi mereka jika diperlukan. | Low |

### 5.2 Admin

| ID | User Story | Priority |
|---|---|---|
| US-A01 | Sebagai admin, saya ingin melihat dashboard ringkasan (total pesanan, pendapatan, pesanan pending), agar saya bisa langsung mengetahui kondisi operasional hari ini. | High |
| US-A02 | Sebagai admin, saya ingin menambah, mengedit, dan menonaktifkan produk beserta foto, agar katalog selalu up-to-date. | High |
| US-A03 | Sebagai admin, saya ingin melihat daftar semua pesanan dengan filter status dan tanggal, agar saya bisa memprioritaskan pesanan yang perlu diproses. | High |
| US-A04 | Sebagai admin, saya ingin memperbarui status tahapan produksi beserta catatan dan foto progress, agar pelanggan dapat melihat update yang akurat. | High |
| US-A05 | Sebagai admin, saya ingin melihat dan memproses custom order yang masuk (approve/reject), agar hanya order yang valid yang masuk ke antrian produksi. | High |
| US-A06 | Sebagai admin, saya ingin melihat laporan penjualan dengan filter tanggal, agar saya bisa memberikan laporan kepada owner dengan cepat. | Medium |
| US-A07 | Sebagai admin, saya ingin mengunduh laporan dalam format PDF atau Excel, agar laporan bisa disimpan atau dibagikan secara offline. | Medium |

### 5.3 Super Admin / Owner

| ID | User Story | Priority |
|---|---|---|
| US-SA01 | Sebagai owner, saya ingin melihat dashboard analytics bisnis (pendapatan, tren pesanan, produk terlaris), agar saya bisa mengambil keputusan bisnis berbasis data. | High |
| US-SA02 | Sebagai owner, saya ingin mengelola akun user dan staf (tambah, nonaktifkan, ubah role), agar keamanan akses sistem tetap terjaga. | High |
| US-SA03 | Sebagai owner, saya ingin melihat laporan penjualan dan produksi lengkap, agar saya bisa memantau kinerja bisnis secara menyeluruh. | High |
| US-SA04 | Sebagai owner, saya ingin mendapatkan semua akses yang dimiliki admin, agar saya bisa mengambil alih tugas admin jika diperlukan. | High |

---

## 6. Functional Requirements

### 6.1 Modul A — Autentikasi & Manajemen User

#### A.1 — Alur Guest Checkout (Auto Account Creation)

```
[Pelanggan klik "Pesan" di halaman produk]
              │
              ▼
  [Form Checkout: Nama + Email + HP + Alamat]
              │
              ▼
  [Apakah email sudah terdaftar di sistem?]
       │                    │
      Ya                  Tidak
       │                    │
  [Auto-login           [Sistem buat
   session guest]        guest account:
       │                 - password random (bcrypt)
       │                 - is_guest = true
       │                 - email belum terverifikasi]
       │                    │
       └────────┬───────────┘
                ▼
    [Order dibuat, terhubung ke user_id]
                │
                ▼
    [Kirim 2 email via Laravel Queue:]
    1. Email konfirmasi pesanan + nomor order + link tracking
    2. Email kredensial akun (username: email, password sementara)
       + CTA "Aktifkan Akun Saya"
```

| ID | Requirement | Role |
|---|---|---|
| FR-AUTH-01 | Sistem menyediakan form checkout publik dengan field wajib: nama lengkap, email, nomor HP, alamat pengiriman | Guest |
| FR-AUTH-02 | Jika email belum terdaftar, sistem otomatis membuat akun baru dengan flag `is_guest = true` dan password random yang di-hash | System |
| FR-AUTH-03 | Jika email sudah terdaftar (akun aktif), sistem meminta pelanggan login terlebih dahulu sebelum checkout — tidak membuat akun duplikat | System |
| FR-AUTH-04 | Jika email sudah terdaftar sebagai guest account, sistem menggunakan akun yang sudah ada (tidak membuat duplikat), dan mengirim ulang email konfirmasi | System |
| FR-AUTH-05 | Setelah order dibuat, sistem mengirim **dua email terpisah** via Laravel Queue: (1) konfirmasi pesanan, (2) kredensial akun + link aktivasi | System |
| FR-AUTH-06 | Link aktivasi akun berlaku selama **7 hari** sejak dikirim | System |
| FR-AUTH-07 | Ketika pelanggan klik link aktivasi, sistem meminta pelanggan **membuat password baru** — setelah itu `is_guest = false` dan `email_verified_at` diisi | Customer |
| FR-AUTH-08 | Sistem menyediakan halaman login untuk pelanggan yang sudah aktivasi akun | Customer |
| FR-AUTH-09 | Sistem menyediakan fitur **"Kirim ulang email aktivasi"** di halaman login, bagi pelanggan yang belum aktivasi | Customer |
| FR-AUTH-10 | Sistem menyediakan fitur **forgot password** via email (hanya untuk akun yang sudah aktif) | Customer |
| FR-AUTH-11 | Sistem mengimplementasikan RBAC: `customer`, `admin`, `superadmin` | Semua |
| FR-AUTH-12 | Sistem mencegah customer mengakses route admin, dan sebaliknya | System |
| FR-AUTH-13 | Super Admin dapat membuat akun admin baru, mengedit role, dan menonaktifkan akun | Super Admin |
| FR-AUTH-14 | Login throttle: maksimal 5 percobaan gagal → akun dikunci 15 menit | System |

### 6.2 Modul B — Katalog Produk

| ID | Requirement | Role |
|---|---|---|
| FR-CAT-01 | Sistem menampilkan daftar produk aktif dengan foto, nama, kategori, harga, dan deskripsi singkat | Public |
| FR-CAT-02 | Sistem menyediakan halaman detail produk dengan foto galeri, deskripsi lengkap, dimensi, dan harga | Public |
| FR-CAT-03 | Sistem menyediakan fitur filter produk berdasarkan kategori | Public |
| FR-CAT-04 | Sistem menyediakan fitur search produk berdasarkan nama | Public |
| FR-CAT-05 | Admin dapat menambah produk baru dengan upload maksimal 5 foto | Admin, SA |
| FR-CAT-06 | Admin dapat mengedit data produk yang sudah ada | Admin, SA |
| FR-CAT-07 | Admin dapat menonaktifkan produk (soft delete — produk tidak tampil di catalog tapi data tersimpan) | Admin, SA |
| FR-CAT-08 | Admin dapat mengelola kategori produk (tambah, edit, hapus) | Admin, SA |

### 6.3 Modul C — Pemesanan (Order)

| ID | Requirement | Role |
|---|---|---|
| FR-ORD-01 | Pelanggan dapat melakukan pemesanan **tanpa login** — form checkout tersedia secara publik | Guest, Customer |
| FR-ORD-02 | Form checkout wajib mengisi: nama, email, nomor HP, alamat pengiriman, dan catatan (opsional) | Guest, Customer |
| FR-ORD-03 | Sistem men-generate nomor pesanan unik dengan format `JAF-YYYYMMDD-XXXX` | System |
| FR-ORD-04 | Sistem menampilkan halaman ringkasan pesanan (produk, jumlah, total, alamat) sebelum proses pembayaran | Guest, Customer |
| FR-ORD-05 | Sistem mencatat semua item pesanan ke tabel `order_items` | System |
| FR-ORD-06 | Setelah order berhasil dibuat, sistem mengirim email konfirmasi otomatis ke email pelanggan berisi: nomor pesanan, detail item, total, dan link tracking | System |
| FR-ORD-07 | Pelanggan dengan akun aktif dapat melihat seluruh riwayat pesanan di halaman profil — termasuk pesanan yang dibuat saat masih guest (terhubung via email) | Customer |
| FR-ORD-08 | Admin dapat melihat seluruh daftar pesanan dengan filter: status, tanggal, tipe pesanan, termasuk pesanan dari guest account | Admin, SA |
| FR-ORD-09 | Admin dapat melihat detail pesanan termasuk data pelanggan (nama, email, HP), item, dan riwayat produksi | Admin, SA |
| FR-ORD-10 | Kolom `guest_name`, `guest_email`, `guest_phone` di tabel `orders` diisi untuk pesanan tanpa login; jika sudah login, cukup `user_id` | System |

### 6.4 Modul D — Custom Order

> **Catatan Desain**: Custom order memerlukan komunikasi bolak-balik yang intensif (admin review → harga → approval → bayar). Oleh karena itu, custom order **hanya bisa diajukan oleh pelanggan dengan akun aktif** (sudah aktivasi email). Sistem akan mengarahkan pelanggan yang belum aktivasi untuk mengaktifkan akunnya terlebih dahulu — dengan UX yang tidak terasa sebagai "hambatan" tapi sebagai "keuntungan tambahan".

| ID | Requirement | Role |
|---|---|---|
| FR-CO-01 | Custom order hanya bisa diajukan oleh pelanggan yang sudah **login dengan akun aktif** (email terverifikasi) | Customer (aktif) |
| FR-CO-02 | Jika guest mencoba akses halaman custom order, sistem menampilkan pesan informatif: *"Untuk mengajukan custom order, silakan aktifkan akun Anda terlebih dahulu. Cek email [xxx] untuk link aktivasi."* | Guest |
| FR-CO-03 | Form custom order mengandung field: deskripsi produk, dimensi (P x L x T), material, finishing, warna, catatan tambahan | Customer (aktif) |
| FR-CO-04 | Pelanggan dapat mengupload foto referensi desain (maks 3 file, format JPG/PNG/PDF, maks 5MB per file) | Customer (aktif) |
| FR-CO-05 | Setelah diajukan, status custom order adalah `submitted` dan pelanggan menerima email konfirmasi pengajuan | System |
| FR-CO-06 | Admin dapat melihat list custom order beserta detail spesifikasi dan lampiran | Admin, SA |
| FR-CO-07 | Admin dapat Approve atau Reject custom order disertai catatan alasan | Admin, SA |
| FR-CO-08 | Jika diapprove, admin mengisi harga yang disepakati → sistem membuat order baru tipe `custom` yang terhubung ke custom order ini | Admin, SA |
| FR-CO-09 | Pelanggan mendapat notifikasi email ketika status custom order berubah (diajukan, disetujui, ditolak) | System |
| FR-CO-10 | Pelanggan dapat melihat status custom order di halaman riwayat (setelah login) | Customer (aktif) |

### 6.5 Modul E — Pembayaran (Midtrans)

| ID | Requirement | Role |
|---|---|---|
| FR-PAY-01 | Sistem mengintegrasikan Midtrans Snap untuk proses pembayaran popup | System |
| FR-PAY-02 | Sistem mendukung metode: Transfer Bank, Virtual Account, GoPay, OVO, Dana, QRIS | Customer |
| FR-PAY-03 | Setelah checkout, sistem men-generate Snap Token dari Midtrans dan menampilkan popup pembayaran | System |
| FR-PAY-04 | Sistem memiliki endpoint webhook untuk menerima notifikasi callback dari Midtrans | System |
| FR-PAY-05 | Status pembayaran diperbarui otomatis berdasarkan callback Midtrans: `pending` → `paid` / `failed` / `expired` | System |
| FR-PAY-06 | Sistem memverifikasi signature key pada setiap callback Midtrans sebelum memproses update status | System |
| FR-PAY-07 | Pelanggan dapat melihat status pembayaran di halaman detail pesanan | Customer |
| FR-PAY-08 | Admin dapat melihat riwayat dan status pembayaran setiap pesanan | Admin, SA |

### 6.6 Modul F — Tracking Produksi

| ID | Requirement | Role |
|---|---|---|
| FR-TRACK-01 | Sistem menyediakan alur status produksi: `Order Diterima` → `Persiapan Bahan` → `Proses Produksi` → `Finishing` → `Quality Check` → `Siap Kirim` → `Selesai` | System |
| FR-TRACK-02 | Pelanggan dapat mengakses halaman tracking produksi **tanpa login** menggunakan nomor pesanan | Public |
| FR-TRACK-03 | Halaman tracking menampilkan timeline visual alur status produksi dengan highlight status aktif | Public |
| FR-TRACK-04 | Admin dapat memperbarui status produksi per pesanan disertai catatan dan foto progress (opsional) | Admin, SA |
| FR-TRACK-05 | Setiap perubahan status produksi dicatat di tabel `production_logs` beserta user yang mengupdate dan timestamp | System |
| FR-TRACK-06 | Pelanggan yang login dapat melihat tracking langsung dari halaman riwayat pesanan | Customer |

### 6.7 Modul G — Dashboard Admin

| ID | Requirement | Role |
|---|---|---|
| FR-DASH-01 | Dashboard menampilkan KPI ringkasan: total pesanan hari ini, total pendapatan bulan ini, pesanan pending, produksi berjalan | Admin, SA |
| FR-DASH-02 | Dashboard menampilkan tabel pesanan terbaru dengan kolom: nomor pesanan, pelanggan, status, total, tanggal | Admin, SA |
| FR-DASH-03 | Dashboard menampilkan grafik tren pesanan 30 hari terakhir | SA |
| FR-DASH-04 | Admin dapat memfilter tabel pesanan berdasarkan: status, tipe (reguler/custom), dan rentang tanggal | Admin, SA |

### 6.8 Modul H — Laporan Sistem

| ID | Requirement | Role |
|---|---|---|
| FR-RPT-01 | Sistem menyediakan laporan penjualan dengan filter: harian, bulanan, rentang tanggal custom | Admin, SA |
| FR-RPT-02 | Laporan penjualan menampilkan: jumlah pesanan, total pendapatan, breakdown per metode pembayaran | Admin, SA |
| FR-RPT-03 | Sistem menyediakan laporan produksi: pesanan selesai, sedang berjalan, per tahapan | Admin, SA |
| FR-RPT-04 | Laporan dapat diexport ke PDF | Admin, SA |
| FR-RPT-05 | Laporan dapat diexport ke Excel (.xlsx) | Admin, SA |

### 6.9 Modul I — Halaman Informasi (About)

| ID | Requirement | Role |
|---|---|---|
| FR-ABT-01 | Halaman About menampilkan profil bisnis Jati Akbar Furniture | Public |
| FR-ABT-02 | Halaman menampilkan informasi kontak (nomor telepon, email, alamat) | Public |
| FR-ABT-03 | Halaman menampilkan embed Google Maps lokasi toko | Public |
| FR-ABT-04 | Halaman menampilkan galeri produk / portofolio unggulan | Public |

---

## 7. Non-Functional Requirements

### 7.1 Performa

| ID | Requirement | Target |
|---|---|---|
| NFR-PERF-01 | Page load time halaman utama (catalog) | < 3 detik pada koneksi 4G |
| NFR-PERF-02 | Response time API internal (CRUD operations) | < 500ms |
| NFR-PERF-03 | Response time Midtrans Snap Token generation | < 5 detik |
| NFR-PERF-04 | Query database harus menggunakan index pada kolom yang sering difilter | — |

### 7.2 Keamanan

| ID | Requirement |
|---|---|
| NFR-SEC-01 | Password di-hash menggunakan bcrypt (default Laravel) |
| NFR-SEC-02 | Semua form menggunakan CSRF token (Laravel default) |
| NFR-SEC-03 | Input user divalidasi di sisi server sebelum diproses (Laravel Form Validation) |
| NFR-SEC-04 | File upload divalidasi: tipe file (JPG, PNG, PDF), ukuran maksimal, virus scan tidak wajib tapi extension validation ketat |
| NFR-SEC-05 | Midtrans callback diverifikasi menggunakan signature key sebelum update status |
| NFR-SEC-06 | Route admin dilindungi middleware `auth` + `role:admin` |
| NFR-SEC-07 | Data sensitif (server key, client key Midtrans) disimpan di `.env`, tidak di-commit ke repository |
| NFR-SEC-08 | SQL Injection dicegah dengan Eloquent ORM / Query Builder Laravel |
| NFR-SEC-09 | XSS dicegah dengan Blade templating engine (auto-escape) |

### 7.3 Reliability & Availability

| ID | Requirement | Target |
|---|---|---|
| NFR-REL-01 | Uptime sistem | ≥ 99% / bulan |
| NFR-REL-02 | Database backup otomatis | Harian |
| NFR-REL-03 | Error handling: semua exception ditangkap dan di-log, tidak menampilkan error stack ke user | — |
| NFR-REL-04 | Laravel Queue digunakan untuk proses notifikasi email agar tidak memblokir HTTP response | — |

### 7.4 Usability

| ID | Requirement |
|---|---|
| NFR-UX-01 | Sistem harus responsive dan fully functional di layar mobile (min width: 375px) |
| NFR-UX-02 | Sistem harus kompatibel dengan Chrome (mobile & desktop) dan Safari (mobile) versi terbaru |
| NFR-UX-03 | Semua teks dan label menggunakan Bahasa Indonesia |
| NFR-UX-04 | Pesan error pada form harus jelas dan spesifik (tidak cukup hanya "Input tidak valid") |
| NFR-UX-05 | Loading state / spinner ditampilkan saat ada proses async (misal: generate Snap Token) |

### 7.5 Maintainability

| ID | Requirement |
|---|---|
| NFR-MAINT-01 | Kode mengikuti konvensi PSR-12 untuk PHP |
| NFR-MAINT-02 | Logic bisnis dipisahkan dari Controller ke Service layer (khususnya MidtransService) |
| NFR-MAINT-03 | Semua konfigurasi environment ada di file `.env` |
| NFR-MAINT-04 | Database migrations menggunakan Laravel Migrations (tidak ada perubahan manual di database) |
| NFR-MAINT-05 | Version control menggunakan Git dengan branching strategy (minimal: `main`, `develop`, `feature/*`) |

---

## 8. ERD & Database Schema

### 8.1 Entity Relationship Diagram (Deskripsi)

```
users ─────────────┬── orders (1:N)
                   └── custom_orders (1:N)

orders ─────────────┬── order_items (1:N)
                   ├── custom_orders (1:1, opsional)
                   ├── payments (1:1)
                   └── production_logs (1:N)

products ──────────── order_items (1:N)
products ──────────── categories (N:1)
```

### 8.2 Tabel Detail

#### `users`
```sql
CREATE TABLE users (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name                VARCHAR(100) NOT NULL,
    email               VARCHAR(150) NOT NULL UNIQUE,
    password            VARCHAR(255) NOT NULL,
    role                ENUM('customer', 'admin', 'superadmin') DEFAULT 'customer',
    phone               VARCHAR(20) NULLABLE,
    address             TEXT NULLABLE,
    is_active           BOOLEAN DEFAULT TRUE,
    is_guest            BOOLEAN DEFAULT FALSE,          -- TRUE jika dibuat via auto guest checkout
    activation_token    VARCHAR(100) NULLABLE,          -- token link aktivasi akun
    activation_token_expires_at TIMESTAMP NULLABLE,    -- expired 7 hari sejak dibuat
    email_verified_at   TIMESTAMP NULLABLE,             -- NULL = belum aktivasi
    remember_token      VARCHAR(100) NULLABLE,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### `categories`
```sql
CREATE TABLE categories (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(100) NOT NULL UNIQUE,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### `products`
```sql
CREATE TABLE products (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id     BIGINT UNSIGNED NOT NULL,
    name            VARCHAR(200) NOT NULL,
    slug            VARCHAR(200) NOT NULL UNIQUE,
    description     TEXT NULLABLE,
    dimensions      VARCHAR(100) NULLABLE,   -- contoh: "120x60x75 cm"
    price           DECIMAL(15,2) NOT NULL,
    stock           INT DEFAULT 0,
    images          JSON NULLABLE,           -- array path gambar
    is_active       BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
);
```

#### `orders`
```sql
CREATE TABLE orders (
    id               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id          BIGINT UNSIGNED NULLABLE,           -- NULL jika order dibuat sebelum akun dibuat (edge case), normalnya selalu ada
    order_number     VARCHAR(30) NOT NULL UNIQUE,        -- format: JAF-YYYYMMDD-XXXX
    type             ENUM('regular', 'custom') DEFAULT 'regular',
    status           ENUM(
                         'pending_payment',
                         'payment_confirmed',
                         'order_received',
                         'material_preparation',
                         'in_production',
                         'finishing',
                         'quality_check',
                         'ready_to_ship',
                         'completed',
                         'cancelled'
                     ) DEFAULT 'pending_payment',
    total_amount     DECIMAL(15,2) NOT NULL,
    shipping_address TEXT NOT NULL,
    -- Kolom guest info (di-copy dari user saat order dibuat, sebagai snapshot):
    guest_name       VARCHAR(100) NULLABLE,
    guest_email      VARCHAR(150) NULLABLE,
    guest_phone      VARCHAR(20) NULLABLE,
    notes            TEXT NULLABLE,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT
);
```

> **Catatan**: Kolom `guest_name`, `guest_email`, `guest_phone` berfungsi sebagai **snapshot data kontak** saat order dibuat — terlepas apakah pelanggan guest atau akun aktif. Ini penting agar data pesanan tidak berubah jika pelanggan mengedit profilnya di kemudian hari.

#### `order_items`
```sql
CREATE TABLE order_items (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id    BIGINT UNSIGNED NOT NULL,
    product_id  BIGINT UNSIGNED NOT NULL,
    qty         INT NOT NULL DEFAULT 1,
    price       DECIMAL(15,2) NOT NULL,        -- harga saat transaksi (snapshot)
    subtotal    DECIMAL(15,2) NOT NULL,
    notes       TEXT NULLABLE,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);
```

#### `custom_orders`
```sql
CREATE TABLE custom_orders (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    order_id        BIGINT UNSIGNED NULLABLE,     -- diisi setelah admin approve
    description     TEXT NOT NULL,
    dimensions      VARCHAR(100) NULLABLE,
    material        VARCHAR(100) NULLABLE,
    finishing       VARCHAR(100) NULLABLE,
    color           VARCHAR(50) NULLABLE,
    ref_images      JSON NULLABLE,               -- array path file referensi
    admin_notes     TEXT NULLABLE,
    agreed_price    DECIMAL(15,2) NULLABLE,      -- diisi admin saat approve
    status          ENUM(
                        'submitted',
                        'under_review',
                        'approved',
                        'rejected',
                        'converted_to_order'
                    ) DEFAULT 'submitted',
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
);
```

#### `payments`
```sql
CREATE TABLE payments (
    id                        BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id                  BIGINT UNSIGNED NOT NULL UNIQUE,
    midtrans_transaction_id   VARCHAR(100) NULLABLE UNIQUE,
    snap_token                VARCHAR(255) NULLABLE,
    payment_type              VARCHAR(50) NULLABLE,   -- gopay, bank_transfer, qris, dst
    amount                    DECIMAL(15,2) NOT NULL,
    status                    ENUM('pending', 'paid', 'failed', 'expired', 'refunded') DEFAULT 'pending',
    paid_at                   TIMESTAMP NULLABLE,
    raw_response              JSON NULLABLE,          -- simpan full response Midtrans
    created_at                TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at                TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE RESTRICT
);
```

#### `production_logs`
```sql
CREATE TABLE production_logs (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id    BIGINT UNSIGNED NOT NULL,
    status      ENUM(
                    'order_received',
                    'material_preparation',
                    'in_production',
                    'finishing',
                    'quality_check',
                    'ready_to_ship',
                    'completed'
                ) NOT NULL,
    notes       TEXT NULLABLE,
    photo       VARCHAR(255) NULLABLE,    -- path foto progress
    updated_by  BIGINT UNSIGNED NOT NULL, -- FK ke users (admin yang update)
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE RESTRICT
);
```

### 8.3 Index yang Direkomendasikan

```sql
-- orders
CREATE INDEX idx_orders_user_id ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_orders_created_at ON orders(created_at);

-- order_items
CREATE INDEX idx_order_items_order_id ON order_items(order_id);

-- production_logs
CREATE INDEX idx_prod_logs_order_id ON production_logs(order_id);

-- products
CREATE INDEX idx_products_category_id ON products(category_id);
CREATE INDEX idx_products_is_active ON products(is_active);

-- payments
CREATE INDEX idx_payments_status ON payments(status);
```

---

## 9. API Specification

> Sistem menggunakan arsitektur **full-stack monolith** (Laravel Blade). Sebagian besar interaksi melalui form submission biasa. API JSON hanya digunakan untuk kebutuhan spesifik berikut.

### 9.1 Konvensi Umum

- **Base URL**: `https://[domain]/api`
- **Content-Type**: `application/json`
- **Auth**: Session-based (Laravel Sanctum / Breeze untuk web), atau `Bearer Token` jika diperlukan endpoint terpisah
- **Response format**:
```json
{
  "success": true,
  "message": "Pesan deskriptif",
  "data": { }
}
```

### 9.2 Endpoint: Midtrans Webhook (Callback)

```
POST /api/midtrans/callback
```

**Headers:**
```
Content-Type: application/json
```

**Request Body (dari Midtrans):**
```json
{
  "transaction_time": "2026-06-15 14:30:00",
  "transaction_status": "settlement",
  "transaction_id": "abc123-def456",
  "status_message": "midtrans payment notification",
  "status_code": "200",
  "signature_key": "hash_string_dari_midtrans",
  "payment_type": "gopay",
  "order_id": "JAF-20260615-0001",
  "gross_amount": "2500000.00",
  "fraud_status": "accept"
}
```

**Logic Handler:**
```
1. Validasi signature_key:
   SHA512(order_id + status_code + gross_amount + server_key)
2. Jika signature valid → update payments.status berdasarkan transaction_status
3. Jika transaction_status = "settlement" atau "capture":
   → payments.status = 'paid'
   → payments.paid_at = sekarang
   → orders.status = 'order_received'
4. Jika transaction_status = "expire":
   → payments.status = 'expired'
   → orders.status = 'cancelled'
5. Jika transaction_status = "cancel" atau "deny":
   → payments.status = 'failed'
6. Return HTTP 200 OK (wajib, agar Midtrans tidak retry)
```

**Response:**
```json
HTTP 200 OK
{ "message": "OK" }
```

### 9.3 Endpoint: Generate Snap Token

```
POST /checkout/{orderId}/snap-token
```
> Route web, dipanggil via AJAX dari halaman checkout.

**Auth**: User harus terautentikasi (guest account atau akun aktif) dan memiliki order tersebut. Sistem memverifikasi `order.user_id === auth()->id()`.

**Response Success:**
```json
{
  "success": true,
  "snap_token": "token_string_dari_midtrans"
}
```

**Response Error:**
```json
{
  "success": false,
  "message": "Gagal membuat token pembayaran."
}
```

### 9.4 Endpoint: Checkout (Guest & Authenticated)

```
POST /checkout
```

**Auth**: Tidak wajib login. Sistem mendeteksi otomatis.

**Request Body (form submission):**
```
name             : string (required)
email            : string (required, valid email)
phone            : string (required)
shipping_address : string (required)
product_id       : integer (required)
qty              : integer (required, min:1)
notes            : string (optional)
```

**Logic Server:**
```
1. Validasi semua input
2. Cek email di tabel users:
   a. Tidak ada → buat guest account (is_guest=true, password=Str::random(16), bcrypt)
                  → simpan activation_token + activation_token_expires_at (+ 7 hari)
   b. Ada, is_guest=true → gunakan akun yang sudah ada
   c. Ada, email_verified_at NOT NULL → redirect ke halaman login dengan pesan:
      "Email ini sudah terdaftar. Silakan login untuk melanjutkan."
3. Login otomatis user ke session (Auth::login())
4. Buat order + order_items + payment record (status: pending)
5. Dispatch ke Queue:
   - SendOrderConfirmationEmail (nomor order, detail, link tracking)
   - SendGuestCredentialsEmail (hanya jika akun BARU dibuat di step 2a)
6. Redirect ke halaman /checkout/{order_number}/payment
```

### 9.5 Endpoint: Aktivasi Akun

```
GET /account/activate/{token}
```

**Auth**: Tidak perlu login.

**Logic:**
```
1. Cari user berdasarkan activation_token
2. Cek token belum expired (activation_token_expires_at > now())
3. Valid → tampilkan form "Buat Password Baru"
4. Expired → tampilkan pesan + tombol "Kirim Ulang Email Aktivasi"
5. Token tidak ditemukan → redirect ke halaman utama dengan pesan error
```

```
POST /account/activate/{token}
```

**Request Body:**
```
password              : string (required, min:8)
password_confirmation : string (required, sama dengan password)
```

**Logic:**
```
1. Validasi token (sama seperti GET)
2. Update user:
   - password = bcrypt(new_password)
   - is_guest = false
   - email_verified_at = now()
   - activation_token = null
   - activation_token_expires_at = null
3. Auto-login user
4. Redirect ke /orders dengan flash message sukses
```

### 9.6 Endpoint: Tracking Produksi (Public)

```
GET /track/{orderNumber}
```

> Halaman publik, tidak perlu login. Menampilkan status produksi berdasarkan nomor pesanan.

**Response (view Blade)**: Halaman tracking dengan timeline status produksi.

**Jika order tidak ditemukan**: Tampilkan pesan "Nomor pesanan tidak ditemukan."

### 9.7 Endpoint: Update Status Produksi (Admin)

```
POST /admin/orders/{orderId}/production
```

**Auth**: Wajib login sebagai admin atau superadmin.

**Request Body (form submission):**
```
status    : string (required, salah satu dari enum production_logs.status)
notes     : string (optional)
photo     : file (optional, JPG/PNG, maks 2MB)
```

**Validasi:**
- Status harus berurutan (tidak bisa skip dari `order_received` langsung ke `finished`)
- Admin tidak bisa menurunkan status (tidak bisa rollback ke status sebelumnya)

---

## 10. Integrasi Midtrans — Detail Teknis

### 10.1 Setup & Konfigurasi

**Install package:**
```bash
composer require midtrans/midtrans-php
```

**File `.env`:**
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxx     # Sandbox key
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxx     # Sandbox key
MIDTRANS_IS_PRODUCTION=false                    # Ubah ke true saat go-live
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

**File `config/midtrans.php`:**
```php
<?php
return [
    'server_key'    => env('MIDTRANS_SERVER_KEY'),
    'client_key'    => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized'  => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds'        => env('MIDTRANS_IS_3DS', true),
];
```

### 10.2 MidtransService

```php
<?php
// app/Services/MidtransService.php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    public function createSnapToken(Order $order): string
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email'      => $order->user->email,
                'phone'      => $order->user->phone ?? '',
            ],
            'item_details' => $order->orderItems->map(function ($item) {
                return [
                    'id'       => $item->product_id,
                    'price'    => (int) $item->price,
                    'quantity' => $item->qty,
                    'name'     => $item->product->name,
                ];
            })->toArray(),
        ];

        return Snap::getSnapToken($params);
    }

    public function verifySignature(
        string $orderId,
        string $statusCode,
        string $grossAmount,
        string $receivedSignature
    ): bool {
        $serverKey         = config('midtrans.server_key');
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        return hash_equals($expectedSignature, $receivedSignature);
    }
}
```

### 10.3 Webhook Handler

```php
<?php
// app/Http/Controllers/PaymentController.php (method handleCallback)

public function handleCallback(Request $request)
{
    $payload = $request->all();

    // 1. Verifikasi signature
    $isValid = $this->midtransService->verifySignature(
        $payload['order_id'],
        $payload['status_code'],
        $payload['gross_amount'],
        $payload['signature_key']
    );

    if (!$isValid) {
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    // 2. Cari order berdasarkan order_number
    $order = Order::where('order_number', $payload['order_id'])->first();
    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    // 3. Update status pembayaran
    $transactionStatus = $payload['transaction_status'];
    $payment = $order->payment;

    if (in_array($transactionStatus, ['settlement', 'capture'])) {
        $payment->update([
            'status'  => 'paid',
            'paid_at' => now(),
            'payment_type' => $payload['payment_type'],
            'raw_response' => $payload,
        ]);
        $order->update(['status' => 'order_received']);

    } elseif ($transactionStatus === 'expire') {
        $payment->update(['status' => 'expired', 'raw_response' => $payload]);
        $order->update(['status' => 'cancelled']);

    } elseif (in_array($transactionStatus, ['cancel', 'deny'])) {
        $payment->update(['status' => 'failed', 'raw_response' => $payload]);
    }

    return response()->json(['message' => 'OK'], 200);
}
```

### 10.4 Frontend — Inisiasi Snap (Blade)

```html
<!-- Di halaman checkout, setelah user klik "Bayar Sekarang" -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
    document.getElementById('pay-button').onclick = function() {
        fetch('/checkout/{{ $order->id }}/snap-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '/orders/{{ $order->order_number }}/success';
                    },
                    onPending: function(result) {
                        window.location.href = '/orders/{{ $order->order_number }}/pending';
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                    },
                    onClose: function() {
                        // User menutup popup tanpa bayar
                    }
                });
            }
        });
    };
</script>
```

### 10.5 Penting — URL Webhook di Dashboard Midtrans

Saat deployment, daftarkan URL webhook berikut di **Midtrans Dashboard → Settings → Payment Notification URL**:
```
https://[domain-produksi]/api/midtrans/callback
```
> Untuk sandbox testing, gunakan tool seperti **ngrok** agar localhost bisa menerima callback.

---

## 11. Wireframe Notes & UI Guidelines

### 11.1 Color Palette

| Token | Hex | Penggunaan |
|---|---|---|
| Primary Brown | `#6B3A2A` | CTA button, heading, aksen utama |
| Light Brown | `#A0522D` | Hover state, secondary button |
| Cream | `#F5F0E8` | Background utama |
| Off-White | `#FAFAF7` | Card background |
| Dark Green | `#2D4A3E` | Badge status "Selesai", aksen positif |
| Text Primary | `#1A1A1A` | Body text |
| Text Secondary | `#6B7280` | Label, caption |
| Border | `#E5E0D8` | Divider, card border |

### 11.2 Typography

| Penggunaan | Font | Weight |
|---|---|---|
| Heading H1, H2 | Playfair Display | 600–700 |
| Heading H3, H4 | Playfair Display | 500 |
| Body, Form | Inter | 400 |
| Label, Button | Inter | 500–600 |

### 11.3 Struktur Halaman Utama (Wireframe Notes)

#### A. Halaman Beranda / Katalog
```
[NAVBAR: Logo | Menu | Login/Register]
──────────────────────────────────────
[HERO BANNER: Foto furniture jati, tagline, CTA "Lihat Katalog"]
──────────────────────────────────────
[FILTER BAR: Semua Kategori | Kursi | Meja | Lemari | ... | [Search Input]]
──────────────────────────────────────
[PRODUCT GRID: 3 kolom desktop / 2 kolom tablet / 1 kolom mobile]
  [Card: Foto | Nama | Kategori | Harga | Tombol "Pesan"]
──────────────────────────────────────
[FOOTER: Kontak | Alamat | Social Media]
```

#### B. Halaman Checkout
```
[RINGKASAN PESANAN]
  - Foto & nama produk
  - Jumlah & subtotal

[FORM PENGIRIMAN]
  - Nama penerima
  - Alamat lengkap
  - Nomor telepon
  - Catatan (opsional)

[TOTAL PEMBAYARAN]
  - Subtotal produk
  - (Ongkir: jika ada)
  - TOTAL

[TOMBOL: "Lanjut ke Pembayaran"]
→ Trigger Midtrans Snap popup
```

#### C. Halaman Tracking Publik (`/track/{orderNumber}`)
```
[INPUT: Nomor Pesanan] [Tombol Lacak]
──────────────────────
[Jika ditemukan:]

[INFO PESANAN: Nomor | Tanggal | Tipe | Status Pembayaran]

[TIMELINE PRODUKSI — vertikal stepper]
  ✅ Order Diterima      — 15 Jun 2026, 10:00
  ✅ Persiapan Bahan     — 17 Jun 2026, 09:00
  🔄 Proses Produksi    ← STATUS AKTIF
  ○  Finishing
  ○  Quality Check
  ○  Siap Kirim
  ○  Selesai

[CATATAN TERBARU DARI ADMIN (jika ada)]
```

#### D. Dashboard Admin
```
[SIDEBAR: Dashboard | Produk | Pesanan | Custom Order | Laporan | User (SA)]

[KONTEN UTAMA]
  [ROW KPI CARDS: Total Pesanan | Pendapatan Bulan Ini | Pending | Produksi Berjalan]
  [GRAFIK: Tren pesanan 30 hari (Line chart)]
  [TABEL: Pesanan Terbaru + Filter Status + Tanggal]
```

### 11.4 Komponen UI yang Perlu Dibuat

| Komponen | Digunakan Di |
|---|---|
| Product Card | Catalog, Dashboard |
| Order Status Badge | Order list, Tracking |
| Production Timeline Stepper | Tracking, Order detail admin |
| Snap Payment Modal (Midtrans embed) | Checkout |
| Confirmation Dialog | Approve/reject custom order, update status |
| File Upload Preview | Custom order form |
| Export Button Group (PDF / Excel) | Laporan |

---

## 12. Acceptance Criteria per Fitur

### AC-01: Guest Checkout & Autentikasi

**Given** seorang pengunjung membuka halaman checkout dan mengisi nama, email baru (belum terdaftar), nomor HP, dan alamat,
**Then** sistem membuat guest account otomatis, order berhasil dibuat, dan dalam < 2 menit pelanggan menerima 2 email: (1) konfirmasi pesanan dengan nomor order + link tracking, (2) kredensial akun dengan link aktivasi.

**Given** pengunjung checkout menggunakan email yang sudah terdaftar sebagai guest account sebelumnya,
**Then** sistem menggunakan akun yang sudah ada (tidak membuat duplikat), order terhubung ke akun tersebut, dan email konfirmasi pesanan dikirim ulang.

**Given** pengunjung checkout menggunakan email yang sudah terdaftar sebagai akun aktif (sudah aktivasi),
**Then** sistem menampilkan pesan: *"Email ini sudah terdaftar. Silakan login untuk melanjutkan."* dan mengarahkan ke halaman login.

**Given** pelanggan guest menerima email aktivasi dan klik link aktivasi yang masih valid (< 7 hari),
**Then** pelanggan diarahkan ke form buat password baru; setelah submit, akun aktif, pelanggan otomatis login, dan diarahkan ke halaman riwayat pesanan.

**Given** pelanggan klik link aktivasi yang sudah expired (> 7 hari),
**Then** sistem menampilkan pesan "Link aktivasi sudah kadaluarsa" beserta tombol "Kirim Ulang Email Aktivasi".

**Given** user login dengan email dan password yang benar,
**Then** user diarahkan ke halaman sesuai role (customer → riwayat pesanan, admin → admin panel).

**Given** user login dengan password salah lebih dari 5 kali,
**Then** akun dikunci sementara selama 15 menit (Laravel throttle).

---

### AC-02: Katalog Produk

**Given** pengguna (siapapun) membuka halaman katalog,
**Then** sistem menampilkan produk dengan status `is_active = true` saja.

**Given** pengguna memilih filter kategori "Kursi",
**Then** hanya produk dengan kategori "Kursi" yang ditampilkan.

**Given** pengguna mengetik keyword di search bar,
**Then** produk yang namanya mengandung keyword ditampilkan dalam < 1 detik.

---

### AC-03: Pemesanan (Guest & Authenticated)

**Given** pengunjung tanpa login membuka detail produk dan klik "Pesan Sekarang",
**Then** sistem menampilkan form checkout dengan field: nama, email, HP, alamat — tanpa memaksa login atau registrasi.

**Given** guest berhasil submit form checkout dengan data valid,
**Then** sistem membuat order dengan status `pending_payment`, men-generate `order_number` format `JAF-YYYYMMDD-XXXX`, dan mengarahkan ke halaman pembayaran.

**Given** customer yang sudah login membuka halaman checkout,
**Then** field nama, email, HP, alamat sudah terisi otomatis dari data profil (tapi tetap bisa diedit).

---

### AC-04: Custom Order

**Given** guest (belum aktivasi akun) mencoba mengakses halaman custom order,
**Then** sistem menampilkan pesan: *"Untuk mengajukan custom order, silakan aktifkan akun Anda terlebih dahulu. Cek email Anda untuk link aktivasi."* — dengan tombol "Kirim Ulang Email Aktivasi".

**Given** customer dengan akun aktif mengisi form custom order dengan semua field wajib dan klik "Ajukan",
**Then** custom order tersimpan dengan status `submitted` dan pelanggan menerima email konfirmasi pengajuan.

**Given** admin membuka custom order dengan status `submitted` dan klik "Approve",
**Then** admin harus mengisi harga yang disepakati, custom order berubah status jadi `approved`, sistem otomatis membuat order baru bertipe `custom`, dan pelanggan menerima email notifikasi approval beserta detail harga.

**Given** admin klik "Reject" pada custom order,
**Then** admin wajib mengisi alasan penolakan, status berubah menjadi `rejected`, dan pelanggan menerima email notifikasi beserta alasan penolakan.

---

### AC-05: Pembayaran Midtrans

**Given** Midtrans mengirim callback dengan `transaction_status = "settlement"`,
**Then** sistem memverifikasi signature, mengupdate `payments.status = 'paid'`, `payments.paid_at`, dan `orders.status = 'order_received'`.

**Given** Midtrans mengirim callback dengan signature tidak valid,
**Then** sistem menolak request dengan HTTP 403 dan tidak melakukan update apapun.

**Given** Midtrans mengirim callback dengan `transaction_status = "expire"`,
**Then** `payments.status = 'expired'` dan `orders.status = 'cancelled'`.

---

### AC-06: Tracking Produksi

**Given** siapapun (termasuk tanpa login) mengakses `/track/{orderNumber}` dengan nomor pesanan valid,
**Then** halaman menampilkan timeline status produksi dengan highlight status aktif saat ini.

**Given** nomor pesanan tidak ditemukan di sistem,
**Then** halaman menampilkan pesan "Nomor pesanan tidak ditemukan. Periksa kembali nomor pesanan Anda."

**Given** admin mengupdate status produksi dari `order_received` ke `material_preparation`,
**Then** log baru tersimpan di `production_logs`, dan halaman tracking pelanggan langsung menampilkan status terbaru.

**Given** admin mencoba mengupdate status ke tahapan yang bukan urutan berikutnya (misal skip dari `order_received` ke `in_production`),
**Then** sistem menolak dan menampilkan pesan error validasi.

---

### AC-07: Dashboard & Laporan

**Given** admin membuka halaman dashboard,
**Then** KPI cards menampilkan data yang akurat dan up-to-date (tidak menggunakan cache lebih dari 5 menit).

**Given** admin membuka halaman laporan, memilih filter bulan Juni 2026, dan klik "Export PDF",
**Then** file PDF berhasil didownload dalam < 10 detik dengan data yang sesuai filter.

---

### AC-08: Role-Based Access Control

**Given** user dengan role `customer` mencoba mengakses URL `/admin/...`,
**Then** sistem mengembalikan redirect ke halaman login atau halaman 403 Forbidden.

**Given** user dengan role `admin` mencoba mengakses halaman manajemen user `/admin/users`,
**Then** sistem mengembalikan 403 (halaman tersebut hanya untuk `superadmin`).

---

## 13. Out of Scope

Hal-hal berikut secara eksplisit **tidak** dikembangkan dalam proyek ini:

| # | Item | Catatan |
|---|---|---|
| 1 | Aplikasi mobile native (Android/iOS) | Cukup web responsif |
| 2 | Integrasi IoT / sensor mesin produksi | Bukan dalam lingkup digitalisasi ini |
| 3 | Sistem ERP atau manajemen keuangan kompleks | Di luar MVP |
| 4 | Fitur AI/ML | Di luar MVP |
| 5 | Multi-bahasa | Bahasa Indonesia saja |
| 6 | Multi-toko / multi-cabang | Single-store |
| 7 | Notifikasi WhatsApp otomatis | Opsional, bukan requirement wajib |
| 8 | Live chat / helpdesk terintegrasi | Di luar MVP |
| 9 | Sistem logistik / ongkir terintegrasi (JNE, Sicepat, dll.) | Ongkir ditangani manual/negosiasi |

---

## 14. Assumptions & Dependencies

### 14.1 Asumsi

| # | Asumsi |
|---|---|
| A1 | Owner Jati Akbar Furniture menyediakan konten (foto produk, deskripsi, harga, profil bisnis) tepat waktu sebelum fase development dimulai |
| A2 | Tim proyek dapat bekerja secara paralel sesuai role masing-masing |
| A3 | Akun Midtrans (Sandbox & Production) sudah tersedia atau dapat dibuat di awal proyek |
| A4 | Approval desain UI/UX dari stakeholder diberikan dalam maksimal 3 hari kerja setelah prototype disubmit |
| A5 | Hosting/VPS yang dipilih mendukung PHP 8.2+, MySQL 8.0+, dan dapat menjalankan Laravel Queue (Supervisor) |
| A6 | Domain sudah disiapkan sebelum fase Deployment (16 Agustus 2026) |

### 14.2 Dependencies Teknis

| Dependency | Versi | Catatan |
|---|---|---|
| PHP | ≥ 8.2 | Requirement Laravel 11 |
| Laravel | 11.x | Framework utama |
| MySQL | ≥ 8.0 | Database |
| Node.js & NPM | ≥ 18 | Build TailwindCSS |
| Midtrans PHP SDK | Latest | `composer require midtrans/midtrans-php` |
| Laravel Breeze / Jetstream | Latest | Auth scaffolding |
| Livewire / Alpine.js | Latest | Interaktivitas dinamis (jika diperlukan) |
| Laravel Queue + Supervisor | — | Notifikasi email async |

---

## 15. Glossary

| Term | Definisi |
|---|---|
| **MVP** | Minimum Viable Product — versi produk dengan fitur inti yang sudah bisa digunakan secara operasional |
| **Guest Checkout** | Alur pemesanan tanpa registrasi manual — pelanggan cukup mengisi nama, email, dan HP |
| **Guest Account** | Akun yang dibuat otomatis oleh sistem saat pelanggan melakukan guest checkout; ditandai dengan `is_guest = true` dan `email_verified_at = NULL` |
| **Akun Aktif** | Akun yang sudah diaktivasi oleh pelanggan via link email; ditandai dengan `is_guest = false` dan `email_verified_at` terisi |
| **Link Aktivasi** | URL unik yang dikirim ke email pelanggan setelah guest checkout, berlaku 7 hari, digunakan untuk mengaktifkan akun dan membuat password |
| **Custom Order** | Pemesanan furniture dengan spesifikasi khusus dari pelanggan (bukan produk katalog standar) — hanya untuk akun aktif |
| **Snap Token** | Token yang di-generate Midtrans untuk membuka popup pembayaran di sisi frontend |
| **Webhook / Callback** | Notifikasi otomatis dari Midtrans ke server kita ketika status pembayaran berubah |
| **Production Log** | Catatan setiap perubahan status produksi pada suatu pesanan |
| **RBAC** | Role-Based Access Control — sistem otorisasi berdasarkan role pengguna |
| **Soft Delete** | Menandai data sebagai tidak aktif tanpa benar-benar menghapusnya dari database |
| **Sandbox** | Mode testing Midtrans — transaksi tidak nyata, untuk keperluan development |
| **Go-Live** | Istilah untuk sistem yang sudah diakses secara publik / operasional |
| **ERD** | Entity Relationship Diagram — diagram yang menggambarkan relasi antar tabel database |
| **Laravel Queue** | Sistem antrian job asinkron di Laravel — digunakan untuk mengirim email tanpa memblokir HTTP response |

---

*Dokumen ini merupakan PRD resmi proyek JAFAPP.*
*Perubahan pada dokumen ini memerlukan persetujuan dari Project Manager dan Sponsor Proyek.*

---

**Versi**: 1.1.0 | **Dibuat**: Mei 2026 | **PM**: Muhammad Arju Ridho Maulana
