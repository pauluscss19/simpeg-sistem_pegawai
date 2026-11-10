# SIMPEG - Sistem Informasi Manajemen Data Pegawai

Aplikasi web **Manajemen Data Pegawai** berbasis **Laravel**, **Blade**, **SQLite**, dan **Chart.js** dengan tampilan modern menggunakan **Sidebar Responsif** yang dirancang sesuai standar uji kompetensi **Junior Web Programming**.

Aplikasi ini beroperasi 100% secara **offline** tanpa memerlukan koneksi internet setelah penyiapan karena seluruh aset (Bootstrap 5 dan Chart.js) telah terpasang secara lokal di dalam folder `public/`.

---

## 📋 Daftar Fitur Utama

1. **Kelola Data Pegawai (CRUD Penuh)**:
   - **Tambah Pegawai**: Formulir input NIP, Nama Lengkap, Jenis Kelamin, Pendidikan Terakhir, dan Tanggal Lahir.
   - **Lihat & Cari Pegawai**: Daftar pegawai dengan tabel rapi, penomoran berurutan, paginasi, serta fitur pencarian data secara real-time.
   - **Detail Pegawai**: Halaman profil lengkap pegawai menampilkan NIP, usia terhitung otomatis, dan riwayat waktu pembuatan/pembaruan.
   - **Ubah Pegawai**: Formulir edit data dengan kemampuan mempertahankan NIP asli pegawai tanpa terkena validasi duplikat.
   - **Hapus Pegawai**: Dilengkapi perlindungan pop-up modal konfirmasi.

2. **Pop-up Konfirmasi Hapus Interaktif**:
   - Setiap tombol **Hapus** membuka modal dialog konfirmasi yang menampilkan **Nama** dan **NIP** pegawai yang akan dihapus.
   - **Pilihan Batal**: Menutup pop-up modal dan memastikan formulir tidak dikirim, sehingga data pegawai tetap aman tersimpan di database.
   - **Pilihan Hapus**: Mengirim formulir penghapusan menggunakan token `@csrf` dan direktif `@method('DELETE')`.

3. **Dashboard Statistik dengan 3 Grafik Dinamis (Chart.js)**:
   - **Grafik Batang Perbandingan Jenis Kelamin**: Membandingkan jumlah pegawai Laki-laki dan Perempuan secara proporsional.
   - **Grafik Batang Jenjang Pendidikan Terakhir**: Menampilkan distribusi pegawai dari jenjang SD, SMP, SMA/SMK, D3, S1, S2, hingga S3. Kategori bernilai 0 tetap ditampilkan secara konsisten.
   - **Grafik Batang Kelompok Usia**: Mengelompokkan pegawai ke dalam 5 rentang usia:
     - Di bawah 20 tahun (`< 20`)
     - 20–29 tahun
     - 30–39 tahun
     - 40–49 tahun
     - 50 tahun ke atas (`>= 50`)
   - **Update Angka Aktual**: Angka grafik langsung terbarui secara dinamis saat dashboard dibuka kembali setelah aksi penambahan, pengubahan, atau penghapusan data.
   - **Pesan Kondisi Kosong**: Menampilkan pesan informatif yang ramah jika database belum memiliki data pegawai.

4. **Validasi Formulir Ketat (Form Request)**:
   - NIP unik, wajib angka, dan disimpan sebagai tipe data teks agar angka `0` (nol) di awal tidak hilang.
   - Mempertahankan NIP milik pegawai yang bersangkutan saat formulir edit disimpan.
   - Menolak tanggal lahir di masa depan (`before_or_equal:today`).
   - Mempertahankan isian form pengguna (`old(...)`) dan menampilkan pesan galat berbahasa Indonesia langsung di dekat bidang input (`@error`).

---

## 💻 Prasyarat Sistem

