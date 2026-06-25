# AksaraLoka - Marketplace Produk UMKM Banyumas

AksaraLoka adalah platform e-commerce multi-vendor (marketplace) inovatif yang dirancang khusus untuk mewadahi Usaha Mikro, Kecil, dan Menengah (UMKM) unggulan dari Kabupaten Banyumas. Proyek ini dikembangkan sebagai karya tugas/ujian akhir untuk **CPMK-02 PAKET 2**.

Platform ini memfasilitasi transaksi aman, manajemen stok asimetris (pessimistic locking), serta pelaporan komprehensif bagi pembeli, pelaku UMKM (penjual), dan administrator platform.

<div align="center">
  <h3><a href="https://youtube.com/watch?v=placeholder_link">📹 Tonton Video Demo YouTube Disini</a></h3>
</div>

---

## 🏗 Tech Stack

Proyek ini menggunakan spesifikasi modern dengan fondasi:
* **Framework:** Laravel 13
* **Bahasa Pemrograman:** PHP 8.3
* **Database:** MySQL / MariaDB (Laravel Herd Environment)
* **Frontend:** Blade Templating Engine + Vanilla JS (Sesuai spesifikasi, Non-SPA)
* **Styling:** Tailwind CSS 3 (Implementasi *Stitch/Lumiere Design System* kustom)
* **Autentikasi:** Laravel Breeze
* **Ekspor Laporan:** Barryvdh/laravel-dompdf

---

## Fitur Utama & Penyelesaian Tantangan Unik (CPMK-02)

1. **Multi-Role Otorisasi:** Akses panel tersendiri dengan middleware ketat untuk 3 level pengguna (`Admin`, `Penjual`, `Pembeli`).
2. **Persistent Shopping Cart (Tantangan 1):** Mekanisme keranjang belanja non-database menggunakan sistem `Session`. Data produk keranjang tersimpan stabil meskipun berpindah rute tanpa harus login terlebih dahulu.
3. **Atomic Checkout Transaction (Tantangan 2):** Transaksi checkout dibungkus menyeluruh di dalam `DB::transaction()`. Jika ada kegagalan internal, data `order` dan `order_items` yang terhubung tidak akan tercipta sama sekali (Rollback).
4. **Pessimistic Locking / Race Condition (Tantangan 3):** Memastikan stok absolut akurat dengan klausa `lockForUpdate()` pada saat query Eloquent selama proses decrement inventaris.
5. **Split Order Multi-Penjual (Tantangan 4):** Pembeli dapat melakukan *checkout* berbagai barang dari toko berbeda sekaligus. Sistem merombak dan menciptakan faktur tagihan spesifik (`order_code`) per-masing-masing toko agar mempermudah notifikasi penjual.
6. **Multi-Image Upload (Tantangan 5):** Mendukung unggahan lebih dari 3 foto dengan sistem tabel relasional One-to-Many (`product_images`) sehingga menunjang fitur Galeri Produk Interaktif.
7. **State Machine Pesanan (Tantangan 6):** Sistem transisi status (`menunggu konfirmasi` -> `diproses` -> `dikirim` -> `selesai`) mengadopsi validasi *lifecycle* ketat pada model dan controller; memblokir lompatan loncat status yang rentan *fraud*.
8. **Export PDF Executive Report:** Masing-masing penjual dan Admin Global dapat membuat Laporan GMV format PDF dari ringkasan order multi-toko.

---

## Petunjuk Instalasi Step-by-Step

Agar aplikasi berjalan sempurna pada lingkungan lokal Anda, ikuti langkah-langkah instalasi berikut:

1. **Clone repositori dari GitHub:**
   ```bash
   git clone https://github.com/username/aksaraloka-cpmk02.git
   cd aksaraloka-cpmk02
   ```

2. **Instal seluruh *dependencies* Composer dan NPM:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Konfigurasi Environment Database:**
   Copy `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
   Lalu buka file `.env`, atur koneksi spesifikasi *database* Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=aksaraloka_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Buat Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Link direktori Storage untuk gambar (SANGAT PENTING):**
   ```bash
   php artisan storage:link
   ```

6. **Migrasi Database sekaligus Populasikan (Seed) Master Data:**
   Langkah ini wajib untuk melengkapi katalog dan struktur role akun.
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Akses `http://localhost:8000` atau URL Laravel Herd lokal Anda.

---

## Kredensial Pengujian (Seeder Default)

Proses _seeding_ secara otomatis akan menciptakan 4 pengguna dan data tiruan siap pakai:

| Role | Nama | Email Login | Password |
| :--- | :--- | :--- | :--- |
| **Admin** | Admin AksaraLoka | `admin@aksaraloka.id` | `password` |
| **Penjual (Toko 1)** | Siti Rahayu | `siti@aksaraloka.id` | `password` |
| **Penjual (Toko 2)** | Bambang Wijaya | `bambang@aksaraloka.id` | `password` |
| **Pembeli** | Rina Susanti | `rina@email.com` | `password` |

Gunakan akses tersebut di `/login` untuk mengulas masing-masing _Dashboard_ dan alurnya secara utuh.

---