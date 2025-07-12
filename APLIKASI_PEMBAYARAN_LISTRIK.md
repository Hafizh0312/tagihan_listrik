# Aplikasi Pembayaran Listrik Pascabayar

## Gambaran Umum

Aplikasi ini adalah sistem pembayaran listrik pascabayar yang memungkinkan admin mengelola pelanggan, penggunaan listrik, dan tagihan, serta pelanggan dapat melihat data penggunaan dan tagihan mereka.

## Struktur Database

### Tabel Utama:
1. **`users`** - Data pengguna (admin & pelanggan)
2. **`level`** - Tarif berdasarkan daya listrik
3. **`pelanggan`** - Data pelanggan
4. **`penggunaan`** - Penggunaan listrik per bulan
5. **`tagihan`** - Tagihan listrik

### Relasi Database:
```
users (1) ←→ (1) pelanggan
pelanggan (1) ←→ (N) penggunaan
penggunaan (1) ←→ (1) tagihan
level (1) ←→ (N) pelanggan
```

## Workflow untuk Masing-masing User

### 1. **ADMIN** (Role: admin)

#### 🔐 Login & Dashboard
```
Login Form → Validasi Credentials → Dashboard Admin → Menu Utama
```

#### 👥 Workflow Menu Pelanggan
```
Dashboard → Kelola Pelanggan → 
├── 📋 Lihat Daftar Pelanggan
├── ➕ Tambah Pelanggan Baru
│   ├── Input Nama Pelanggan
│   ├── Input Alamat
│   ├── Pilih Level Daya
│   └── Pilih User Account
├── ✏️ Edit Data Pelanggan
│   ├── Update Nama/Alamat
│   ├── Update Level Daya
│   └── Update User Account
└── 🗑️ Hapus Pelanggan
    ├── Validasi Dependensi
    └── Konfirmasi Penghapusan
```

#### ⚡ Workflow Menu Penggunaan Listrik
```
Dashboard → Kelola Penggunaan → 
├── 📊 Lihat Semua Penggunaan
├── ➕ Input Penggunaan Baru
│   ├── Pilih Pelanggan
│   ├── Input Bulan/Tahun
│   ├── Input Meter Awal
│   ├── Input Meter Akhir
│   ├── Validasi Data
│   └── Simpan Penggunaan
├── ✏️ Edit Penggunaan
│   ├── Update Meter Awal/Akhir
│   ├── Validasi Perubahan
│   └── Update Tagihan Otomatis
├── 🗑️ Hapus Penggunaan
│   ├── Validasi Tagihan
│   └── Hapus Tagihan Terkait
└── 📈 Statistik Penggunaan
    ├── Total KWH per Pelanggan
    ├── Rata-rata Penggunaan
    └── Grafik Penggunaan
```

#### 💰 Workflow Menu Tagihan
```
Dashboard → Kelola Tagihan → 
├── 📋 Lihat Semua Tagihan
├── 🔄 Generate Tagihan Otomatis
│   ├── Pilih Periode
│   ├── Hitung Total KWH
│   ├── Hitung Total Tagihan
│   └── Buat Tagihan Baru
├── ✏️ Update Status Pembayaran
│   ├── Pilih Tagihan
│   ├── Update Status (Lunas/Belum Lunas)
│   └── Update Tanggal Pembayaran
├── 📊 Laporan Tagihan
│   ├── Tagihan per Periode
│   ├── Tagihan per Pelanggan
│   ├── Tagihan Belum Lunas
│   └── Total Penerimaan
└── 📈 Statistik Tagihan
    ├── Total Tagihan
    ├── Tagihan Lunas
    ├── Tagihan Belum Lunas
    └── Total Penerimaan
```

#### ⚙️ Workflow Menu Level/Tarif
```
Dashboard → Kelola Tarif → 
├── 📋 Lihat Daftar Tarif
├── ➕ Tambah Level Daya Baru
│   ├── Input Daya (Watt)
│   ├── Input Tarif per KWH
│   └── Validasi Data
├── ✏️ Edit Tarif per KWH
│   ├── Update Tarif
│   ├── Validasi Perubahan
│   └── Update Tagihan Terkait
├── 🗑️ Hapus Level Daya
│   ├── Validasi Pelanggan
│   └── Konfirmasi Penghapusan
└── 📊 Statistik Tarif
    ├── Rata-rata Tarif
    ├── Tarif Tertinggi/Terendah
    └── Jumlah Pelanggan per Level
```

### 2. **PELANGGAN** (Role: pelanggan)

#### 🔐 Login & Dashboard
```
Login Form → Validasi Credentials → Dashboard Pelanggan → Menu Utama
```

#### 👤 Workflow Menu Profil
```
Dashboard → Profil Saya → 
├── 👁️ Lihat Data Pribadi
│   ├── Nama Pelanggan
│   ├── Alamat
│   ├── Level Daya
│   └── Tarif per KWH
├── ✏️ Edit Data Pribadi
│   ├── Update Nama
│   ├── Update Alamat
│   └── Validasi Perubahan
└── 🔐 Ganti Password
    ├── Input Password Lama
    ├── Input Password Baru
    ├── Konfirmasi Password
    └── Update Password
```