- **PHP**: Versi 8.2 atau lebih baru (PHP 8.4 didukung penuh).
- **Ekstensi PHP**: `pdo_sqlite`, `sqlite3`, `mbstring`, `openssl`, `curl`. (Sudah aktif pada XAMPP standar).
- **Web Server / Database**: XAMPP (Apache/MySQL opsional) atau PHP Built-in Server dengan SQLite.
- **Composer**: Versi 2.x.

---

## 🚀 Langkah Instalasi & Konfigurasi

### 1. Masuk ke Direktori Proyek
Buka terminal atau PowerShell di folder proyek ini:
```powershell
cd C:\Users\ACER\cs_6_ujikom
```

### 2. Konfigurasi Lingkungan (`.env`) & Basis Data SQLite
File `.env` sudah dikonfigurasi menggunakan SQLite:
```env
DB_CONNECTION=sqlite
# database/database.sqlite
```

Jika file database belum ada, buat file kosong SQLite melalui perintah PowerShell:
```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

Buat Application Key Laravel:
```powershell
php artisan key:generate
```

### 3. Menjalankan Migration dan Seeder
Jalankan migrasi tabel `pegawai` dan seeder data fiktif:
```powershell
php artisan migrate
php artisan db:seed
```
> **Catatan Idempotensi Seeder**: `PegawaiSeeder` menggunakan metode `updateOrCreate` berbasis `nip`. Perintah `php artisan db:seed` dapat dijalankan berulang kali tanpa risiko terjadi duplikasi data.

### 4. Aset Lokal (Offline Ready)
Seluruh aset CSS dan JS telah terpasang di direktori publik:
- `public/css/bootstrap.min.css` (Bootstrap 5)
- `public/js/bootstrap.bundle.min.js` (Bootstrap 5 Bundle)
- `public/js/chart.umd.min.js` (Chart.js UMD)

Aplikasi dapat dijalankan tanpa koneksi internet sama sekali.

---

## 🌐 Menjalankan Server Lokal

Jalankan perintah artisan serve:
```powershell
php artisan serve
```

Buka peramban (browser) dan akses alamat:
👉 **`http://127.0.0.1:8000`** atau **`http://localhost:8000`**

---

## 🎯 Panduan Skenario Demo untuk Asesor / Penguji

Ikuti alur pengujian singkat berikut untuk memperlihatkan pemenuhan seluruh kriteria uji kompetensi:

### Skenario 1: Meninjau Dashboard Statistik Awal
1. Buka halaman utama: `http://127.0.0.1:8000`.
2. Asesor akan melihat ringkasan kartu: **Total Pegawai**, **Pegawai Laki-laki**, **Pegawai Perempuan**, dan **Rata-rata Usia**.
3. Periksa ketiga grafik interaktif:
   - **Grafik 1**: Batang Laki-laki vs Perempuan.
   - **Grafik 2**: Jenjang Pendidikan (SD, SMP, SMA/SMK, D3, S1, S2, S3).
   - **Grafik 3**: Kelompok Usia (`< 20`, `20–29`, `30–39`, `40–49`, `50 ke atas`).

### Skenario 2: Menambah Data Pegawai Baru (Validasi Server)
1. Klik tombol **Tambah Pegawai** di navbar atau dashboard.
2. **Uji Validasi NIP Duplikat**:
   - Masukkan NIP yang sudah ada di seeder: `098101012024011001`.
   - Isi field lainnya lalu klik **Simpan Pegawai**.
   - Sistem akan menolak dan memunculkan pesan kesalahan: *"NIP sudah terdaftar di sistem. Gunakan NIP lain."* Isian form tetap terjaga.
3. **Uji Validasi Tanggal Lahir Masa Depan**:
   - Pilih tanggal lahir besok atau tahun depan.
   - Sistem akan menolak dengan pesan: *"Tanggal lahir tidak valid atau tidak boleh berada di masa depan."*
