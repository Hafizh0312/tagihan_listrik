-- Database: tes_pln
-- Sistem Pembayaran Listrik Pascabayar

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS tes_pln;
USE tes_pln;

-- Table: users
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'pelanggan') DEFAULT 'pelanggan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: levels (tarif listrik)
CREATE TABLE levels (
    level_id INT PRIMARY KEY AUTO_INCREMENT,
    daya INT NOT NULL,
    tarif_per_kwh DECIMAL(10,2) NOT NULL
);

-- Table: pelanggan
CREATE TABLE pelanggan (
    pelanggan_id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    user_id INT,
    level_id INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (level_id) REFERENCES levels(level_id) ON DELETE SET NULL
);

-- Table: penggunaan (penggunaan listrik)
CREATE TABLE penggunaan (
    penggunaan_id INT PRIMARY KEY AUTO_INCREMENT,
    pelanggan_id INT,
    bulan INT NOT NULL,
    tahun INT NOT NULL,
    meter_awal DECIMAL(10,2) NOT NULL,
    meter_akhir DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(pelanggan_id) ON DELETE CASCADE
);

-- Table: tagihan
CREATE TABLE tagihan (
    tagihan_id INT PRIMARY KEY AUTO_INCREMENT,
    penggunaan_id INT,
    pelanggan_id INT,
    bulan INT NOT NULL,
    tahun INT NOT NULL,
    total_kwh DECIMAL(10,2) NOT NULL,
    total_tagihan DECIMAL(10,2) NOT NULL,
    status ENUM('Lunas', 'Belum Lunas') DEFAULT 'Belum Lunas',
    FOREIGN KEY (penggunaan_id) REFERENCES penggunaan(penggunaan_id) ON DELETE CASCADE,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(pelanggan_id) ON DELETE CASCADE
);

-- Insert default admin user
-- Password: admin123 (hashed with password_hash)
INSERT INTO users (username, password, nama, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Insert default levels (tarif listrik)
INSERT INTO levels (daya, tarif_per_kwh) VALUES 
(450, 415.0),
(900, 445.0),
(1300, 445.0),
(2200, 445.0),
(3500, 445.0),
(5500, 445.0),
(6600, 445.0),
(10600, 445.0),
(13200, 445.0),
(16500, 445.0),
(23000, 445.0),
(33000, 445.0),
(41000, 445.0),
(53000, 445.0),
(66000, 445.0),
(82000, 445.0),
(106000, 445.0),
(132000, 445.0),
(165000, 445.0),
(230000, 445.0),
(330000, 445.0);

-- Insert sample customer
INSERT INTO users (username, password, nama, role) VALUES 
('pelanggan1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John Doe', 'pelanggan');

INSERT INTO pelanggan (nama, alamat, user_id, level_id) VALUES 
('John Doe', 'Jl. Contoh No. 123, Jakarta', 2, 1);

-- Insert sample usage data
INSERT INTO penggunaan (pelanggan_id, bulan, tahun, meter_awal, meter_akhir) VALUES 
(1, 1, 2024, 0.00, 150.50),
(1, 2, 2024, 150.50, 320.75),
(1, 3, 2024, 320.75, 480.25);

-- Insert sample bills
INSERT INTO tagihan (penggunaan_id, pelanggan_id, bulan, tahun, total_kwh, total_tagihan, status) VALUES 
(1, 1, 1, 2024, 150.50, 62457.50, 'Lunas'),
(2, 1, 2, 2024, 170.25, 70653.75, 'Belum Lunas'),
(3, 1, 3, 2024, 159.50, 66192.50, 'Belum Lunas');

-- Create indexes for better performance
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_pelanggan_user_id ON pelanggan(user_id);
CREATE INDEX idx_penggunaan_pelanggan_id ON penggunaan(pelanggan_id);
CREATE INDEX idx_penggunaan_period ON penggunaan(pelanggan_id, bulan, tahun);
CREATE INDEX idx_tagihan_pelanggan_id ON tagihan(pelanggan_id);
CREATE INDEX idx_tagihan_status ON tagihan(status);
CREATE INDEX idx_tagihan_period ON tagihan(bulan, tahun); 