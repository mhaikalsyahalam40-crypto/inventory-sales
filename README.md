# Nexora Tech — Inventory & Sales Management System

Aplikasi manajemen persediaan dan transaksi bisnis berbasis web yang dibangun menggunakan Laravel dan MySQL. **Nexora Tech** membantu pengelolaan produk, kategori, supplier, pembelian, penjualan, pengguna, dan laporan transaksi dalam satu sistem terintegrasi.

## Deskripsi Proyek

Nexora Tech merupakan aplikasi untuk membantu bisnis mengelola persediaan barang dan aktivitas transaksi secara terstruktur. Sistem ini mendukung pencatatan pembelian dari supplier, penjualan kepada pelanggan, pemantauan stok, serta pengelolaan hak akses pengguna berdasarkan peran.

Aplikasi dirancang untuk mendukung konsistensi data persediaan dan mempermudah pemantauan aktivitas operasional bisnis.

## Teknologi

- **Backend:** PHP 8.4+, Laravel 13
- **Database:** MySQL
- **ORM:** Eloquent ORM
- **Frontend:** Blade Template, HTML, CSS
- **Build Tools:** Node.js, npm, dan Vite jika dikonfigurasi dalam proyek
- **Development Environment:** Laravel Herd Lite atau lingkungan PHP yang kompatibel

## Fitur Aplikasi

### 1. Autentikasi dan Keamanan
- Login dan logout pengguna.
- Penyimpanan password menggunakan hashing.
- Perlindungan halaman berdasarkan autentikasi.
- Pembatasan akses menggunakan role dan middleware sesuai konfigurasi aplikasi.

### 2. Dashboard
- Ringkasan jumlah produk dan transaksi.
- Informasi total penjualan harian dan bulanan.
- Ringkasan pembelian harian dan bulanan.
- Informasi produk dengan stok rendah.

### 3. Manajemen Produk
- Tambah, lihat, ubah, dan hapus produk.
- Pengelolaan SKU, kategori, harga beli, harga jual, stok, dan stok minimum.
- Pencarian dan filter data produk.

### 4. Manajemen Kategori dan Supplier
- Pengelolaan data kategori produk.
- Pengelolaan data supplier.
- Operasi tambah, lihat, ubah, dan hapus sesuai hak akses.

### 5. Transaksi Pembelian
- Pencatatan pembelian barang dari supplier.
- Dukungan beberapa item dalam satu transaksi.
- Penambahan stok setelah pembelian berhasil disimpan.
- Tampilan detail dan status transaksi.
- Pembatalan transaksi oleh pengguna yang berwenang.

### 6. Transaksi Penjualan
- Pencatatan penjualan dengan beberapa item.
- Pengurangan stok setelah penjualan berhasil disimpan.
- Validasi ketersediaan stok sebelum penjualan diproses.
- Tampilan detail dan status transaksi.
- Pembatalan transaksi oleh pengguna yang berwenang.

### 7. Laporan
- Laporan transaksi pembelian dan penjualan.
- Filter berdasarkan nomor transaksi dan rentang tanggal.
- Ringkasan jumlah serta nilai transaksi.
- Pagination pada daftar laporan.

### 8. Manajemen Pengguna
- Pengelolaan akun pengguna.
- Pengaturan peran Admin, Owner, dan Staff.
- Pembatasan fitur berdasarkan izin pengguna.

## Hak Akses Pengguna

| Peran | Hak akses |
|---|---|
| **Admin** | Mengelola pengguna dan fitur administratif sesuai konfigurasi sistem. |
| **Owner** | Memantau dan mengelola aktivitas usaha sesuai izin aplikasi. |
| **Staff** | Menjalankan kegiatan operasional sesuai hak akses yang diberikan. |

Hak akses aktual mengikuti implementasi route, controller, middleware, dan kebijakan otorisasi dalam proyek.

## Persyaratan Sistem

Pastikan perangkat telah memiliki:

- PHP 8.4 atau versi yang memenuhi persyaratan dependensi proyek.
- Composer.
- MySQL.
- Node.js dan npm jika diperlukan untuk membangun aset frontend.
- Laravel Herd Lite atau lingkungan pengembangan PHP yang kompatibel.

## Instalasi dan Konfigurasi

### 1. Masuk ke direktori proyek

Buka PowerShell dan jalankan:

```powershell
cd D:\development\inventory-sales
```

### 2. Instal dependensi PHP

```powershell
composer install
```

Pastikan Composer menggunakan PHP yang memenuhi persyaratan versi proyek.

### 3. Siapkan file konfigurasi

Jika file `.env` belum tersedia, buat salinannya dari `.env.example`:

```powershell
Copy-Item .env.example .env
```

Jika `.env` sudah tersedia, jangan menimpanya.