#### ⚡ Workflow Menu Penggunaan Listrik
```
Dashboard → Penggunaan Listrik → 
├── 📊 Lihat Riwayat Penggunaan
│   ├── Penggunaan per Bulan
│   ├── Total KWH per Bulan
│   └── Grafik Penggunaan
├── 📋 Detail Penggunaan per Bulan
│   ├── Meter Awal
│   ├── Meter Akhir
│   ├── Total KWH
│   └── Periode Penggunaan
└── 📈 Statistik Penggunaan
    ├── Total KWH Keseluruhan
    ├── Rata-rata KWH per Bulan
    ├── Penggunaan Tertinggi/Terendah
    └── Trend Penggunaan
```

#### 💰 Workflow Menu Tagihan
```
Dashboard → Tagihan Listrik → 
├── 📋 Lihat Tagihan Terbaru
│   ├── Tagihan Belum Lunas
│   ├── Total Tagihan
│   └── Batas Waktu Pembayaran
├── 📊 Riwayat Tagihan
│   ├── Semua Tagihan
│   ├── Status Pembayaran
│   └── Total Pembayaran
├── 📄 Detail Tagihan
│   ├── Periode Tagihan
│   ├── Total KWH
│   ├── Tarif per KWH
│   ├── Total Tagihan
│   └── Status Pembayaran
└── 📈 Statistik Tagihan
    ├── Total Tagihan
    ├── Tagihan Lunas
    ├── Tagihan Belum Lunas
    └── Total Pembayaran
```

## Implementasi Teknis

### 1. **Koneksi Database**
- Menggunakan CodeIgniter Database Class
- Konfigurasi di `application/config/database.php`
- Koneksi aman dengan validasi input

### 2. **Library Akses Database**
- **User_model**: Manajemen user dan autentikasi
- **Pelanggan_model**: CRUD data pelanggan
- **Penggunaan_model**: CRUD data penggunaan listrik
- **Tagihan_model**: CRUD data tagihan
- **Level_model**: Manajemen tarif listrik

### 3. **Keamanan Koneksi**
- Password hashing dengan BCRYPT
- Session management
- Role-based access control
- Input validation dan sanitization
- SQL injection prevention

### 4. **Indeks Database**
- Primary key pada semua tabel
- Foreign key constraints
- Index pada kolom yang sering dicari:
  - `users.username`
  - `pelanggan.user_id`
  - `penggunaan.pelanggan_id`
  - `tagihan.penggunaan_id`

### 5. **Query Performance**
- Menggunakan JOIN untuk relasi data
- Query optimization dengan index
- Pagination untuk data besar
- Caching untuk data statis

## Fitur Utama

### ✅ **CRUD Operations**
- Create: Tambah data baru
- Read: Baca dan tampilkan data
- Update: Edit data existing
- Delete: Hapus data dengan validasi

### ✅ **Role-Based Access**
- Admin: Akses penuh ke semua fitur
- Pelanggan: Akses terbatas ke data sendiri

### ✅ **Automatic Calculations**
- Perhitungan otomatis total KWH
- Perhitungan otomatis total tagihan
- Generate tagihan dari data penggunaan

### ✅ **Data Validation**
- Validasi input form
- Validasi relasi database
- Validasi business rules

### ✅ **Reporting**
- Laporan penggunaan listrik
- Laporan tagihan
- Statistik dan grafik
- Export data (opsional)

## Testing Skenario

### 1. **Testing Login**
- Login dengan credentials valid
- Login dengan credentials invalid
- Logout functionality
- Session management

### 2. **Testing CRUD Operations**
- Create data baru
- Read data existing
- Update data
- Delete data dengan validasi

### 3. **Testing Business Logic**
- Perhitungan tagihan otomatis
- Validasi meter akhir > meter awal
- Validasi periode penggunaan unik
- Validasi relasi data

### 4. **Testing Performance**
- Query response time
- Database connection stability
- Memory usage optimization
- Concurrent user access

### 5. **Testing Security**
- SQL injection prevention
- XSS protection
- CSRF protection
- Session hijacking prevention

## File Structure

```
application/
├── config/
│   ├── database.php
│   └── autoload.php
├── controllers/
│   ├── Auth.php
│   ├── Admin/
│   │   ├── Dashboard.php
│   │   ├── Pelanggan.php
│   │   ├── Penggunaan.php
│   │   ├── Tagihan.php
│   │   └── Level.php
│   └── Pelanggan/
│       ├── Dashboard.php
│       ├── Profil.php
│       ├── Penggunaan.php
│       └── Tagihan.php
├── models/
│   ├── User_model.php
│   ├── Pelanggan_model.php
│   ├── Penggunaan_model.php
│   ├── Tagihan_model.php
│   └── Level_model.php
└── views/
    ├── auth/
    │   ├── login.php
    │   ├── register.php
    │   └── change_password.php
    ├── admin/
    │   ├── dashboard.php
    │   ├── pelanggan/
    │   ├── penggunaan/
    │   ├── tagihan/
    │   └── level/
    └── pelanggan/
        ├── dashboard.php
        ├── profil.php
        ├── penggunaan.php
        └── tagihan.php
```

## Kesimpulan

Aplikasi ini menyediakan sistem manajemen pembayaran listrik yang lengkap dengan:

1. **Sistem client-server** berbasis web
2. **Role-based access control** (admin & pelanggan)
3. **CRUD operations** untuk semua entitas
4. **Automatic calculations** untuk tagihan
5. **Security features** untuk keamanan data
6. **Performance optimization** dengan indexing
7. **Comprehensive testing** untuk semua fitur

Aplikasi ini siap untuk deployment dan dapat dikembangkan lebih lanjut sesuai kebutuhan bisnis. 