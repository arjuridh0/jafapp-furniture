# 🪑 JAFAPP — Jati Akbar Furniture Web Application (JAFF)

JAFAPP adalah platform e-commerce dan manajemen produksi khusus (custom order) untuk bisnis furnitur premium kayu jati **Jati Akbar**. Aplikasi ini memadukan kemudahan transaksi pelanggan (termasuk *Guest Checkout* & *Midtrans Payment Gateway*) dengan sistem pelacakan produksi yang ketat (real-time production tracking) serta laporan analitik penjualan/produksi bagi jajaran admin dan super admin.

Aplikasi ini didesain dengan estetika premium (*Teak & Sand*), performa super responsif, micro-animations, dan transisi halaman modern (*View Transitions API*).

---

## 🚀 Fitur Utama Sistem

### 1. Pelanggan & Publik (Frontend)
*   **Katalog Produk Premium:** Galeri gambar dinamis, filter kategori instan, pencarian responsif, dan efek transisi halaman premium (*View Transitions*).
*   **Keranjang Belanja:** Berbasis *session* tanpa ribet login terlebih dahulu (Session-based Cart).
*   **Guest Checkout (Tanpa Wajib Daftar):** Pelanggan dapat berbelanja secara instan. Sistem otomatis membuatkan akun tamu pasif, mengirimkan email kredensial login sementara, dan mengamankan data transaksi.
*   **Registrasi & Aktivasi Akun:** Alur pendaftaran mandiri dengan verifikasi email / tautan aktivasi akun demi keamanan tingkat tinggi.
*   **Sistem Custom Order:** Form interaktif bagi pelanggan terdaftar untuk mengajukan pesanan furnitur kustom dengan spesifikasi jenis kayu, jenis finishing, dimensi, serta unggah 3 gambar referensi.
*   **Pelacakan Pesanan Real-time (Tracking System):** Konsumen dapat melacak status pengerjaan kayu pesanan mereka berdasarkan kode unik pesanan secara mendetail.
*   **Profil Pelanggan:** Halaman khusus untuk memperbarui informasi kontak dan mengganti password akun dengan aman.

### 2. Panel Admin (Manajemen & Produksi)
*   **Dashboard Analytics:** Ringkasan KPI penjualan, grafik tren pesanan 30 hari menggunakan Chart.js, status pembayaran, serta diagram pengerjaan produksi.
*   **Manajemen Produk & Kategori:** Menambahkan, mengedit, mengaktifkan/menonaktifkan produk dengan dukungan unggah banyak foto (JSON cast array gallery) dan kategori otomatis slug.
*   **Manajemen Pesanan & Pengiriman:** Fitur bagi admin untuk menginput biaya pengiriman (*shipping cost*) manual setelah berdiskusi dengan pelanggan.
*   **Alur Produksi Super Ketat:** Manajemen status produksi yang diatur dengan urutan log yang kaku (`order_received` -> `material_preparation` -> `in_production` -> `finishing` -> `ready_to_ship` -> `shipped` -> `completed`). Sistem menolak pemangkasan tahapan pengerjaan (no rollback & no skip).
*   **Manajemen Custom Order:** Meninjau pengajuan pesanan kustom pelanggan, memberikan penawaran harga kesepakatan (*agreed price*), menyetujui atau menolaknya dengan catatan khusus admin.
*   **Laporan Ekspor Keuangan & Produksi:** Mengunduh ringkasan performa penjualan dan lini produksi ke dalam format **PDF (Dompdf)** dan **Excel (Maatwebsite Excel)**.

### 3. Panel Super Admin (User Access Control)
*   **Manajemen Pengguna:** Menampilkan seluruh daftar pengguna (Customer, Admin, Super Admin).
*   **Hak Akses Dinamis (RBAC):** Mengubah peran pengguna (upgrade/downgrade ke admin) dan mematikan/mengaktifkan status akun jika mendeteksi pelanggaran keamanan.
*   **Pembuatan Akun Admin Baru:** Form pembuatan akun pengelola dari panel internal secara instan.

---