4. **Uji Input Sukses (Mempertahankan Angka 0 di Awal NIP)**:
   - Masukkan NIP baru berawalan nol: `012345678901234567`.
   - Nama: `Budi Hartono, S.Kom`.
   - Jenis Kelamin: `Laki-laki`.
   - Pendidikan Terakhir: `S1`.
   - Tanggal Lahir: `2005-06-15` (Usia: 21 tahun, masuk kelompok 20–29).
   - Klik **Simpan Pegawai**. Notifikasi hijau sukses akan muncul.

### Skenario 3: Memeriksa Data & Melakukan Perubahan (Edit)
1. Cari pegawai yang baru ditambahkan melalui kotak pencarian.
2. Klik tombol **Lihat (Detail)** untuk melihat rincian biodata dan usia yang dihitung otomatis.
3. Klik tombol **Ubah (Edit)**:
   - Tanpa mengubah NIP `012345678901234567`, ubah jenjang pendidikan menjadi `S2`.
   - Klik **Perbarui Pegawai**. Sistem menerima penyimpanan (NIP milik sendiri tidak dianggap duplikat).

### Skenario 4: Menguji Pop-up Konfirmasi Hapus (Pilihan "Batal")
1. Pada tabel daftar pegawai, klik ikon merah **Hapus** pada baris pegawai `Budi Hartono, S.Kom`.
2. Muncul jendela pop-up modal bertuliskan nama pegawai: **Budi Hartono, S.Kom** dan NIP: **012345678901234567**.
3. Klik tombol **Batal** atau tanda silang (X).
4. **Hasil**: Pop-up tertutup, tidak ada data yang terhapus, dan pegawai tetap berada di tabel.

### Skenario 5: Menguji Konfirmasi Hapus (Pilihan "Hapus")
1. Klik kembali tombol **Hapus** pada pegawai `Budi Hartono, S.Kom`.
2. Pada pop-up konfirmasi, klik tombol merah **Hapus**.
3. **Hasil**: Formulir terkirim dengan metode `DELETE`, data terhapus permanen, dan muncul notifikasi sukses: *"Data pegawai 'Budi Hartono, S.Kom' berhasil dihapus dari sistem."*

### Skenario 6: Memverifikasi Pembaruan Grafik Real-Time di Dashboard
1. Buka kembali menu **Dashboard**.
2. Angka total pegawai dan grafik batang langsung mencerminkan data aktual di database setelah proses tambah, edit, dan hapus yang baru saja dilakukan.

---

## 🏛️ Penjelasan Arsitektur Teknis

### 1. Struktur Kelas Laravel
- **Model Eloquent (`App\Models\Pegawai`)**:
  - Merepresentasikan tabel `pegawai`.
  - Properti `$fillable` mengamankan atribut dari *mass assignment*.
  - Properti `$casts` mengonversi `tanggal_lahir` menjadi objek tanggal.
  - Accessor `getUsiaAttribute()` menghitung usia dinamis pegawai secara presisi terhadap tanggal hari ini.
  - Accessor `getTanggalLahirFormattedAttribute()` memformat tanggal lahir ke format lokal Indonesia (*dd Bulan YYYY*).
- **Pengontrol (`DashboardController`)**:
  - Bertanggung jawab memisahkan seluruh logika statistik agregasi dari tampilan (*separation of concerns*).
  - Menghitung frekuensi data dan menyusun array asosiatif untuk grafik.
- **Pengontrol (`PegawaiController`)**:
  - Mengelola 7 metode resource: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`.
- **Form Request (`StorePegawaiRequest` & `UpdatePegawaiRequest`)**:
  - Melakukan validasi di lapisan terpisah dari controller (*Form Request Validation*).
  - Menggunakan aturan `Rule::unique('pegawai', 'nip')->ignore(...)` agar pembaruan data pegawai tidak memicu konflik NIP miliknya sendiri.

### 2. Penggunaan Array Asosiatif untuk Agregasi Statistik
Untuk mencegah *missing index* dan memastikan semua kategori selalu memiliki nilai (termasuk yang bernilai nol):
```php
$genderCounts = [
    'Laki-laki' => 0,
    'Perempuan' => 0,
];