### 4. Buat application key

```powershell
php artisan key:generate
```

### 5. Konfigurasi database

Buat database MySQL bernama `inventory_sales`, lalu sesuaikan pengaturan pada file `.env`:

```dotenv
APP_NAME="Nexora Tech"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_sales
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan nama pengguna dan password dengan konfigurasi MySQL lokal. Pastikan MySQL sedang berjalan sebelum melanjutkan.

### 6. Jalankan migrasi database

```powershell
php artisan migrate
```

Perintah ini membuat tabel berdasarkan migrasi yang tersedia dalam proyek.

### 7. Buat akun demo

Jika proyek memiliki seeder untuk akun demo, jalankan:

```powershell
php artisan db:seed
```

Akun demo yang disediakan oleh seeder:

| Peran | Email | Password |
|---|---|---|
| Admin | `admin@inventory.test` | `Admin12345!` |
| Owner | `owner@inventory.test` | `Owner12345!` |
| Staff | `staff@inventory.test` | `Staff12345!` |

**Catatan:** Akun tersebut hanya dapat digunakan jika seeder proyek memang membuat akun dengan kredensial tersebut. Gunakan hanya untuk pengembangan lokal dan ganti password sebelum penerapan produksi.

### 8. Instal dan bangun aset frontend

Jika proyek menggunakan Vite dan memiliki `package.json`, jalankan:

```powershell
npm install
npm run build
```

### 9. Jalankan aplikasi

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Buka aplikasi melalui browser:

**http://127.0.0.1:8000**

Biarkan terminal tetap berjalan selama aplikasi digunakan.

## Struktur Database

Tabel utama yang direncanakan atau digunakan sesuai skema proyek meliputi:

| Tabel | Fungsi |
|---|---|
| `users` | Menyimpan akun dan informasi peran pengguna. |
| `categories` | Menyimpan kategori produk. |
| `products` | Menyimpan data produk dan persediaan. |
| `suppliers` | Menyimpan data pemasok. |
| `purchases` | Menyimpan transaksi pembelian. |
| `purchase_items` | Menyimpan rincian item pembelian. |
| `sales` | Menyimpan transaksi penjualan. |
| `sale_items` | Menyimpan rincian item penjualan. |

Relasi antartabel mengikuti skema migrasi yang tersedia dalam proyek.

## Pengujian

Skenario berikut dapat digunakan sebagai checklist pengujian:

- [ ] Login berhasil dengan kredensial valid.
- [ ] Login ditolak dengan kredensial tidak valid.
- [ ] Pengguna yang belum login tidak dapat mengakses halaman terlindungi.
- [ ] SKU produk divalidasi agar unik.
- [ ] Harga dan jumlah barang divalidasi.
- [ ] Pembelian berhasil menambah stok.
- [ ] Penjualan berhasil mengurangi stok.
- [ ] Penjualan dengan stok tidak mencukupi ditolak.
- [ ] Kegagalan transaksi tidak meninggalkan perubahan stok sebagian.
- [ ] Hak akses Admin, Owner, dan Staff berjalan sesuai ketentuan.
- [ ] Filter laporan dan pagination berfungsi.
- [ ] Pembatalan transaksi menjaga konsistensi stok.

Checklist ini merupakan rencana pengujian. Tandai sebagai selesai hanya setelah setiap skenario benar-benar diuji.

## Menjalankan Ulang Seeder

Untuk menjalankan seeder kembali:

```powershell
php artisan db:seed
```

Seeder dapat membuat atau memperbarui data sesuai implementasinya. Seeder tidak selalu menghapus akun lain yang sudah tersimpan.

**Peringatan:** Hindari menjalankan `php artisan migrate:fresh` pada database yang berisi data penting karena perintah tersebut menghapus tabel sebelum membuatnya kembali.

## Pengembangan Selanjutnya

Beberapa pengembangan yang dapat dipertimbangkan:

- Pengujian otomatis untuk proses pembelian dan penjualan.
- Penyempurnaan validasi serta otorisasi.
- Dokumentasi Entity Relationship Diagram (ERD).
- Peningkatan keamanan dan penanganan kesalahan.
- Penyempurnaan antarmuka dan pengalaman pengguna.

## Entity Relationship Diagram (ERD)

Diagram berikut menampilkan hubungan antartabel utama dalam sistem.

![ERD Nexora Tech](docs/erd-inventory-sales.png)

Pastikan file diagram tersedia pada lokasi `docs/erd-inventory-sales.png` agar gambar tampil di GitHub.

## Lisensi

Proyek ini dikembangkan untuk keperluan pembelajaran. Ketentuan lisensi Laravel dan dependensi pihak ketiga mengikuti lisensi masing-masing.

---

**Nexora Tech**  
*Smarter Inventory. Better Business.*
