# SISTEM PEMBAYARAN LISTRIK PASCABAYAR - DOKUMENTASI LENGKAP

## 📋 DAFTAR ISI
1. [Overview Sistem](#overview-sistem)
2. [Arsitektur Aplikasi](#arsitektur-aplikasi)
3. [Database Design](#database-design)
4. [Controller & Model](#controller--model)
5. [Views & UI](#views--ui)
6. [Fitur & Workflow](#fitur--workflow)
7. [Instalasi & Konfigurasi](#instalasi--konfigurasi)
8. [Testing & Deployment](#testing--deployment)

## 🎯 OVERVIEW SISTEM

### Deskripsi
Sistem Pembayaran Listrik Pascabayar adalah aplikasi web berbasis CodeIgniter 3.1.13 yang dirancang untuk mengelola pembayaran listrik dengan sistem pascabayar. Aplikasi ini mendukung dua jenis pengguna: **Admin** dan **Pelanggan**.

### Fitur Utama
- ✅ **Manajemen Pelanggan**: CRUD data pelanggan
- ✅ **Penggunaan Listrik**: Input dan monitoring penggunaan
- ✅ **Tagihan Otomatis**: Generate tagihan berdasarkan penggunaan
- ✅ **Level Tarif**: Manajemen tarif listrik per daya
- ✅ **Dashboard Analytics**: Statistik dan laporan
- ✅ **Multi-User**: Admin dan Pelanggan dengan akses berbeda
- ✅ **Export PDF**: Laporan dalam format PDF
- ✅ **Responsive Design**: Kompatibel mobile dan desktop

## 🏗️ ARSITEKTUR APLIKASI

### Struktur Folder
```
tes-pln/
├── application/
│   ├── controllers/
│   │   ├── Admin/
│   │   │   ├── Dashboard.php
│   │   │   ├── Pelanggan.php
│   │   │   ├── Penggunaan.php
│   │   │   ├── Tagihan.php
│   │   │   └── Level.php
│   │   ├── Pelanggan/
│   │   │   ├── Dashboard.php
│   │   │   ├── Profil.php
│   │   │   ├── Penggunaan.php
│   │   │   └── Tagihan.php
│   │   └── Auth.php
│   ├── models/
│   │   ├── User_model.php
│   │   ├── Pelanggan_model.php
│   │   ├── Penggunaan_model.php
│   │   ├── Tagihan_model.php
│   │   └── Level_model.php
│   ├── views/
│   │   ├── admin/
│   │   │   ├── dashboard.php
│   │   │   ├── pelanggan/
│   │   │   ├── penggunaan/
│   │   │   ├── tagihan/
│   │   │   └── level/
│   │   ├── pelanggan/
│   │   │   ├── dashboard.php
│   │   │   ├── profil/
│   │   │   ├── penggunaan/
│   │   │   └── tagihan/
│   │   └── auth/
│   │       └── login.php
│   └── config/
│       ├── database.php
│       └── config.php
└── system/
```

### Teknologi yang Digunakan
- **Backend**: CodeIgniter 3.1.13, PHP 8.2
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5, Font Awesome 6
- **PDF**: TCPDF (untuk export laporan)
- **Security**: Session-based authentication, CSRF protection

## 🗄️ DATABASE DESIGN

### Tabel Users
```sql
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'pelanggan') DEFAULT 'pelanggan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tabel Levels
```sql
CREATE TABLE levels (
    level_id INT PRIMARY KEY AUTO_INCREMENT,
    daya INT NOT NULL,
    tarif_per_kwh DECIMAL(10,2) NOT NULL
);
```

### Tabel Pelanggan
```sql
CREATE TABLE pelanggan (
    pelanggan_id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    user_id INT,
    level_id INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (level_id) REFERENCES levels(level_id)
);
```

### Tabel Penggunaan
```sql
CREATE TABLE penggunaan (
    penggunaan_id INT PRIMARY KEY AUTO_INCREMENT,
    pelanggan_id INT,
    bulan INT NOT NULL,
    tahun INT NOT NULL,
    meter_awal DECIMAL(10,2) NOT NULL,
    meter_akhir DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(pelanggan_id)
);
```

### Tabel Tagihan
```sql
CREATE TABLE tagihan (
    tagihan_id INT PRIMARY KEY AUTO_INCREMENT,
    penggunaan_id INT,
    pelanggan_id INT,
    bulan INT NOT NULL,
    tahun INT NOT NULL,
    total_kwh DECIMAL(10,2) NOT NULL,
    total_tagihan DECIMAL(10,2) NOT NULL,
    status ENUM('Lunas', 'Belum Lunas') DEFAULT 'Belum Lunas',
    FOREIGN KEY (penggunaan_id) REFERENCES penggunaan(penggunaan_id),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(pelanggan_id)
);
```

## 🎮 CONTROLLER & MODEL

### Admin Controllers

#### 1. Dashboard Controller
**File**: `application/controllers/Admin/Dashboard.php`
**Fitur**:
- Dashboard dengan statistik
- Profil admin
- Ganti password
- Logout

**Methods**:
- `index()`: Dashboard utama dengan statistik
- `profile()`: Halaman profil admin
- `change_password()`: Ganti password
- `logout()`: Logout admin

#### 2. Pelanggan Controller
**File**: `application/controllers/Admin/Pelanggan.php`
**Fitur**:
- CRUD data pelanggan
- Search pelanggan
- View detail pelanggan

**Methods**:
- `index()`: List semua pelanggan
- `add()`: Tambah pelanggan baru
- `edit($id)`: Edit data pelanggan
- `delete($id)`: Hapus pelanggan
- `view($id)`: Detail pelanggan
- `search()`: Cari pelanggan

#### 3. Penggunaan Controller
**File**: `application/controllers/Admin/Penggunaan.php`
**Fitur**:
- CRUD data penggunaan listrik
- Auto-generate tagihan
- Statistik penggunaan

**Methods**:
- `index()`: List semua penggunaan
- `add()`: Tambah penggunaan baru
- `edit($id)`: Edit penggunaan
- `delete($id)`: Hapus penggunaan
- `view($id)`: Detail penggunaan
- `statistics()`: Statistik penggunaan
- `by_customer($id)`: Penggunaan per pelanggan

#### 4. Tagihan Controller
**File**: `application/controllers/Admin/Tagihan.php`
**Fitur**:
- Kelola tagihan listrik
- Generate tagihan otomatis
- Update status pembayaran
- Print tagihan

**Methods**:
- `index()`: List semua tagihan
- `generate($id)`: Generate tagihan dari penggunaan
- `generate_all()`: Generate semua tagihan
- `update_status($id)`: Update status tagihan
- `view($id)`: Detail tagihan
- `by_status($status)`: Tagihan per status
- `by_customer($id)`: Tagihan per pelanggan
- `by_period()`: Tagihan per periode
- `statistics()`: Statistik tagihan
- `print_bill($id)`: Print tagihan

#### 5. Level Controller
**File**: `application/controllers/Admin/Level.php`
**Fitur**:
- CRUD level tarif listrik
- Import/Export CSV
- Statistik tarif

**Methods**:
- `index()`: List semua level
- `add()`: Tambah level baru
- `edit($id)`: Edit level
- `delete($id)`: Hapus level
- `view($id)`: Detail level
- `statistics()`: Statistik level
- `import()`: Import dari CSV
- `export()`: Export ke CSV

### Pelanggan Controllers

#### 1. Dashboard Controller
**File**: `application/controllers/Pelanggan/Dashboard.php`
**Fitur**:
- Dashboard pelanggan
- Informasi pelanggan
- Statistik penggunaan dan tagihan

#### 2. Profil Controller
**File**: `application/controllers/Pelanggan/Profil.php`
**Fitur**:
- View profil
- Edit profil
- Ganti password

#### 3. Penggunaan Controller
**File**: `application/controllers/Pelanggan/Penggunaan.php`
**Fitur**:
- Lihat penggunaan listrik
- Statistik penggunaan
- Export PDF

#### 4. Tagihan Controller
**File**: `application/controllers/Pelanggan/Tagihan.php`
**Fitur**:
- Lihat tagihan listrik
- Filter tagihan
- Print tagihan
- Export PDF

### Models

#### 1. User Model
**File**: `application/models/User_model.php`
**Fitur**:
- CRUD user
- Authentication
- Password hashing
- Role management

#### 2. Pelanggan Model
**File**: `application/models/Pelanggan_model.php`
**Fitur**:
- CRUD pelanggan
- Search pelanggan
- Get pelanggan by user
- Join dengan level

#### 3. Penggunaan Model
**File**: `application/models/Penggunaan_model.php`
**Fitur**:
- CRUD penggunaan
- Statistik penggunaan
- Check usage exists
- Get by period

#### 4. Tagihan Model
**File**: `application/models/Tagihan_model.php`
**Fitur**:
- CRUD tagihan
- Generate tagihan otomatis
- Statistik tagihan
- Filter by status/period

#### 5. Level Model
**File**: `application/models/Level_model.php`
**Fitur**:
- CRUD level
- Check daya exists
- Get with customer count
- Statistik tarif

## 🎨 VIEWS & UI

### Admin Views

#### 1. Dashboard View
**File**: `application/views/admin/dashboard.php`
**Fitur**:
- Sidebar navigation
- Statistics cards
- Recent data tables
- Responsive design

#### 2. Login View
**File**: `application/views/auth/login.php`
**Fitur**:
- Modern gradient design
- Form validation
- Flash messages
- Responsive layout

### Pelanggan Views

#### 1. Dashboard View
**File**: `application/views/pelanggan/dashboard.php`
**Fitur**:
- Customer information
- Usage statistics
- Recent bills
- Responsive design

## 🔄 FITUR & WORKFLOW

### Workflow Admin

#### 1. Login Admin
```
1. Admin akses halaman login
2. Input username dan password
3. Sistem validasi credentials
4. Redirect ke dashboard admin
```

#### 2. Kelola Pelanggan
```
1. Admin buat akun user untuk pelanggan
2. Admin input data pelanggan (nama, alamat, level daya)
3. Sistem simpan data pelanggan
4. Pelanggan bisa login dengan akun yang dibuat
```

#### 3. Input Penggunaan Listrik
```
1. Admin input data penggunaan (meter awal, meter akhir)
2. Sistem validasi data
3. Sistem hitung total KWH
4. Sistem auto-generate tagihan
5. Tagihan tersimpan dengan status "Belum Lunas"
```

#### 4. Kelola Tagihan
```
1. Admin lihat daftar tagihan
2. Admin update status tagihan (Lunas/Belum Lunas)
3. Admin print tagihan
4. Admin lihat statistik tagihan
```

### Workflow Pelanggan

#### 1. Login Pelanggan
```
1. Pelanggan akses halaman login
2. Input username dan password
3. Sistem validasi credentials
4. Redirect ke dashboard pelanggan
```

#### 2. Lihat Penggunaan Listrik
```
1. Pelanggan akses menu "Penggunaan Listrik"
2. Sistem tampilkan data penggunaan pelanggan
3. Pelanggan lihat statistik penggunaan
4. Pelanggan export laporan PDF
```

#### 3. Lihat Tagihan Listrik
```
1. Pelanggan akses menu "Tagihan Listrik"
2. Sistem tampilkan daftar tagihan pelanggan
3. Pelanggan lihat detail tagihan
4. Pelanggan print tagihan
```

## ⚙️ INSTALASI & KONFIGURASI

### Prerequisites
- PHP 8.2+
- MySQL 5.7+ atau MariaDB 10.2+
- Apache/Nginx web server
- Composer (optional)

### Langkah Instalasi

#### 1. Clone/Download Project
```bash
# Clone dari repository (jika ada)
git clone [repository-url]
cd tes-pln

# Atau download dan extract file
```

#### 2. Konfigurasi Database
```bash
# Buat database baru
CREATE DATABASE tes_pln;

# Import struktur database
mysql -u username -p tes_pln < database.sql
```

#### 3. Konfigurasi Application
```php
// application/config/database.php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'tes_pln',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

#### 4. Konfigurasi Base URL
```php
// application/config/config.php
$config['base_url'] = 'http://localhost/tes-pln/';
```

#### 5. Set Permissions
```bash
# Set write permissions untuk folder yang diperlukan
chmod 755 application/cache/
chmod 755 application/logs/
chmod 755 uploads/  # Jika ada folder upload
```

#### 6. Create Admin User
```sql
-- Insert admin user default
INSERT INTO users (username, password, nama, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');
-- Password: password
```

### Konfigurasi Server

#### Apache (.htaccess)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

#### Nginx
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

## 🧪 TESTING & DEPLOYMENT

### Testing

#### 1. Unit Testing
```bash
# Test database connection
php index.php

# Test login functionality
# Akses: http://localhost/tes-pln/auth/login
```

#### 2. Integration Testing
```bash
# Test admin workflow
1. Login sebagai admin
2. Buat pelanggan baru
3. Input penggunaan listrik
4. Generate tagihan
5. Update status tagihan

# Test pelanggan workflow
1. Login sebagai pelanggan
2. Lihat dashboard
3. Lihat penggunaan listrik
4. Lihat tagihan listrik
```

#### 3. Security Testing
```bash
# Test authentication
- Coba akses halaman admin tanpa login
- Coba akses halaman pelanggan tanpa login
- Test session timeout

# Test authorization
- Coba akses halaman admin sebagai pelanggan
- Coba akses halaman pelanggan sebagai admin
```

### Deployment

#### 1. Production Checklist
- [ ] Set `ENVIRONMENT = 'production'` di `index.php`
- [ ] Disable error reporting di production
- [ ] Set proper database credentials
- [ ] Configure SSL certificate
- [ ] Set proper file permissions
- [ ] Configure backup strategy

#### 2. Performance Optimization
```php
// Enable caching
$config['cache_on'] = TRUE;

// Enable compression
$config['compress_output'] = TRUE;

// Optimize database queries
// Use proper indexes on database tables
```

#### 3. Security Hardening
```php
// Enable CSRF protection
$config['csrf_protection'] = TRUE;

// Set secure session configuration
$config['sess_secure'] = TRUE;
$config['sess_httponly'] = TRUE;
```

## 📊 FITUR TAMBAHAN

### 1. Export/Import Data
- Export data ke CSV/Excel
- Import data dari CSV
- Backup database otomatis

### 2. Notifikasi
- Email notification untuk tagihan baru
- SMS notification (integrasi third-party)
- Push notification

### 3. Payment Integration
- Integrasi payment gateway
- QRIS payment
- Bank transfer integration

### 4. Mobile App
- React Native mobile app
- API endpoints untuk mobile
- Offline capability

### 5. Advanced Analytics
- Chart.js untuk visualisasi data
- Predictive analytics
- Machine learning untuk prediksi penggunaan

## 🐛 TROUBLESHOOTING

### Common Issues

#### 1. Database Connection Error
```bash
# Check database configuration
# Verify database credentials
# Check if MySQL service is running
```

#### 2. 404 Error
```bash
# Check .htaccess file
# Verify mod_rewrite is enabled
# Check base_url configuration
```

#### 3. Session Issues
```bash
# Check session configuration
# Verify session save path
# Check file permissions
```

#### 4. PHP 8.2 Compatibility
```bash
# Update deprecated functions
# Check for dynamic property creation
# Update third-party libraries
```

## 📞 SUPPORT

### Contact Information
- **Developer**: [Your Name]
- **Email**: [your.email@domain.com]
- **Phone**: [your-phone-number]

### Documentation Links
- [CodeIgniter 3 Documentation](https://codeigniter.com/userguide3/)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.1/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

**© 2024 Sistem Pembayaran Listrik. All rights reserved.** 