$pendidikanCounts = [
    'SD' => 0, 'SMP' => 0, 'SMA/SMK' => 0,
    'D3' => 0, 'S1' => 0, 'S2' => 0, 'S3' => 0,
];

$usiaCounts = [
    'Di bawah 20' => 0,
    '20–29'       => 0,
    '30–39'       => 0,
    '40–49'       => 0,
    '50 ke atas'  => 0,
];
```
Setiap rekaman pegawai diiterasi dan menambahkan nilai hitungan pada kunci yang sesuai (`$genderCounts[$pegawai->jenis_kelamin]++`).

### 3. Algoritma Pengelompokan Usia
Usia dihitung menggunakan library `Carbon` dari tanggal lahir terhadap waktu saat ini:
```php
$usia = \Carbon\Carbon::parse($pegawai->tanggal_lahir)->age;
```
Kemudian dikelompokkan ke dalam 5 rentang diskrit:
```php
if ($usia < 20) {
    $usiaCounts['Di bawah 20']++;
} elseif ($usia >= 20 && $usia <= 29) {
    $usiaCounts['20–29']++;
} elseif ($usia >= 30 && $usia <= 39) {
    $usiaCounts['30–39']++;
} elseif ($usia >= 40 && $usia <= 49) {
    $usiaCounts['40–49']++;
} else {
    $usiaCounts['50 ke atas']++;
}
```

### 4. Serialisasi JSON dan Integrasi Chart.js
Data dari array asosiatif dipisahkan menjadi label dan nilai (`array_keys` dan `array_values`), lalu diserialisasi dengan flag encoding aman:
```php
json_encode($chartData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
```
Data JSON ini kemudian disuntikkan ke Blade dan di-render oleh library lokal Chart.js:
```javascript
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: dataUsia.labels,
        datasets: [{ data: dataUsia.data, ... }]
    },
    ...
});
```

---

## 📁 Struktur Direktori Penting

```text
cs_6_ujikom/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php   # Logika agregasi 3 grafik statistik
│   │   │   └── PegawaiController.php     # Controller resource CRUD data pegawai
│   │   └── Requests/
│   │       ├── StorePegawaiRequest.php   # Validasi penambahan pegawai
│   │       └── UpdatePegawaiRequest.php  # Validasi pengubahan pegawai
│   └── Models/
│       └── Pegawai.php                   # Model Eloquent Pegawai & Accessor usia
├── database/
│   ├── database.sqlite                   # Berkas database SQLite aktif
│   ├── migrations/
│   │   └── 2026_11_10_085358_create_pegawai_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── PegawaiSeeder.php             # Seeder idempotent 13 pegawai fiktif
├── public/
│   ├── css/
│   │   └── bootstrap.min.css             # Aset lokal Bootstrap 5 CSS
│   └── js/
│       ├── bootstrap.bundle.min.js       # Aset lokal Bootstrap 5 JS
│       └── chart.umd.min.js              # Aset lokal Chart.js
├── resources/
│   └── views/
│       ├── dashboard.blade.php           # Tampilan dashboard statistik & 3 grafik
│       ├── layouts/
│       │   └── app.blade.php             # Layout utama Blade (Navbar, Flash, Footer)
│       └── pegawai/
│           ├── index.blade.php           # Tabel pegawai & Modal pop-up hapus
│           ├── create.blade.php          # Formulir tambah pegawai
│           ├── edit.blade.php            # Formulir ubah pegawai
│           └── show.blade.php            # Halaman detail pegawai
├── routes/
│   └── web.php                           # Definisi rute dashboard & resource pegawai
├── .env                                  # Konfigurasi environment (SQLite)
└── README.md                             # Dokumentasi & panduan demo asesor
```

---
*Dikembangkan untuk pemenuhan tugas uji kompetensi Junior Web Programming.*
