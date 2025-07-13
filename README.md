# Sistem Pembayaran Listrik PLN

## 📋 Deskripsi Proyek

Sistem Pembayaran Listrik PLN adalah aplikasi web yang dibangun menggunakan framework CodeIgniter 3 untuk mengelola sistem pembayaran listrik pascabayar. Aplikasi ini memungkinkan admin untuk mengelola data pelanggan, penggunaan listrik, dan tagihan, serta memberikan akses kepada pelanggan untuk melihat data penggunaan dan tagihan mereka.

## 🚀 Fitur Utama

### 👨‍💼 Panel Admin
- **Dashboard Admin**: Statistik lengkap sistem dengan grafik dan data real-time
- **Manajemen Pelanggan**: CRUD data pelanggan dengan validasi
- **Manajemen Penggunaan**: Input dan kelola data penggunaan listrik
- **Manajemen Tagihan**: Generate dan kelola tagihan otomatis
- **Manajemen Tarif**: Kelola tarif listrik berdasarkan daya
- **Laporan & Statistik**: Laporan penggunaan dan tagihan
- **Export Data**: Export data ke Excel
- **Print Tagihan**: Cetak tagihan dalam format PDF

### 👤 Panel Pelanggan
- **Dashboard Pelanggan**: Overview penggunaan dan tagihan
- **Riwayat Penggunaan**: Lihat riwayat penggunaan listrik
- **Tagihan**: Lihat dan cek status tagihan
- **Profil**: Update data profil dan password

### 🔐 Sistem Autentikasi
- Login multi-role (Admin & Pelanggan)
- Validasi session dan akses
- Password hashing dengan bcrypt
- Logout otomatis

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP 7.4+ dengan CodeIgniter 3
- **Database**: MySQL 5.7+
- **Frontend**: Bootstrap 5, jQuery, Chart.js
- **Server**: Apache/Nginx dengan XAMPP
- **Dependencies**: Composer untuk package management

## 📁 Struktur Proyek

```
tes-pln/
├── application/
│   ├── config/           # Konfigurasi aplikasi
│   ├── controllers/      # Controller untuk logika bisnis
│   │   ├── Admin/       # Controller untuk admin
│   │   ├── Pelanggan/   # Controller untuk pelanggan
│   │   └── Auth.php     # Controller autentikasi
│   ├── models/          # Model untuk interaksi database
│   ├── views/           # View templates
│   │   ├── admin/       # View untuk admin
│   │   ├── pelanggan/   # View untuk pelanggan
│   │   └── auth/        # View autentikasi
│   └── helpers/         # Helper functions
├── database.sql         # Script database
├── composer.json        # Dependencies
└── index.php           # Entry point
```

## 🗄️ Struktur Database

### Tabel Utama

1. **users** - Data pengguna sistem
   - `user_id` (Primary Key)
   - `username` (Unique)
   - `password` (Hashed)
   - `nama` (Nama lengkap)
   - `role` (admin/pelanggan)

2. **levels** - Tarif listrik berdasarkan daya
   - `level_id` (Primary Key)
   - `daya` (Daya dalam Watt)
   - `tarif_per_kwh` (Tarif per KWH)

3. **pelanggan** - Data pelanggan listrik
   - `pelanggan_id` (Primary Key)
   - `nama` (Nama pelanggan)
   - `alamat` (Alamat lengkap)
   - `user_id` (Foreign Key ke users)
   - `level_id` (Foreign Key ke levels)

4. **penggunaan** - Data penggunaan listrik
   - `penggunaan_id` (Primary Key)
   - `pelanggan_id` (Foreign Key)
   - `bulan` (Bulan penggunaan)
   - `tahun` (Tahun penggunaan)
   - `meter_awal` (Meteran awal)
   - `meter_akhir` (Meteran akhir)

5. **tagihan** - Data tagihan listrik
   - `tagihan_id` (Primary Key)
   - `penggunaan_id` (Foreign Key)
   - `pelanggan_id` (Foreign Key)
   - `bulan` (Bulan tagihan)
   - `tahun` (Tahun tagihan)
   - `total_kwh` (Total penggunaan KWH)
   - `total_tagihan` (Total tagihan)
   - `status` (Lunas/Belum Lunas)

## ⚙️ Instalasi

### Prasyarat
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache/Nginx web server
- Composer (opsional)

### Langkah Instalasi

1. **Clone atau Download Proyek**
   ```bash
   git clone [repository-url]
   cd tes-pln
   ```

2. **Setup Database**
   - Buat database MySQL baru
   - Import file `database.sql`
   - Atau jalankan script SQL secara manual

3. **Konfigurasi Database**
   - Edit file `application/config/database.php`
   - Sesuaikan konfigurasi database:
   ```php
   $db['default'] = array(
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'pembayaran_listrik',
       'dbdriver' => 'mysqli',
       // ... konfigurasi lainnya
   );
   ```

4. **Setup Web Server**
   - Pastikan web server mengarah ke folder proyek
   - Untuk XAMPP: Pindahkan folder ke `htdocs/`
   - Akses melalui: `http://localhost/tes-pln`