## 🛠️ Stack Teknologi & Kebutuhan Sistem

*   **Backend Framework:** Laravel 11.x
*   **PHP Version:** 8.2 ke atas (Direkomendasikan PHP 8.4)
*   **Frontend Engine:** Tailwind CSS v4, Alpine.js, Blade Templates (Clean, no-Livewire/no-SPA bloat)
*   **Database Engine:** MySQL 8.0 / MariaDB
*   **Integrasi Pihak Ketiga:** Midtrans Snap API & Midtrans Webhook (Sandbox Mode)
*   **Ekspor Dokumentasi:** `barryvdh/laravel-dompdf` & `maatwebsite/excel`

---

## 📦 Panduan Instalasi & Pengaturan Tim

Silakan ikuti langkah-langkah di bawah ini untuk memasang proyek ini di lingkungan lokal Anda (Direkomendasikan menggunakan **Laragon** pada Windows).

### Langkah 1: Kloning Repositori
```bash
git clone <url-repositori-anda>
cd JAFF
```

### Langkah 2: Memasang Dependensi
Pasang semua dependensi PHP (Composer) dan Javascript (NPM) yang diperlukan:
```bash
composer install
npm install
```

### Langkah 3: Konfigurasi File Environment
Salin file konfigurasi `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` yang baru dibuat di VS Code atau editor teks lainnya, lalu sesuaikan bagian koneksi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jafapp
DB_USERNAME=root
DB_PASSWORD=
```
*Catatan: Pastikan Anda sudah membuat database bernama `jafapp` di Laragon/phpMyAdmin Anda sebelum berlanjut.*

Buka juga bagian email SMTP di `.env` dan isi dengan kredensial Gmail App Password Anda agar fitur notifikasi pesanan dan aktivasi akun berjalan:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=email-anda@gmail.com
MAIL_PASSWORD=app-password-anda
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=email-anda@gmail.com
```

### Langkah 4: Generate Application Key
```bash
php artisan key:generate
```

### Langkah 5: Migrasi Database & Seeding Data Utama
Jalankan migrasi tabel beserta pengisian data contoh awal (Seeders):
```bash
php artisan migrate --seed
```
*Perintah ini akan membuat semua struktur tabel serta memuat data produk furnitur jati, kategori, pesanan contoh, dan kredensial default untuk uji coba.*

### Langkah 6: Membuat Simbolik Link Folder Storage
Agar gambar produk yang diunggah dapat diakses dari browser, hubungkan folder storage Laravel ke public:
```bash
php artisan storage:link
```

### Langkah 7: Jalankan Server Lokal
Nyalakan compiler aset frontend (Vite) dan server Laravel Artisan secara bersamaan:

**Terminal 1 (Vite compiler):**
```bash
npm run dev
```

**Terminal 2 (Laravel local server):**
```bash
php artisan serve
```
Aplikasi Anda kini sudah aktif dan dapat diakses melalui tautan default: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 💳 Integrasi Pembayaran (Simulasi / Mock Payment)

Saat ini, sistem menggunakan **Mode Simulasi Pembayaran (Mock Payment)** untuk mempermudah proses *testing* lokal tanpa perlu menyiapkan akun Midtrans Sandbox. Saat Anda melakukan *checkout*, tombol "Bayar Sekarang" akan otomatis memproses pembayaran menjadi lunas (Paid).

**Integrasi Midtrans (Persiapan Masa Depan):**
Kode integrasi Midtrans Snap API dan Webhook sudah tersedia di dalam sistem (cek `CheckoutController.php` dan `MidtransService.php`). Jika kedepannya Anda ingin mengaktifkan Midtrans sungguhan, Anda perlu:
1. Mengembalikan logika `createSnapToken` pada `CheckoutController@confirmation`.
2. Mengganti form Mock Pay di `confirmation.blade.php` dengan script `snap.js`.
3. Mengisi credentials Midtrans Sandbox Anda di file `.env`:
```env
MIDTRANS_MERCHANT_ID=your-merchant-id
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```
4. Mendaftarkan URL Webhook (`http://<domain-publik-anda>/api/midtrans/callback`) di Dashboard Portal Midtrans Anda.