5. **Install Dependencies (Opsional)**
   ```bash
   composer install
   ```

6. **Set Permissions**
   - Pastikan folder `application/cache/` dan `application/logs/` dapat ditulis

### Default Login

**Admin:**
- Username: `admin`
- Password: `admin123`

**Pelanggan Sample:**
- Username: `pelanggan1`
- Password: `admin123`

## 🔧 Konfigurasi

### Konfigurasi Aplikasi
File: `application/config/config.php`
- Base URL
- Session timeout
- Encryption key
- Error reporting

### Konfigurasi Database
File: `application/config/database.php`
- Database connection
- Query caching
- Character set

### Konfigurasi Routes
File: `application/config/routes.php`
- Default controller: `auth`
- Custom routes untuk admin dan pelanggan

## 📊 Fitur Detail

### Dashboard Admin
- **Statistik Total**: Pelanggan, penggunaan, tagihan, tarif
- **Grafik Bulanan**: Trend tagihan 6 bulan terakhir
- **Status Tagihan**: Pie chart status lunas/belum lunas
- **Data Terbaru**: Pelanggan dan tagihan terbaru

### Manajemen Pelanggan
- **Tambah Pelanggan**: Form lengkap dengan validasi
- **Edit Pelanggan**: Update data pelanggan
- **Hapus Pelanggan**: Soft delete dengan konfirmasi
- **Cari Pelanggan**: Pencarian berdasarkan nama/nomor KWH
- **Detail Pelanggan**: Riwayat penggunaan dan tagihan

### Manajemen Penggunaan
- **Input Penggunaan**: Form input meteran awal/akhir
- **Validasi Otomatis**: Cek duplikasi periode
- **Generate Tagihan**: Otomatis generate tagihan setelah input
- **Edit Penggunaan**: Update data penggunaan
- **Statistik**: Grafik penggunaan per bulan

### Manajemen Tagihan
- **Generate Tagihan**: Otomatis dari data penggunaan
- **Update Status**: Mark as paid/unpaid
- **Print Tagihan**: Cetak dalam format yang rapi
- **Export Excel**: Export data tagihan
- **Bulk Actions**: Update status multiple tagihan

### Panel Pelanggan
- **Dashboard**: Overview penggunaan dan tagihan
- **Riwayat Penggunaan**: Timeline penggunaan listrik
- **Tagihan**: Daftar dan detail tagihan
- **Profil**: Update data pribadi dan password

## 🔒 Keamanan

### Autentikasi & Otorisasi
- Session-based authentication
- Role-based access control (RBAC)
- Password hashing dengan bcrypt
- CSRF protection
- Input validation dan sanitization

### Validasi Data
- Form validation menggunakan CodeIgniter
- Custom validation rules
- SQL injection prevention
- XSS protection

## 📈 Laporan & Statistik

### Dashboard Statistik
- Total pelanggan aktif
- Total penggunaan KWH
- Total tagihan (lunas/belum lunas)
- Grafik trend bulanan
- Status tagihan real-time

### Export & Print
- Export data ke Excel
- Print tagihan PDF
- Laporan penggunaan
- Statistik pelanggan

## 🐛 Troubleshooting

### Masalah Umum

1. **Error Database Connection**
   - Cek konfigurasi database di `application/config/database.php`
   - Pastikan MySQL service berjalan
   - Cek username dan password database

2. **Error 404 Not Found**
   - Pastikan mod_rewrite Apache aktif
   - Cek file `.htaccess`
   - Pastikan base URL benar

3. **Session Error**
   - Cek folder `application/cache/` permissions
   - Restart web server
   - Clear browser cache

4. **Upload Error**
   - Cek folder upload permissions
   - Pastikan PHP upload_max_filesize cukup
   - Cek allowed file types

### Log Files
- Application logs: `application/logs/`
- Error logs: `application/logs/`
- Database logs: MySQL error log

## 🔄 Update & Maintenance

### Backup Database
```bash
mysqldump -u root -p pembayaran_listrik > backup.sql
```

### Update Aplikasi
1. Backup database dan file
2. Upload file baru
3. Jalankan migration (jika ada)
4. Test aplikasi

### Performance Optimization
- Enable query caching
- Optimize database indexes
- Use CDN for static assets
- Enable gzip compression

## 📞 Support

### Kontak Developer
- Email: [developer-email]
- GitHub: [repository-url]
- Documentation: [docs-url]

### Bug Report
- Gunakan GitHub Issues
- Sertakan screenshot dan detail error
- Jelaskan langkah reproduksi

## 📄 License

Proyek ini menggunakan license MIT. Lihat file `LICENSE` untuk detail lengkap.

## 🤝 Contributing

1. Fork repository
2. Buat feature branch
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## 📝 Changelog

### Version 1.0.0
- Initial release
- Basic CRUD operations
- Admin and customer panels
- Authentication system
- Reporting features

---

**Dibuat dengan ❤️ menggunakan CodeIgniter 3** 