---

## 🔑 Akun Login Pengujian (Default Credentials)

Setelah Anda menjalankan perintah `--seed`, Anda dapat menggunakan akun siap pakai berikut ini untuk meninjau sistem:

| Peran (Role) | Email | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@jafapp.com` | `superadmin123` | Manajemen User, Ubah Role, Matikan Akun, Buat Akun Admin |
| **Admin** | `admin@jafapp.com` | `admin123` | Update Status Produksi, Input Biaya Ongkir, Kelola Katalog & Kategori, Approve Custom Order, Ekspor PDF/Excel |
| **Customer** | `customer@jafapp.com` | `password` | Mengajukan Custom Order, Melihat Riwayat Belanja, Ubah Password Profil |

---

## 🧪 Menjalankan Suite Pengujian Otomatis

Aplikasi ini dilengkapi pengujian unit dan fitur terotomatisasi (*Automatic Feature Testing*) untuk mencegah regresi kode. Anda dapat memverifikasi kualitas codebase dengan menjalankan perintah:

```bash
php artisan test
```

Semua suite pengujian dijamin **100% Passed (Hijau)** yang mencakup pengujian:
1.  **RBAC & Security Test (`RbacTest`):** Menjamin Customer & Tamu ditolak saat mencoba masuk halaman Admin/Super Admin.
2.  **Checkout & Cart Flow (`CheckoutTest`):** Simulasi penambahan produk ke keranjang, memperbarui jumlah, menghapus, serta memproses pembuatan pesanan guest checkout.
3.  **Midtrans Webhook Callback (`MidtransWebhookTest`):** Simulasi validasi callback transaksi aman dari luar server.
4.  **Sequential Production Tracking (`ProductionStatusTest`):** Mengunci alur proses pembuatan mebel agar berjalan sesuai urutan log tanpa lompatan.

---

## 📁 Struktur Penting Proyek untuk Tim Pengembang

Untuk mempermudah koordinasi pengerjaan tim Anda, berikut adalah struktur file penting yang memuat logika khusus JAFAPP:

*   **`app/Services/CheckoutService.php`**
    *   *Logika:* Menangani proses Guest Checkout, pendaftaran akun tamu otomatis pasif, serta pembuatan nomor pesanan unik terpusat.
*   **`app/Services/MidtransService.php`**
    *   *Logika:* Komunikasi API dengan SDK Midtrans untuk mendapatkan *Snap Token* pembayaran dan memproses verifikasi notifikasi callback.
*   **`app/Http/Middleware/RoleMiddleware.php`**
    *   *Logika:* Pembatasan hak akses berbasis peran (Customer, Admin, Super Admin). Terdaftar dengan alias `role` di `bootstrap/app.php`.
*   **`resources/css/app.css`**
    *   *Logika:* Pusat variabel desain premium (*Tailwind v4 tokens*). Menggunakan palet khusus: `teak` (coklat jati hangat) dan `sand` (warna pasir lembut).
*   **`app/Models/Order.php` & `ProductionLog.php`**
    *   *Logika:* Model data pelacakan yang menampung aturan sekuensial tahapan produksi furnitur jati Jati Akbar.

---

## 📝 Aturan Tambahan & Komitmen Git
*   **`.gitignore` Note:** Folder panduan developer `skills/` telah dimasukkan ke dalam `.gitignore` lokal agar tidak mengotori repositori git publik Anda. File ini tetap aman di lokal untuk panduan pengerjaan Anda sehari-hari.
*   **Commit Format:** Kami menggunakan skema penamaan commit yang rapi sesuai fungsionalitas fase, seperti: `Phase 5.x: [Deskripsi pekerjaan yang jelas]`.

Selamat berkolaborasi dalam tim untuk mengembangkan **JAFAPP**! Jika ada kendala teknis atau pertanyaan pengembangan, silakan hubungi tim lead Anda atau ajukan diskusi pada repositori. 🛠️🪓✨
